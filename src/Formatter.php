<?php

namespace App;
class Formatter{

    public static function ceil_float(float $value, int $places = 0){

        $tmp = pow(10, $places);
        return ceil($value * $tmp) / $tmp;
    }

    public static function get_currency_decimals(string $currency): int {

        $data = \App\ISO4217::getData();
        $dec = $data[$currency]['D'] ?? '';
        return $dec;
    }

    public static function format_currency(float $amount, string $currency): string {

        $d = self::get_currency_decimals($currency);
        $amount = self::ceil_float($amount, $d);
        return number_format($amount, $d, '.', '');
    }
}