<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Policies\BookPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\AuthorPolicy;
use App\Policies\PublisherPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Book::class => BookPolicy::class,
        Category::class => CategoryPolicy::class,
        Author::class => AuthorPolicy::class,
        Publisher::class => PublisherPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para verificar se é admin
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        // Gate para verificar se pode gerenciar livros
        Gate::define('manage-books', function (User $user) {
            return $user->canManageBooks();
        });
    }
}