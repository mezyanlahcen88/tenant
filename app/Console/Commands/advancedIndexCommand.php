<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class advancedIndexCommand extends Command
{
    protected $signature = 'make:index {name : The name of the index blade}';

    protected $description = 'Create a new index blade';

    public function handle()
    {

        $name = $this->argument('name');
        $lowerName = strtolower($name);
        $plural = Str::plural($lowerName);
        $modelName = ucfirst($name);
        // delete folder views
        $directoryPath = base_path('Modules/'.$modelName.'/resources/views');
        File::deleteDirectory($directoryPath);
        // // Create the directory first
        File::makeDirectory($directoryPath, 0755, true);

        // Get the content of the stub file
        $stub = File::get(app_path('Console/Commands/stubs/template/index.stub'));

        // Replace placeholders in the stub content
        $stub = str_replace('{{lowerName}}', $lowerName, $stub);
        $stub = str_replace('{{plural}}', $plural, $stub);

        // Create the Blade view file inside the new directory
        $filePath = "{$directoryPath}/index.blade.php";
        File::put($filePath, $stub);

        $this->info('index blade created successfully!');
    }

}
