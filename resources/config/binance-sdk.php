<?php
/*
 * This file is part of the Bitsika BinanceSdk package.
 *
 * (c) Muheez Jimoh <jamuheez2009@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


return [

    /**
     * Bitsika binance api url
     *
     */
    'binanceUrl' => getenv('BINANCE_API_URL'),

    /**
     * Secret Key to encrypt binance wallet
     *
     */
    'keystorePassword' => getenv('BINANCE_KEYSTORE_PASSWORD')
];