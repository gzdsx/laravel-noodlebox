<?php

namespace App\Providers;

use App\Validators\AccountValidator;
use App\Validators\PhoneValidaotr;
use App\Validators\PasswordValidator;
use App\Validators\NickNameValidator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $validators = [
        'pwd' => PasswordValidator::class,
        'phone' => PhoneValidaotr::class,
        'nickname' => NickNameValidator::class,
        'account' => AccountValidator::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerValidators();
        Paginator::useBootstrap();

        $categories = get_categories(['taxonomy' => 'product', 'excludes' => [15, 221]]);
        View::share([
            'settings' => settings(),
            'categories' => $categories
        ]);

        //邮件配置
        Config::set('mail', [
            'driver' => 'smtp',
            'host' => settings('mail_host', env('MAIL_HOST')),
            'port' => settings('mail_port', env('MAIL_PORT')),
            'from' => [
                'name' => settings('mail_from_name', env('MAIL_FROM_NAME')),
                'address' => settings('mail_from_address', env('MAIL_FROM_ADDRESS'))
            ],
            'encryption' => settings('mail_encryption', env('MAIL_ENCRYPTION')),
            //'encryption' => 'TLS',
            'username' => settings('mail_username', env('MAIL_USERNAME')),
            'password' => settings('mail_password', env('MAIL_PASSWORD')),
            'sendmail' => '/usr/sbin/sendmail -bs',
        ]);

        if ($local = session('local')) {
            App::setLocale($local);
        } elseif ($local = settings('language')) {
            App::setLocale($local);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('hooks', function () {
            return [];
        });
    }

    /**
     * register custom validators
     */
    protected function registerValidators()
    {
        foreach ($this->validators as $rule => $validator) {
            Validator::extend($rule, "{$validator}@validate");
        }
    }
}
