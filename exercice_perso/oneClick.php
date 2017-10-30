<?php
/**
 * Created by PhpStorm.
 * User: ckowalski
 * Date: 16/10/2017
 * Time: 10:06
 */

define('BE2BILL_IDENTIFIER', 'darkLamer666' ); // <--- sent by email
define('BE2BILL_PASSWORD', 'S+.Es1(=FNk7W)91' ); // <--- sent by email
define('BE2BILL_REST_URL', 'https://secure-test.be2bill.com/front/service/rest/process.php' ); // <--- sent by email

function be2bill_signature($password, $params = array())
{
    static $stack = array(); //tableau static
    $query = array(); //tableau de

    ksort($params);// trie le tableau suivant les clefs

    foreach ($params as $key => $value) {
        if ($key == 'HASH' && empty($stack)) continue;
        if (!is_array($value)) {
            if ($stack) {
                $query[] = implode('', $stack) . '[' . $key . ']=' . $value; // Rassemble les éléments d'un tableau en une chaîne
            } else {
                $query[] = $key . '=' . $value;
            }
        } else {
            $stack[] = ($stack) ? '[' . $key . ']' : $key;
            $query[] = be2bill_signature($password, $value);
            array_pop($stack); // dépile et retourne le dernier élément du tableau array, le raccourcissant d'un élément.
        }
    }

    if (!$stack) {
        $result = $password . implode($password, $query) . $password;
        return hash('sha256', $result);

    } else {
        $result = implode($password, $query);
        return $result;
    }
}

// Parameters
$params = array(
    'method' => 'payment',
    'params' => array(
        'DESCRIPTION' => 'Fashion jacket',
        'IDENTIFIER' => BE2BILL_IDENTIFIER,
        'OPERATIONTYPE' => 'payment',
        'ORDERID' => '2014-02-15_045', // unique order id in merchant base
        'AMOUNT' => '12345',
        'ALIAS' => 'A117608', // A récuperer
        'ALIASMODE' => 'oneclick',
        'CLIENTEMAIL' => '6328_john.smith@gmail.com',
        'CLIENTIDENT' => '6328',
        'CLIENTIP' => '123.123.123.123',
        'CLIENTUSERAGENT' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:28.0) Gecko...',
        'VERSION' => '3.0'
    )
);
// Hash calculating
$params['params']['HASH'] = be2bill_signature( BE2BILL_PASSWORD, $params['params'] );

$resource = curl_init();

curl_setopt( $resource, CURLOPT_URL, BE2BILL_REST_URL );
curl_setopt( $resource, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $resource, CURLOPT_POST, true );
curl_setopt( $resource, CURLOPT_POSTFIELDS, http_build_query( $params ) );

// echo urldecode(http_build_query( $params )); // debug

$serialized = curl_exec( $resource );

if( $serialized !== false ) {
    $result = json_decode( $serialized,true );

    echo '<pre>';
    var_dump($result); // debug / permet d'afficher tableau (ce qu'echo ne peut pas faire)
    echo '</pre>'; // sert à mettre en forme le tableau

    if( $result['EXECCODE'] == '0000' ) {
        // OK
    } else {
        // FAIL
    }
}
?>