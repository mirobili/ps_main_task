<?php


namespace App;


use Exception;
use App\Formatter;

class TransactionApp
{
    private function transaction_from_csv(string $csv): Transaction
    {
        list($date, $uid, $user_type, $action, $amount, $currency) = explode(',', trim($csv));

        $transaction = new Transaction;
        $transaction->setDate($date);
        $transaction->setUid($uid);
        $transaction->setUsertype($user_type);
        $transaction->setAction($action);
        $transaction->setAmount($amount);
        $transaction->setCurrency(trim($currency));

        return $transaction;
    }

    private function process_transaction(Transaction $transaction): float
    {
        try {
            $processor = TransactionProcessorFactory::getTransactionProcessor($transaction);
            return $processor->process($transaction);
        } catch (Exception $e) {

            $error_message = $e->getMessage();
            my_log($error_message);
            trace($error_message);
        }
    }

    public function process_input(string $input = '')
    {
        $output = [];
        foreach (explode("\n", trim($input)) as $csv) {

            $transaction = $this->transaction_from_csv($csv);
            $commission = $this->process_transaction($transaction);
            $output[] = Formatter::format_currency($commission, $transaction->getCurrency());
        }

        return implode("\n", $output);
    }
}