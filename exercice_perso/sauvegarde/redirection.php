<?php
/**
 * Created by PhpStorm.
 * User: ckowalski
 * Date: 17/10/2017
 * Time: 13:31
 */
echo $_GET['MESSAGE'];

?>
<?php if($_GET['TRANSACTIONID']) : ?>
<script>
    window.top.location.href = "https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/redirection.php?MESSAGE=<?php echo $_GET['MESSAGE']; ?>";
</script>
<?php endif; ?>

<html>
<head>
</head>
<body>
    <?php if($_GET['TRANSACTIONID']) : ?>
    <input class="btn waves-effect waves-light " type="submit" name="ok" value="Refund" onclick="redirectRefund()"/>
    <script>
               function redirectRefund(){
                   window.location = "refund.php?MESSAGE=<?php echo $_GET['TRANSACTIONID']; ?>";
               }
    </script>
    <?php endif; ?>
</body>
</html>
