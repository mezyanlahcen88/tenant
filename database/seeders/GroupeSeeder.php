<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groupes')->insert([
            ['name' => 'User', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],//01
            ['name' => 'Role', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],//02
            ['name' => 'Country', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],//003
            ['name' => 'System Language', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],//04
            ['name' => 'Setting', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],//05
            ['name' => 'Sidebar', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],//06
        ]);
    }
}
