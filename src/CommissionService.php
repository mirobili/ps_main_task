<?php

namespace App;

class CommissionService{ 

    static function commission_rates(string $key)
    {
        $rates = \App\Env::getEnv('commission_rates');
        return $rates[$key] ?? throw new Exception('Commission key not found');
    }
}
