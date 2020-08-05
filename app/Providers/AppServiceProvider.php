<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
        app('view')->composer("*", function ($view) {
            if (app("request")->route() != null) {
                $action = app("request")->route()->getAction();

                $controller = class_basename($action["controller"]);

                list($controller_name, $action_name) = explode("@", $controller);

                $view->with(compact("controller_name", "action_name"));
            }
        });
    }

}
