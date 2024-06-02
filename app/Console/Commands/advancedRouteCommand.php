<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class advancedRouteCommand extends Command
{
    protected $signature = 'make:module-route {name : The name of the route}';

    protected $description = 'Create a new route';

    public function handle()
    {

        $name = $this->argument('name');
        $lowerName = strtolower($name);
        $plural = Str::plural($lowerName);
        $modelName = ucfirst($name);
        // delete folder views
        $directoryPath = base_path('Modules/'.$modelName.'/routes');
        File::deleteDirectory($directoryPath);
        // // Create the directory first
        File::makeDirectory($directoryPath, 0755, true);


        // Get the content of the stub file
        $stub = File::get(app_path('Console/Commands/stubs/route.stub'));
        $apiStub = File::get(app_path('Console/Commands/stubs/api.stub'));


        // Replace placeholders in the stub content
        $stub = str_replace('{{model}}', $name, $stub);
        $stub = str_replace('{{lowerName}}', $lowerName, $stub);
        $stub = str_replace('{{plural}}', $plural, $stub);

        $filePath = base_path('Modules/'.$modelName.'/routes/web.php');
        $apiPath = base_path('Modules/'.$modelName.'/routes/api.php');

        if (File::exists($filePath)) {
            $this->error('route file already exists!');
            return;
        }
        File::put($filePath, $stub);
        File::put($apiPath, $apiStub);
        $this->info('route file created successfully!');
    }
}
