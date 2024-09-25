<?php

namespace App;

Use App\Env;
Use App\Processors\TransactionProcessorInterface;
use Exception;
class TransactionProcessorFactory{
	
	private static $transaction_processors;

	public static function getTransactionProcessor(Transaction $tt): TransactionProcessorInterface{

	    if(!isset(self::$transaction_processors)){
            self::$transaction_processors = Env::getEnv('transaction_processors');
        }

		if(isset(self::$transaction_processors[$tt->getAction()][$tt->getUserType()])){
			 $processor_class = self::$transaction_processors[$tt->getAction()][$tt->getUserType()];
			 return new $processor_class;
		}
		
		throw new Exception("Transaction processor not found for ".$tt->getAction()." " .$tt->getUserType());
	}	
}
