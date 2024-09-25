<?php

namespace App\Processors;
use App\CommissionService;
use App\Transaction;

class WithdrawBusinessProcessor implements TransactionProcessorInterface{
	
	function process(Transaction $tt):float{

        $business_withdraw_commission_rate =  CommissionService::commission_rates('business_withdraw'); // 0.005 // 0.5%
        return $tt->getAmount() * $business_withdraw_commission_rate;
	}
}
