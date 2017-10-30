<?php

// Credentials
define('BE2BILL_PASSWORD', 'S+.Es1(=FNk7W)91' ); // <--- sent by email

//var_dump($_POST);

$IDENTIFIER = $_POST['IDENTIFIER'];
$OPERATIONTYPE = $_POST['OPERATIONTYPE'];
$ORDERID = $_POST['ORDERID'];
$AMOUNT= $_POST['AMOUNT']/100;
$CLIENTIDENT = $_POST['CLIENTIDENT'];
$DESCRIPTION = $_POST['DESCRIPTION'];
$VERSION = $_POST['VERSION'];

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
$params = array(
    'AMOUNT' => $_POST['AMOUNT'], // amount in cents
    'CARDFULLNAME' => 'Caro Ko ',
    'CLIENTEMAIL' => 'caro@gmail.com',
    'CLIENTIDENT' => $_POST['CLIENTIDENT'], // unique client id in merchant base
    'DESCRIPTION' => $_POST['DESCRIPTION'],
    'HIDECLIENTEMAIL' => 'yes',
    'HIDECARDFULLNAME' => 'yes',
    'IDENTIFIER' => $_POST['IDENTIFIER'],
    'OPERATIONTYPE' => $_POST['OPERATIONTYPE'],
    'ORDERID' => $_POST['ORDERID'], // unique order id in merchant base
    'VERSION' => $_POST['VERSION']
    //3DSECURE paiement sécurisé par tel etc
    //'3DSECURE' => 'yes',
    //Pour cacher l'email / le nom
    // Pour afficher une case pour enregistrer la carte
    //'DISPLAYCREATEALIAS' => yes,
    // Pour enregistrer la carte sans la case par défault
    //'CREATEALIAS' => 'yes'
    //Alias = A117467
);

$params['HASH'] = be2bill_signature( BE2BILL_PASSWORD, $params );

//print("La commande n°$ORDERID s'élève à $AMOUNT €  $IDENTIFIER");

echo("<p>");
echo ("$IDENTIFIER, voici le récapitulatif de votre commande : </br> Type d'opération :  $OPERATIONTYPE </br>
Identifiant de la commande : $ORDERID </br> Prix : $AMOUNT €</br>
 Adresse email : $CLIENTIDENT </br> Description : $DESCRIPTION </br> Version : $VERSION");
echo ('</p>');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/materialize.min.css" />
    <link rel="stylesheet" type="text/css" href="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/style.css" />

</head>
<body>
    <form method="POST" action="https://secure-test.be2bill.com/front/form/process" target="PAYMENTFORM">
        <?php foreach( $params as $parameter => $value ) : ?>
            <?php if (is_array($value) == true) : ?>
                <?php foreach ($value as $index => $val) : ?>
                    <input type="hidden" name="<?php echo $index; ?>" value="<?php echo $val; ?>" />
                <?php endforeach; ?>
            <?php else : ?>
                <input type="hidden" name="<?php echo $parameter; ?>" value="<?php echo $value; ?>" />
            <?php endif; ?>
        <?php endforeach; ?>
        <input class="waves-effect waves-light btn" type="submit" id="ok" name="ok" value="Poursuivre" onclick="masquer_div('a_masquer');"/>
    </form>

    <iframe id="a_masquer" name="PAYMENTFORM">
            src="https://secure-test.be2bill.com/front/form/process"
    </iframe>
    <script>
        function masquer_div(id)
        {

            document.getElementById(id).style.display = 'block';
            document.getElementById('ok').parentNode.style.display = 'none';

           /* if (document.getElementById(id).style.display == 'none') {
            document.getElementById(id).style.display = 'block';
            }
            else {
            document.getElementById(id).style.display = 'none';
            }*/
        }

    </script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/materialize.min.js"></script>
</body>
</html>

