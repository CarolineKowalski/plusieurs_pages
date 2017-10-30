<?php


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
    'AMOUNT' => '15235', // amount in cents
    'CLIENTIDENT' => '6328_john.smith@gmail.com', // unique client id in merchant base
    'DESCRIPTION' => 'Fashion jacket',
    'IDENTIFIER' => BE2BILL_IDENTIFIER,
    'OPERATIONTYPE' => 'payment',
    'ORDERID' => date("Y-m-d").'_'.uniqid(), // unique order id in merchant base
    'VERSION' => '2.0',
    //3DSECURE paiement sécurisé par tel etc
    '3DSECURE' => 'yes',
    'CLIENTEMAIL' => 'caro@gmail.com',
    'CARDFULLNAME' => 'Caro Ko ',
    //Pour cacher l'email / le nom
    /*'HIDECLIENTEMAIL' => 'yes',
   'HIDECARDFULLNAME' => 'yes',*/
    // Pour afficher une case pour enregistrer la carte
    //'DISPLAYCREATEALIAS' => yes,
    // Pour enregistrer la carte sans la case par défault
    'CREATEALIAS' => 'yes'
    //Alias = A117467
);


// Hash calculating
$params['HASH'] = be2bill_signature( BE2BILL_PASSWORD, $params );
//echo be2bill_signature( BE2BILL_PASSWORD, $params );
//9cc09b65c8d199d0678295a5ea20f4261996ef847321bb31d1b9d03badbe1ff2

//echo hash('sha256', 'S+.Es1(=FNk7W)91AMOUNT=15235S+.Es1(=FNk7W)91CLIENTIDENT=6328_john.smith@gmail.comS+.Es1(=FNk7W)91DESCRIPTION=Fashion jacketS+.Es1(=FNk7W)91IDENTIFIER=darkLamer666S+.Es1(=FNk7W)91OPERATIONTYPE=paymentS+.Es1(=FNk7W)91ORDERID=2014-02-15_045S+.Es1(=FNk7W)91VERSION=2.0S+.Es1(=FNk7W)91');
//e055bd55af95c960fa2a209a183ed039c2792d14728b6ac5c2d502f199398324

?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/materialize.min.css" />
        <link rel="stylesheet" type="text/css" href="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/style_index.css" />
    </head>
    <body>

    <div class="center row">
        <div class="col s11 m9">
                    <div id="crd" class="card-content cyan-darken-1-text  grey lighten-4 accent-4">

                        <form method="POST" action="exercice_perso/template.php">
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="IDENTIFIER">IDENTIFIANT </label>
                                    <input type="text" name="IDENTIFIER" class="validate" value="darkLamer666" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="OPERATIONTYPE">TYPE D'OPERATION </label>
                                    <input type="text" class="validate" name="OPERATIONTYPE" value="payment" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="ORDERID">IDENTIFIANT DE LA COMMANDE </label>
                                    <input type="text" name="ORDERID" value="<?php echo uniqid();?>"  />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="AMOUNT">MONTANT EN CENTIMES </label>
                                     <input type="text" name="AMOUNT" value=""  />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="CLIENTIDENT">EMAIL </label>
                                    <input type="email" name="CLIENTIDENT" value="6328_john.smith@gmail.com " />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="DESCRIPTION">DESCRIPTION </label>
                                    <input type="text" name="DESCRIPTION" value=" Fashion jacket"   />
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="VERSION">VERSION </label>
                                    <input type="text" name="VERSION" value="2.0" />
                                </div>
                            </div>

                            <input class="btn waves-effect waves-light " type="submit" name="ok" value="Valider le panier" />
                        </form>
                    </div>
                </div>
            </div>
        </div>



    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/materialize.min.js"></script>
    </body>
</html>

