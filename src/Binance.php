<?php

namespace Bitsika\BinanceSdk;

use Illuminate\Support\Facades\{Http, Config};

class Binance
{
    /**
     * Instance of Client
     * @var Http
     */
    protected $client;

    /**
     * Binance API base Url
     * @var string
     */
    protected $baseUrl;

    /**
     * Password to encrypt binance wallet
     * @var string
     */
    protected $password;

    public function __construct()
    {
        $this->baseUrl = Config::get('binance-sdk.binanceUrl');
        $this->password = Config::get('binance-sdk.keystorePassword');
        $this->client = Http::baseUrl($this->baseUrl);
    }

    /**
     * Create a BSC wallet
     *
     * @return Http
     */
    public function createWallet()
    {
        return $this->client->post('/account');
    }

    /**
     * Create Wallet and return encrypted keystore
     * 
     * Encrypts Bsc Wallet with provided password
     * @return Http
     */
    public function createWalletAndEncrypt()
    {
        return $this->client->post('/keystore/account', [
            'password' => $this->password
        ]);
    }

    /**
     * Get BSC Account from private key
     *
     * @param string $privateKey BSC Wallet Private Key
     * @return Http
     */
    public function getAccountFromPrivateKey(string $privateKey)
    {
        return $this->client->post('/get-account', [
            'privateKey' => $privateKey
        ]);
    }

    /**
     * Get BSC Wallet from Keystore
     *
     * decrypts keystore with password
     * @param string $keystore string encoded Keystore
     * @return Http
     */
    public function getAccountFromKeystore(string $keystore) 
    {
        return $this->client->post('/keystore/get-account', [
            'keystore' => $keystore,
            'password' => $this->password
        ]);
    }

    /**
     * Gets BNB Balance of BSC Wallet
     *
     * @param string $walletAddress BSC Wallet Address
     * @return Http
     */
    public function getBalance(string $walletAddress)
    {
        return $this->client->post('/balance', [
            'address' => $walletAddress
        ]);
    }

    /**
     * Get Coin Balance from BSC Wallet
     *
     * @param string $walletAddress BSC Wallet Address
     * @param string $contractAddress Contract Address of Coin 
     * @return Http
     */
    public function getTokenBalance(string $walletAddress, string $contractAddress)
    {
        return $this->client->post('/token/balance', [
            'address' => $walletAddress,
            'contractAddress' => $contractAddress
        ]);
    }

    /**
     * Transfer BNB from BSC Wallet to another BSC Wallet
     *
     * @param string $privateKey Private Key of the wallet to send from
     * @param string $toAddress BSC Wallet address to send to
     * @param float $amount Amount in BNB to send
     * @param float $gasAmount BNB transfer fee in Wei 
     * @return Http
     */
    public function transferBNB(string $privateKey, string $toAddress, $amount, $gasAmount)
    {
        return $this->client->post('/transfer', [
            'toAddress' => $toAddress,
            'privateKey' => $privateKey,
            'amount' => $amount,
            'gasAmount' => $gasAmount
        ]);
    }

    /**
     * Transfer Other Coin from BSC Wallet to Another Wallet
     *
     * @param string $privateKey Private Key of the wallet to send from
     * @param string $toAddress BSC Wallet address to send to
     * @param float $amount Amount to send
     * @param string $contractAddress Contract Address ot Coin to send
     * @param float|null $gasAmount BNB transfer fee in Wei | this would be extimated if its not passed 
     * @return Http
     */
    public function transferToken(string $privateKey, string $toAddress, $amount, string $contractAddress, $gasAmount=null) 
    {
        $data = [
            'toAddress' => $toAddress,
            'privateKey' => $privateKey,
            'amount' => $amount,
            'contractAddress' => $contractAddress
        ];

        if (isset($gasAmount)) {
            $data['gasAmount'] = $gasAmount;
        }

        return $this->client->post('/transfer/token', $data);
    }

    /**
     * Transfer Bnb from an encrypted wallet with the keystore
     * 
     * Password is used to decrypt the wallet
     *
     * @param string $keystore Encrypted Wallet Keystore
     * @param string $toAddress Address to send to
     * @param float $amount Amount in BNB to send
     * @param float $gasAmount Transfer fee in Wei
     * @return Http
     */
    public function transferBNBFromKeystore(string $keystore, string $toAddress, $amount, $gasAmount)
    {
        return $this->client->post('/keystore/transfer', [
            'toAddress' => $toAddress,
            'keystore' => $keystore,
            'amount' => $amount,
            'password' => $this->password,
            'gasAmount' => $gasAmount
        ]);
    }

    /**
     * Transfer Other Coin from an encrypted wallet with the keystore
     * 
     * Password is used to decrypt the wallet
     *
     * @param string $keystore Encrypted Wallet Keystore
     * @param string $toAddress Address to send to
     * @param float $amount Amount in BNB to send
     * @param string $contractAddress Contract Address ot Coin to send
     * @param float|null $gasAmount BNB transfer fee in Wei | this would be extimated if its not passed 
     * @return Http
     */
    public function transferTokenFromKeystore(string $keystore, string $toAddress, $amount, string $contractAddress, $gasAmount=null) 
    {
        $data = [
            'toAddress' => $toAddress,
            'keystore' => $keystore,
            'password' => $this->password,
            'amount' => $amount,
            'contractAddress' => $contractAddress
        ];

        if (isset($gasAmount)) {
            $data['gasAmount'] = $gasAmount;
        }

        return $this->client->post('/keystore/transfer/token', $data);
    }

    /**
     * Get Transaction Receipt as well as transaction details
     * 
     * returns null if transaction is pending
     *
     * @param string $transactionHash Transaction Hash on the chain
     * @return Http
     */
    public function getTransactionReceipt(string $transactionHash) {
        return $this->client->post('/transaction/receipt', [
            'transactionHash' => $transactionHash
        ]);
    }
}
