<?php

namespace Lixr\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateVueRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate route';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $collect = collect(\Route::getRoutes())
        ->map(function ($route) {
            if(!empty($route->getName())){

                return [
                    'uri' => '/'. $route->uri(),
                    'name' => $route->getName()
                ];
            }
        });

        $routes = array_values(array_filter($collect->toArray()));


        try{
            File::put($this->route(), $this->generateFile(json_encode($routes)));
        }catch(Exception $e){
            return $e->getMessages();
        }

        return $this->info('Success');
        
    }

    public function route()
    {
        return resource_path('js/mixins/routes.js');
    }

    public function generateFile($routes)
    {
        $stub = file_get_contents(app_path('Tenant/Traits/stubs/VueRoute.stub'));

        return str_replace('***', $routes, $stub);
    }
}
