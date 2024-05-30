<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'make:module-seeder {name : The name of the table}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a seeder from a template file';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $lowerName = strtolower($name);
        $plural = Str::plural($lowerName);
        $modelName = ucfirst($name);


        // Check if the template file exists
        $stub = File::get(app_path('Console/Commands/stubs/seeder.stub'));

        $className = ucfirst($name) . 'Seeder';

        // Replace occurrences of the keyword "{name}" with the table name provided as an argument
        $stub = str_replace('{{name}}', $name, $stub);
        $stub = str_replace('{{class}}', $className, $stub);
        $stub = str_replace('{{plural}}', $plural, $stub);

        // Generate a unique seeder filename
        $filename = $name . 'Seeder.php';

        // Save the seeder content to the seeders directory
        $seederPath = base_path('Modules/'.$modelName.'/database/seeders/' . $filename);;
        File::put($seederPath, $stub);

        $this->info('Seeder generated successfully: ' . $filename);
    }
}
