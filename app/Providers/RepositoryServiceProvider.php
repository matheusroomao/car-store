<?php

namespace App\Providers;

use App\Repository\Admin\Business\BrandRepository;
use App\Repository\Admin\Business\CarItemRepository;
use App\Repository\Admin\Business\CarRepository;
use App\Repository\Admin\Business\ItemRepository;
use App\Repository\Admin\Business\UserRepository;
use App\Repository\Admin\Contract\BrandInterface;
use App\Repository\Admin\Contract\CarInterface;
use App\Repository\Admin\Contract\CarItemInterface;
use App\Repository\Admin\Contract\ItemInterface;
use App\Repository\Admin\Contract\UserInterface;
use App\Repository\LoginRepository;
use App\Repository\LoginInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(LoginInterface::class, LoginRepository::class);

        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(ItemInterface::class, ItemRepository::class);
        $this->app->bind(CarInterface::class, CarRepository::class);
        $this->app->bind(CarItemInterface::class, CarItemRepository::class);      
    }
}
