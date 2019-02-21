<?php

namespace LiYiBin\LineNotify;

use Illuminate\Support\ServieProvider;

class LineNotifyFactoryServiceProvider extends ServieProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/line-notify.php' => config_path('line-notify.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('line-notify', function () {
            return new LineNotifyFactory();
        });

        $this->mergeConfigFrom(
            __DIR__.'/../config/line-notify.php', 'line-notify'
        );
    }
}
