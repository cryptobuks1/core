<?php

namespace App\Helpers;
use Config;
class CryptHelper
{

	public static function encodeCrypt($balance)
    {
    	//$balance = (double) $balance;
        $newEncrypter = new \Illuminate\Encryption\Encrypter( base64_decode(Config::get( 'backend.cryptKey' )), Config::get( 'app.cipher' ) );
        return $newEncrypter->encrypt($balance);
    }

    public static function decodeCrypt($code)
    {
        $newEncrypter = new \Illuminate\Encryption\Encrypter( base64_decode(Config::get( 'backend.cryptKey' )), Config::get( 'app.cipher' ) );
        return $newEncrypter->decrypt($code);
    }




}