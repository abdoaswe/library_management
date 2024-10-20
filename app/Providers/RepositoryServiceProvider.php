<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BookRepositoryInterface;
use App\Repositories\BookRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\BorrowingRepositoryInterface;
use App\Repositories\BorrowingRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(BorrowingRepositoryInterface::class, BorrowingRepository::class);
    }

    public function boot()
    {
        //
    }
}
