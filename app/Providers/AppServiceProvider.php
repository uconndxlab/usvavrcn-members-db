<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Entity;
use App\Models\Post;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::define('edit-member', function (User $user, Entity $member) {
            return $user->is_admin || $user->entity->id === $member->id;
        });

        Gate::define('delete-post', function (User $user, Post $post) {
            return $user->is_admin || $user->entity->id === $post->entity_id;
        });
    }
}
