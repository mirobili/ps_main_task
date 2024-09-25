<?php


namespace App;
use Exception;

class Env
{

   static $ENV = [

        'commission_rates' => [
            'private_deposit' => 0.0003  // 0.03%
            , 'business_deposit' => 0.0003 // 0.03%

            , 'private_withdraw' => 0.003 // 0.3%
            , 'business_withdraw' => 0.005  // 0.5%
        ],

        'transaction_processors' => [

            'withdraw' => [
                'business' => 'App\Processors\WithdrawBusinessProcessor',
                'private' => 'App\Processors\WithdrawPrivateProcessor',
            ],
            'deposit' => [

                'private' => 'App\Processors\DepositPrivateProcessor',
                'business' => 'App\Processors\DepositBusinessProcessor',
            ]
        ],
        'private_free_weekly_withdraw_euro' => 1000,
        'private_free_weekly_withdraws' => 3,
        // 'debug'=>'1'
    ];

    public static function getEnv($key){
           return self::$ENV[$key] ?? throw new Exception('ENV key not found');
    }
}