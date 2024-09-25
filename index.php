<?php

require 'vendor/autoload.php';
Use App\TransactionApp;

$input =  file_get_contents($argv[1]);
$App = new TransactionApp;
echo $App->process_input( $input );




