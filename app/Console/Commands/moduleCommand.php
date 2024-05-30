<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class moduleCommand extends Command
{
    protected $signature = 'make:module {name}';

    protected $description = 'Speed up the creation of New Record';

    public function handle()
    {
        $name = $this->argument('name');
        $className = ucfirst($name);
        $lowerName = strtolower($name);
        $plural = Str::plural($lowerName);
        // Generate the module
        Artisan::call('module:make', ['name' => [$className]]);
        // Generate the advanced model
        Artisan::call('make:mdl', [
            'name' => "{$name}",
        ]);

        // // Generate the migration
        Artisan::call('make:module-migration', [
            'name' => "{$className}",
        ]);
        // // Generate the Factory
        Artisan::call('make:module-factory', [
            'name' => "{$className}",
        ]);

        // // Generate the seeder
        // Artisan::call('make:module-seeder', [
        //     'name' => "{$name}",
        // ]);



        // // Generate the advanced controller
        // Artisan::call('make:ctl', [
        //     'name' => "{$name}",
        // ]);

        // // view section
        // // Generate the advanced index
        // Artisan::call('make:index', [
        //     'name' => "{$name}",
        // ]);
        // // Generate the advanced create
        // Artisan::call('make:create', [
        //     'name' => "{$name}",
        // ]);
        // // Generate the advanced edit
        // Artisan::call('make:edit', [
        //     'name' => "{$name}",
        // ]);
        // // Generate the advanced trashed index
        // Artisan::call('make:trashedindex', [
        //     'name' => "{$name}",
        // ]);
        // // Generate the advanced action
        // Artisan::call('make:actions', [
        //     'name' => "{$name}",
        // ]);
        // // Generate the advanced trashed action
        // Artisan::call('make:tactions', [
        //     'name' => "{$name}",
        // ]);
        // // Generate the advanced trashed table
        // Artisan::call('make:trashedTable', [
        //     'name' => "{$name}",
        // ]);
        // // Generate the advanced  table
        // Artisan::call('make:table', [
        //     'name' => "{$name}",
        // ]);

        // // Generate the advanced form request
        // Artisan::call('make:formRequest', [
        //     'name' => "{$name}",
        // ]);
        // // Route section
        // // Generate the advanced route
        // Artisan::call('make:route', [
        //     'name' => "{$name}",
        // ]);
        $this->info('Module  created successfully!');
    }
}
