<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class AddRouteToWeb extends Command
{
    protected $signature = 'route:add {name}';

    protected $description = 'Add a new route to web.php';

    public function handle()
    {
        $path = $this->argument('name');
 ############################### Bank ###############################
        // require __DIR__ . '/base/'.$path.'Route.php';
        require_once(__DIR__.'/../routes/base/'.$path.'Route.php');

        $this->info("Route added successfully");
    }
}
