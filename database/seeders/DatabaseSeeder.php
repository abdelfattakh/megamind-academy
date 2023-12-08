<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // essential
            RoleSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,

            // real
            WorldSeeder::class,
            AgeSeeder::class,
            CategorySeeder::class,
            PositionSeeder::class,
            CourseSeeder::class,
            ReviewSeeder::class,
            SocialMediaSeeder::class,
            ProgramSeeder::class,
            PaymentMethodSeeder::class,
            SubscriptionSeeder::class,

            // fake.
//            CountrySeeder::class,
//            CitySeeder::class,
//            CareerSeeder::class,
//            GallerySeeder::class,
//            PartnerSeeder::class,
//            BookingSeeder::class,
        ]);
    }
}
