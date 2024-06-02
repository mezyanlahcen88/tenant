<?php

namespace Database\Seeders;

// use App\Models\Permission as ModelsPermission;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        DB::table('permissions')->insert([
            ['name' => 'user-create', 'libele' => 'User Create', 'guard_name' => 'web', 'groupe_id' =>1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'user-show', 'libele' => 'User Show', 'guard_name' => 'web', 'groupe_id' =>1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'user-edit', 'libele' => 'User Edit', 'guard_name' => 'web', 'groupe_id' =>1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'user-delete', 'libele' => 'User Delete', 'guard_name' => 'web', 'groupe_id' =>1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'user-list', 'libele' => 'User List', 'guard_name' => 'web', 'groupe_id' =>1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role-create', 'libele' => 'Role Create', 'guard_name' => 'web', 'groupe_id' =>2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role-show', 'libele' => 'Role Show', 'guard_name' => 'web', 'groupe_id' =>2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role-edit', 'libele' => 'Role Edit', 'guard_name' => 'web', 'groupe_id' =>2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role-delete', 'libele' => 'Role Delete', 'guard_name' => 'web', 'groupe_id' =>2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role-list', 'libele' => 'Role List', 'guard_name' => 'web', 'groupe_id' =>2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'country-create', 'libele' => 'Country Create', 'guard_name' => 'web', 'groupe_id' =>3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'country-show', 'libele' => 'Country Show', 'guard_name' => 'web', 'groupe_id' =>3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'country-edit', 'libele' => 'Country Edit', 'guard_name' => 'web', 'groupe_id' =>3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'country-delete', 'libele' => 'Country Delete', 'guard_name' => 'web', 'groupe_id' =>3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'country-list', 'libele' => 'Country List', 'guard_name' => 'web', 'groupe_id' =>3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'systemlanguage-create', 'libele' => 'System language Create', 'guard_name' => 'web', 'groupe_id' =>4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'systemlanguage-show', 'libele' => 'System language Show', 'guard_name' => 'web', 'groupe_id' =>4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'systemlanguage-edit', 'libele' => 'System language Edit', 'guard_name' => 'web', 'groupe_id' =>4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'systemlanguage-delete', 'libele' => 'System language Delete', 'guard_name' => 'web', 'groupe_id' =>4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'systemlanguage-list', 'libele' => 'System language Featured', 'guard_name' => 'web', 'groupe_id' =>4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'systemlanguage-translation', 'libele' => 'System languageTranslation', 'guard_name' => 'web', 'groupe_id' =>4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'setting-create', 'libele' => 'Setting Create', 'guard_name' => 'web', 'groupe_id' =>5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting-show', 'libele' => 'Setting Show', 'guard_name' => 'web', 'groupe_id' =>5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting-edit', 'libele' => 'Setting Edit', 'guard_name' => 'web', 'groupe_id' =>5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting-delete', 'libele' => 'Setting Delete', 'guard_name' => 'web', 'groupe_id' =>5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting-list', 'libele' => 'Setting List', 'guard_name' => 'web', 'groupe_id' =>5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'sidebar-dashboard', 'libele' => 'Sidebar dashboard', 'guard_name' => 'web', 'groupe_id' =>6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'sidebar-manage-users', 'libele' => 'Sidebar manage users', 'guard_name' => 'web', 'groupe_id' =>6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'sidebar-ecommerce', 'libele' => 'Sidebar ecommerce', 'guard_name' => 'web', 'groupe_id' =>6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'sidebar-emails', 'libele' => 'Sidebar emails', 'guard_name' => 'web', 'groupe_id' =>6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'sidebar-countries', 'libele' => 'Sidebar countries', 'guard_name' => 'web', 'groupe_id' =>6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'sidebar-languages', 'libele' => 'Sidebar languages', 'guard_name' => 'web', 'groupe_id' =>6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'sidebar-payments', 'libele' => 'Sidebar payments', 'guard_name' => 'web', 'groupe_id' =>6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'sidebar-settings', 'libele' => 'Sidebar settings', 'guard_name' => 'web', 'groupe_id' =>6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);



    }
}



