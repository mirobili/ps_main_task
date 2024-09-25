<?php

namespace App\Processors;

use App\Transaction;

interface TransactionProcessorInterface
{
    function process(Transaction $tt): float;
}