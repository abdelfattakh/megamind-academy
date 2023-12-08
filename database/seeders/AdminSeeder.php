<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'Master Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
                'role' => config('filament-shield.super_admin.name')
            ],
            [
                'name' => 'AQuadic Administrator',
                'email' => 'admin@aquadic.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
                'role' => config('filament-shield.super_admin.name')
            ],
            [
                'name' => 'Aliaa Khalid Hussien',
                'email' => 'aliaa@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'AMANY',
                'email' => 'amany@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'Asmaa alkout',
                'email' => 'asmaa-alkout@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'Asmaa Zied',
                'email' => 'asmaa-zied@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'Aya Fayez Said',
                'email' => 'aya@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'Aya Fayez Said',
                'email' => 'dena@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'Esraa Salah',
                'email' => 'esraa-salah@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'habiba',
                'email' => 'habiba@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'khaled',
                'email' => 'khaled@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'Renad',
                'email' => 'renad@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'Rowan Nabil',
                'email' => 'rowan-nabil@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'sara-G',
                'email' => 'sara-g@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
            [
                'name' => 'shrouk gomaa',
                'email' => 'shrouk-gomaa@megaminds-academy.com',
                'password' => Hash::make('password'),
                'phone_country' => null,
                'phone' => null,
            ],
        ])->each(function ($admin) {
            $this->command->info("Creating {$admin['email']} Administrator");

            /** @var Admin $admin */
            $admin = Admin::query()->updateOrCreate([
                'email' => $admin['email'],
            ], [
                'name' => $admin['name'],
                'password' => $admin['password'],
                'phone_country' => $admin['phone_country'],
                'phone' => $admin['phone'],
            ]);

            $admin->markEmailAsVerified();

            $admin->assignRole($admin['role'] ?? 'instructor');
        });
    }
}
