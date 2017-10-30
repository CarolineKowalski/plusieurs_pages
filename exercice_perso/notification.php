<?php
ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);

$message = 'Voici votre nouvelle commande : ';
//foreach ( $_POST as $value => $val ) {
//    $message .= $value. '= ' .$val  ;
//}
$message .= $_POST['TRANSACTIONID'];
mail('caroline.kowalski@dalenys.com', 'Identifiant de transaction',$message);


