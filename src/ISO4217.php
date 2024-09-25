<?php

namespace App;


class ISO4217{
		
//	private $data ;
	private static $static_data ;
//	private static $instance;
	
//	private function __construct(){
//		$this->data = json_decode(file_get_contents("src/assets/ISO4217.json"), true);
//
//	}

//	public function generate_json_util(){
//
//		$file = 'ISO4217.csv';
//		$csv = array_map('str_getcsv', file($file));
//		array_walk($csv, function(&$a) use ($csv) {
//			$a = array_combine($csv[0], $a);
//		});
//
//		foreach($csv as $cc){
//		  $aa[$cc['Code']]=$cc;
//		}
//
//		file_put_contents('currenciy_info.json', json_encode($aa));
//	}


	public function get($currency){			
		return $this->data[$currency]??['','','',''];
	}

	public static function getData(){
	    if(!isset(self::$static_data)){
            self::$static_data= json_decode(file_get_contents("src/assets/ISO4217.json"), true);
        }
        return self::$static_data;
    }
}
	

