<?php


namespace App\Processors;


class UserBuffer{
	
	private static $buffer = [];

	public static function set($uid, $week, $week_draw, $current_weekly_amount ){
		self::$buffer[$uid]=['week'=>$week, 'week_draw'=>$week_draw, 'current_weekly_amount'=>$current_weekly_amount];
	}
	
	public static function get($uid){
		return isset(self::$buffer[$uid]) ? self::$buffer[$uid] : ['week'=>'', 'week_draw'=>0, 'current_weekly_amount'=>0] ;
	}
}