<?php


namespace App;


class CurrencyService{

	function get_currency_decimals(string $currency){

		$data = ISO4217::getData();
		$decimals =  $data[$currency]['D'] ?? '';
		return $decimals;
	}

	function ceil_currency($amount, string $currency){

    	$d= $this->get_currency_decimals($currency);
		return $this->ceil_float($amount, $d);
	}

	function format_currency(float $amount, string $currency){
		$d= $this->get_currency_decimals($currency);
		$amount= $this->ceil_float($amount, $d);
		return number_format($amount, $d, '.', '');
	}
	
	function ceil_float($value, $places=0){

		$tmp = pow(10,$places);
		return ceil( $value*$tmp ) / $tmp ;
	}
		/*********************************/
	static function rates(){
		return [ 'USD'=> 1.1497, 'EUR'=> 1, 'JPY'=> 129.53 ];
	}

	static function get_rate(string $currency){
		return self::rates()[$currency]??'1';
	}

	static function toEuro(float $amount, string $currency){
		return $amount / self::get_rate($currency);
	}

	static function fromEuro(float $amount, string $currency){
		return $amount * self::get_rate($currency);
	}
}