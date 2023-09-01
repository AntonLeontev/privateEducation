<?php

namespace Database\Seeders;

use App\Models\Audio;
use App\Models\Media;
use App\Models\Presentation;
use App\Models\Video;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 17) as $val) {
            Media::create([
                'path' => str()->random(8).'.mov',
                'type' => 'video',
                'sound' => 'mono',
                'lang' => 'ru',
                'mediable_id' => $val,
                'mediable_type' => Presentation::class,
            ]);
            Media::create([
                'path' => str()->random(8).'.mov',
                'type' => 'video',
                'sound' => 'stereo',
                'lang' => 'ru',
                'mediable_id' => $val,
                'mediable_type' => Presentation::class,
            ]);

            Media::create([
                'path' => str()->random(8).'.mp3',
                'type' => 'audio',
                'sound' => 'mono',
                'lang' => 'ru',
                'mediable_id' => $val,
                'mediable_type' => Audio::class,
            ]);
            Media::create([
                'path' => str()->random(8).'.mp3',
                'type' => 'audio',
                'sound' => 'stereo',
                'lang' => 'ru',
                'mediable_id' => $val,
                'mediable_type' => Audio::class,
            ]);

            Media::create([
                'path' => str()->random(8).'.mov',
                'type' => 'video',
                'sound' => 'mono',
                'lang' => 'ru',
                'mediable_id' => $val,
                'mediable_type' => Video::class,
            ]);
            Media::create([
                'path' => str()->random(8).'.mov',
                'type' => 'video',
                'sound' => 'stereo',
                'lang' => 'ru',
                'mediable_id' => $val,
                'mediable_type' => Video::class,
            ]);
        }
    }
}
