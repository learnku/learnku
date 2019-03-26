<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Horizon\Horizon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		 \App\Models\BlogReply::class => \App\Policies\BlogReplyPolicy::class,
		\App\Models\BlogArticle::class => \App\Policies\BlogArticlePolicy::class,
		\App\Models\BlogCategory::class => \App\Policies\BlogCategoryPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Horizon::auth(function ($request) {
            // 是否是站长
            return Auth::user()->hasRole('Founder');
        });
    }
}
