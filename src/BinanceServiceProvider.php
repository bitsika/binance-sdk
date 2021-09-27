<?php

namespace Bitsika\BinanceSdk;

use Bitsika\BinanceSdk\Binance;
use Illuminate\Support\ServiceProvider;

class BinanceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $config = realpath(__DIR__.'/../resources/config/binance-sdk.php');
        $this->publishes([
            $config => config_path('binance-sdk.php')
        ]);
    }

    public function register() {
        $this->app->bind('bitsika-binance', function () {
            return new Binance;
        });
    }
}