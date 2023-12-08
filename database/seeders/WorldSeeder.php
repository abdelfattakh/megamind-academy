<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;

class WorldSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        $allowedCountries = ['EG', 'AE', 'SA', 'KW'];
        $countries = Items::fromFile(database_path('sql/countries+states+cities.json'));

        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Country::query()->truncate();
        City::query()->truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($countries as $id => $country) {
            if (!in_array($country->iso2, $allowedCountries)) {
                continue;
            }

            $this->command->info("Adding Country {$country->id} {$country->iso2}");

            /** @var Country $c */
            $c = Country::query()->create([
                'id' => $country->id,
                'code' => $country->iso2,
                'name' => [
                    'en' => $country->name,
                    'ar' => $country->translations?->fa ?? null,
                ],
                'is_active' => true,
            ]);

            foreach ($country->states as $state) {
                /** @var City $s */
                $s = $c->cities()->create([
                    'id' => $state->id,
                    'name' => [
                        'en' => $state->name,
                        'ar' => $state->name,
                    ],

                    'is_active' => true,
                ]);
            }
        }
    }
}
