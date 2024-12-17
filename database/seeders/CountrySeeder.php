<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('database/seeders/files/countries.csv');

        $file = fopen($path, 'r');

        while (($line = fgetcsv($file, separator: ';')) !== false) {
            $country = new Country;
            $country->name = $line[1];
            $country->code = $line[2];
            $country->save();
        }
    }
}
