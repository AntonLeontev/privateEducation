<?php

namespace App\Console\Commands;

use App\Services\YaTranslate\Enums\Format;
use App\Services\YaTranslate\Enums\Lang;
use App\Services\YaTranslate\TranslateApi;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class GenerateTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:generate
                            {from : Исходный язык (код и имя директории в папке lang)}
                            {to : Целевой язык (код и имя директории в папке lang)}
                            {--force : Перезаписать уже существующие переводы}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Рекурсивно создает файлы переводов из одного языка в другой в директории lang, переводя только значения массивов.';

    /**
     * Ошибки, произошедшие при переводе отдельных строк.
     *
     * @var array<int, array{key:string,file:string,message:string}>
     */
    protected array $errors = [];

    /**
     * Текущий прогресс-бар для обрабатываемого файла.
     */
    protected ?ProgressBar $progressBar = null;

    public function __construct(private TranslateApi $translateApi)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $from = (string) $this->argument('from');
        $to = (string) $this->argument('to');
        $force = (bool) $this->option('force');

        $fromPath = base_path('lang'.DIRECTORY_SEPARATOR.$from);
        $toPath = base_path('lang'.DIRECTORY_SEPARATOR.$to);

        if (! is_dir($fromPath)) {
            $this->error("Директория исходного языка [{$from}] не найдена по пути [{$fromPath}].");

            return 1;
        }

        if (! is_dir($toPath)) {
            if (! mkdir($toPath, 0755, true) && ! is_dir($toPath)) {
                $this->error("Не удалось создать директорию целевого языка по пути [{$toPath}].");

                return 1;
            }
        }

        $filesProcessed = $this->processDirectory($fromPath, $toPath, $force);

        $this->info("Обработано файлов переводов: {$filesProcessed} (из [{$from}] в [{$to}]).");

        if (! empty($this->errors)) {
            $this->error('При переводе возникли ошибки:');

            foreach ($this->errors as $error) {
                $this->line(sprintf(
                    '- [%s] %s: %s',
                    $error['file'],
                    $error['key'],
                    $error['message']
                ));
            }
        }

        return 0;
    }

    /**
     * Рекурсивно обрабатывает файлы переводов из исходной директории в целевую.
     */
    protected function processDirectory(string $fromPath, string $toPath, bool $force): int
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($fromPath, \FilesystemIterator::SKIP_DOTS)
        );

        $count = 0;

        /** @var \SplFileInfo $file */
        foreach ($iterator as $file) {
            if (! $file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $sourceFile = $file->getPathname();
            $relativePath = ltrim(
                str_replace($fromPath, '', $sourceFile),
                DIRECTORY_SEPARATOR
            );

            $targetFile = $toPath.DIRECTORY_SEPARATOR.$relativePath;
            $targetDir = dirname($targetFile);

            if (! is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $this->line("Обработка файла: {$relativePath}");

            $source = include $sourceFile;
            if (! is_array($source)) {
                // Пропускаем файлы, которые не возвращают массив.
                continue;
            }

            $existing = [];
            if (is_file($targetFile)) {
                $existingData = include $targetFile;
                if (is_array($existingData)) {
                    $existing = $existingData;
                }
            }

            $totalItems = $this->countLeafItems($source);

            if ($totalItems > 0) {
                $this->progressBar = $this->output->createProgressBar($totalItems);
                $this->progressBar->start();
            }

            $translated = $this->translateArray($source, $existing, $force, '', $relativePath);

            if ($this->progressBar !== null) {
                $this->progressBar->finish();
                $this->newLine(2);
                $this->progressBar = null;
            }

            $this->writePhpFile($targetFile, $translated);

            $count++;
        }

        return $count;
    }

    /**
     * Рекурсивно переводит значения массива, не изменяя ключи.
     * Использует уже существующие переводы, если они есть и не передан флаг --force.
     *
     * @param  array<string, mixed>  $source
     * @param  array<string, mixed>  $existing
     */
    protected function translateArray(
        array $source,
        array $existing,
        bool $force,
        string $path = '',
        string $file = ''
    ): array {
        $result = [];

        foreach ($source as $key => $value) {
            $currentPath = $path === '' ? (string) $key : $path.'.'.$key;

            if (is_array($value)) {
                $existingSub = [];
                if (array_key_exists($key, $existing) && is_array($existing[$key])) {
                    $existingSub = $existing[$key];
                }

                $result[$key] = $this->translateArray($value, $existingSub, $force, $currentPath, $file);

                continue;
            }

            if (! $force && array_key_exists($key, $existing)) {
                // Строка уже переведена — возвращаем существующий перевод.
                $result[$key] = $existing[$key];

                $this->advanceProgress();

                continue;
            }

            try {
                // Переводим только значение, ключ остается прежним.
                $translated = $this->translateString((string) $value);
            } catch (\Throwable $e) {
                $message = $e->getMessage();

                $this->errors[] = [
                    'key' => $currentPath,
                    'file' => $file,
                    'message' => $message,
                ];

                $this->advanceProgress();

                continue;
            }

            $result[$key] = $translated;

            $this->advanceProgress();
        }

        return $result;
    }

    /**
     * Перевод одной строки.
     * Сейчас заглушка, всегда возвращает 'test'.
     */
    protected function translateString(string $value): string
    {
        if ($value === '') {
            return '';
        }

        return $this->translateApi->translate([$value], Lang::from($this->argument('to')), Format::HTML)
            ->json('translations.0.text');
    }

    /**
     * Подсчитать количество всех конечных элементов (не-массивов) в массиве.
     *
     * @param  array<string, mixed>  $source
     */
    protected function countLeafItems(array $source): int
    {
        $count = 0;

        foreach ($source as $value) {
            if (is_array($value)) {
                $count += $this->countLeafItems($value);

                continue;
            }

            $count++;
        }

        return $count;
    }

    /**
     * Сдвиг прогресс-бара, если он инициализирован.
     */
    protected function advanceProgress(): void
    {
        if ($this->progressBar !== null) {
            $this->progressBar->advance();
        }
    }

    /**
     * Записывает массив переводов в PHP-файл, который возвращает этот массив.
     */
    protected function writePhpFile(string $path, array $data): void
    {
        $export = var_export($data, true);
        $content = "<?php\n\nreturn {$export};\n";

        file_put_contents($path, $content);
    }
}
