<?php

namespace App\Processors;
use App\CurrencyService;
use App\CommissionService;
use App\Env;
use App\Transaction;
use App\Formatter;

class WithdrawPrivateProcessor implements TransactionProcessorInterface{

	function get_free_weekly_withdraw(){ // 1000;
		return Env::getEnv('private_free_weekly_withdraw_euro');
	}

	function get_free_withdraws_count(){
		return  Env::getEnv('private_free_weekly_withdraws');
	}

	function get_buffer(int $uid){
		return UserBuffer::get($uid);
	}

	function set_buffer($uid, $week, $week_draw, $current_weekly_amount ){
        UserBuffer::set($uid, $week, $week_draw, $current_weekly_amount );
	}

    public function process(Transaction $tt ):float{

        $commission_rate = CommissionService::commission_rates('private_withdraw'); // 0.003; // 0.3%

        $free_weekly_withdraw_euro = $this->get_free_weekly_withdraw(); // 1000;
        $free_draws = $this->get_free_withdraws_count(); // 1000;

        $user_buffer = $this->get_buffer($tt->getUid());
        $tmp_week  			   = $user_buffer['week'];
        $week_draw 			   = $user_buffer['week_draw'];
        $current_weekly_amount = $user_buffer['current_weekly_amount'];

        $week = date( 'oW', strtotime($tt->getDate()) );

        if($tmp_week != $week){ // starting new week
            $tmp_week = $week;
            $current_weekly_amount = 0;
            $week_draw = 0;
        }

        $week_draw++;

        $euro_amount = $this->toEuro($tt->getAmount() ,trim($tt->getCurrency()));;

        if($week_draw>$free_draws  or $current_weekly_amount >= $free_weekly_withdraw_euro ){ // after the 3rd withraw OR after 1000Euro charge for the full amount

            $amount_to_charge = $tt->getAmount();
        }else{
            if($current_weekly_amount + $euro_amount < $free_weekly_withdraw_euro){ //  not exceeding free limit
                $amount_to_charge=0;
            }else{ // New draw exceeding free limit. Charge only amount exceeding
                $free_draw_remaining = ($free_weekly_withdraw_euro - $current_weekly_amount);
                $euro_amount_to_charge = $euro_amount - $free_draw_remaining;
                $amount_to_charge = $this->fromEuro($euro_amount_to_charge, $tt->getCurrency());
                // $amount_to_charge = fromEuro($euro_amount_to_charge, $currency);
            }
        }

        $commission = $amount_to_charge * $commission_rate ;

        $current_weekly_amount +=  Formatter::ceil_float($euro_amount, 2);

        $this->set_buffer($tt->getUid(), $week, $week_draw, $current_weekly_amount );

//        if(1 or isset(ENV['debug']))
//            trace(
//                str_pad($tt->getAction(), 10 ).
//                str_pad("uid: ".$tt->getUid(), 10 ).
//                str_pad("date: ".$tt->getDate(), 20 ).
//                "week: $week, rate: $commission_rate  weekdraw: $week_draw   ".
//                str_pad("comm: $commission ". $tt->getCurrency(), 22 ).
//                str_pad("amount: ".$tt->getAmount()." ".$tt->getCurrency()."  " , 25).
//                str_pad("current_weekly_amount: $current_weekly_amount", 35).
//                str_pad("charge_amount: $amount_to_charge " , 25).
//                str_pad("rate: $commission_rate", 12 ).
//                str_pad("euro_amount: $euro_amount " , 20)
//
//            );

        return  $commission ;
    }

    private function toEuro(float $amount, string $currency)
    {
        return CurrencyService::toEuro($amount ,$currency);

    }    private function fromEuro(float $amount, string $currency)
    {
        return CurrencyService::fromEuro($amount, $currency);

    }

}