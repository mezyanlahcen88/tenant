<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LanguagesTableSeeder::class,
            CountriesTableSeeder::class,
            GroupeSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            LanguageTranslateSeeder::class,
            // SettingSeeder::class,

        ]);


    }
}
