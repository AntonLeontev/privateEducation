<?php

namespace App\Console\Commands;

use App\DTOs\CurrencyRateDTO;
use App\Models\CurrencyRate;
use App\Services\CurrencyRatesService\CurrencyRatesService;
use Illuminate\Console\Command;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates currency rates';

    /**
     * Execute the console command.
     */
    public function handle(CurrencyRatesService $service)
    {
        $usd = $service->getEurToUsd();
        $rub = $service->getEurToRub();

        $this->update($usd);
        $this->update($rub);
    }

    private function update(CurrencyRateDTO $rate)
    {
        CurrencyRate::updateOrCreate(
            [
                'name' => $rate->name,
            ],
            [
                'date' => $rate->date,
                'rate' => $rate->rate,
            ]
        );
    }
}
