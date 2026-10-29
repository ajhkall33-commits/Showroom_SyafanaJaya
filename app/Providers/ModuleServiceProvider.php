<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $modulesPath = app_path('Modules');

        if (!File::isDirectory($modulesPath)) {
            return;
        }

        $modules = array_map('basename', File::directories($modulesPath));

        foreach ($modules as $module) {
            // 1. Register Views
            $viewsPath = $modulesPath . '/' . $module . '/Views';
            if (File::isDirectory($viewsPath)) {
                $this->loadViewsFrom($viewsPath, $module);
                $this->loadViewsFrom($viewsPath, strtolower($module));
                $this->app['view']->getFinder()->addLocation($viewsPath);
            }

            // 2. Register Routes
            $routesPath = $modulesPath . '/' . $module . '/Routes/web.php';
            if (File::isFile($routesPath)) {
                Route::middleware('web')
                    ->namespace("App\\Modules\\{$module}\\Controllers")
                    ->group($routesPath);
            }

            // 3. Register Migrations if any
            $migrationsPath = $modulesPath . '/' . $module . '/Database/Migrations';
            if (File::isDirectory($migrationsPath)) {
                $this->loadMigrationsFrom($migrationsPath);
            }

            // 4. Auto-register Model Aliases (Zero File in app/, Zero Breaking Changes)
            $modelsPath = $modulesPath . '/' . $module . '/Models';
            if (File::isDirectory($modelsPath)) {
                $modelFiles = File::files($modelsPath);
                foreach ($modelFiles as $mf) {
                    $mName = $mf->getFilenameWithoutExtension();
                    $fullClass = "App\\Modules\\{$module}\\Models\\{$mName}";
                    if (class_exists($fullClass)) {
                        $aliases = [
                            "App\\{$mName}",
                            "App\\" . ucfirst($mName),
                            "App\\" . lcfirst($mName),
                        ];
                        foreach ($aliases as $alias) {
                            if (!class_exists($alias, false)) {
                                class_alias($fullClass, $alias);
                            }
                        }
                    }
                }
            }
        }
    }
}
