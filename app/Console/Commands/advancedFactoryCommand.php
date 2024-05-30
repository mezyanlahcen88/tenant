<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AdvancedFactoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module-factory {name : The name of the model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a factory from a model file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');


        $className = ucfirst($name) . 'Factory';
        $modelName = ucfirst($name);

        // Check if the model file exists
        $stub = File::get(app_path('Console/Commands/stubs/factory.stub'));
        // Replace occurrences of the "{{class}}" keyword with the provided model name argument
        $stub = str_replace('{{className}}', $className, $stub);
        $stub = str_replace('{{modelName}}', $modelName, $stub);

        // Generate a unique factory file name
        $filename = $name . 'Factory.php';

        // Save the factory content in the factories directory
        $filePath = base_path('Modules/'.$modelName.'/database/factories/' . $filename);
        if (File::exists($filePath)) {
            $this->error('Factory file already exists!');
            return;
        }
        File::put($filePath, $stub);

        $this->info($filename .' generated successfully inside Module: ' . $modelName);
    }
}
