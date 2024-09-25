<?php


namespace App;

class MyLog
{
    static function my_log($message){
        error_log(date('Y-m-d H:i:s'). ' ' . var_export($message,true) ."\n",'3','error_log.log');
    }

    static function trace($var){
        print_r($var);
        echo "\n";
    }
    static function dd($var){
        self::trace($var);
        exit();
    }
}