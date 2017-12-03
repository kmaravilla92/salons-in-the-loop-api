<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\FirebaseClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // dd(env('FIREBASE_ENABLED'));
        if(env('FIREBASE_ENABLED')){
            $this->app->bind(FirebaseClient::class, function(){
                return (new FirebaseClient);
            });
        }
    }
}
