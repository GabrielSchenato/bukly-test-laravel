<?php

namespace App\Providers;

use App\Repositories\Eloquent\HotelEloquentRepository;
use App\Repositories\Eloquent\RoomEloquentRepository;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            HotelRepositoryInterface::class,
            HotelEloquentRepository::class
        );
        $this->app->singleton(
            RoomRepositoryInterface::class,
            RoomEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
