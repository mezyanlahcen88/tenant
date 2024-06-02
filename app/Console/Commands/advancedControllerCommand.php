<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class advancedControllerCommand extends Command
{
    protected $signature = 'make:module-controller {name : The name of the controller class}';

    protected $description = 'Create a new Advaced controller class';

    public function handle()
    {
        $name = $this->argument('name');
        $lowerName = strtolower($name);
        $pluralName = Str::plural($lowerName);
        $className = ucfirst($name) . 'Controller';
        $modelName = ucfirst($name);

        $stub = File::get(app_path('Console/Commands/stubs/controller.stub'));
        $stub = str_replace('{{class}}', $className, $stub);
        $stub = str_replace('{{model}}', $modelName, $stub);
        $stub = str_replace('{{lower}}', $lowerName, $stub);
        $stub = str_replace('{{plural}}', $pluralName, $stub);

                // delete folder controllers
                $directoryPath = base_path('Modules/'.$modelName.'/App/Http/Controllers');
                File::deleteDirectory($directoryPath);
                // // Create the directory first

                File::makeDirectory($directoryPath, 0755, true);
// Generate a unique factory file name
     $filename = $name . 'Controller.php';
        $filePath = base_path('Modules/'.$modelName.'/App/Http/Controllers/' . $filename);
        if (File::exists($filePath)) {
            $this->error('Controller class already exists!');
            return;
        }

        File::put($filePath, $stub);

        $this->info('Controller class created successfully!');
    }
}
