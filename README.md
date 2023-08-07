# Bitsika BinanceSdk
> A Laravel Package to connect with Bitsika's Binance wrapper

## Installation

[PHP](https://php.net) 7.4+ and [Composer](https://getcomposer.org) are required.

Add this to your composer.json

```
"repositories": {
    "dev-package": {
        "type": "vcs",
        "url": "git@github.com:bitsika/binance-sdk.git"
    }
},
```
To install the package bash: 
```bash
composer require bitsika/binance-sdk:dev-master
```
## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Bitsika\BinanceSdk\BinanceServiceProvider"
```

A configuration-file named `binance-sdk.php` with will be placed in your `config` directory

## Methods
Here are some of the methods available
 
- Wallet Creation
    - createWallet()
    - createWalletAndEncrypt()

- Retrieve Wallet
    - getAccountFromPrivateKey()
    - getAccountFromKeystore()

- Wallet Balance
    - getBalance()
    - getTokenBalance()

- Transfer 
    - transferBNB()
    - transferToken()
    - transferBNBFromKeystore()
    - transferTokenFromKeystore()

- Transaction
    - getTransactionReceipt()
