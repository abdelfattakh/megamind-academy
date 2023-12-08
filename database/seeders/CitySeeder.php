<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['name' => json_encode(["ar" => "الاسكندريه", "en" => "Alexandria"]), 'is_active' => 1, 'country_id' => 1],
            ['name' => json_encode(["ar" => " القاهره  ", "en" => " cairo"]), 'is_active' => 1, 'country_id' => 1],
            ['name' => json_encode(["ar" => " الرياض  ", "en" => " Ryadh"]), 'is_active' => 1, 'country_id' => 2],
            ['name' => json_encode(["ar" => "جده", "en" => "Jeddah"]), 'is_active' => 1, 'country_id' => 2],
            ['name' => json_encode(["ar" => "كاليفورنيا", "en" => "california"]), 'is_active' => 1, 'country_id' => 3],
            ['name' => json_encode(["ar" => "اورلاندو", "en" => "orlando"]), 'is_active' => 1, 'country_id' => 3],
        ];
        City::Insert($cities);
    }
}
