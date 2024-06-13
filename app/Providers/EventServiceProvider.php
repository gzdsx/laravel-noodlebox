<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Overtrue\LaravelWeChat\Events\WeChatUserAuthorized;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        WeChatUserAuthorized::class => [
            'App\Listeners\Auth\WeChatUserAuthorizedListener'
        ],
        Registered::class => [
            'App\Listeners\Auth\RegisteredListener'
        ],
        Login::class => [
            'App\Listeners\Auth\LoginListener'
        ],
        Logout::class => [
            'App\Listeners\Auth\LogoutListener'
        ],
        'App\Events\OrderChanged' => [
            'App\Listeners\Order\OrderChangedListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
