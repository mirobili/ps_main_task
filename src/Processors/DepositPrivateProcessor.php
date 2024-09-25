<?php

namespace App\Processors;
use App\CommissionService;
use App\Transaction;

class DepositPrivateProcessor implements TransactionProcessorInterface {
	
	function process(Transaction $tt ):float{
        $deposit_commission_rate = CommissionService::commission_rates($tt->getUserType() . '_deposit'); /// 0.0003; // 0.03%
        return $tt->getAmount() * $deposit_commission_rate;

	}
}
