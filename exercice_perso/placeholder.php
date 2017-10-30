<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/materialize.min.css" />
    <link rel="stylesheet" type="text/css" href="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/style.css" />

    <script type="text/javascript">
        function changeClasses() {
            document.getElementById('b2b-table').firstElementChild.style.backgroundColor = "#F6F7F7";
            document.getElementById("b2b-submit").className += " btn waves-effect waves-light ";
            document.getElementById("b2b-cancel").className += " btn waves-effect waves-light ";


            /* document.getElementById("b2b-submit").style.textAlign = "center";
             document.getElementById("b2b-submit").style.display = "block";
             document.getElementById("b2b-submit").style.margin = "auto";

             document.getElementById("b2b-cancel").style.textAlign = "center";
             document.getElementById("b2b-cancel").style.display = "block";
             document.getElementById("b2b-cancel").style.margin = "auto";*/


            document.getElementById("b2b-month-input").style.display = "block";
            document.getElementById("b2b-year-input").style.display = "block";
            document.getElementById("b2b-month-input").style.backgroundColor = "#F6F7F7";
            document.getElementById("b2b-year-input").style.backgroundColor = "#F6F7F7";

            //document.getElementById("b2b-table").firstElementChild.childNodes[3].childNodes[3].firstElementChild.style.border = "1px solid red";
            //document.getElementById("b2b-table").firstElementChild.childNodes[3].childNodes[3].firstElementChild += " btn btn-outline-secondary";
        }
    </script>
</head>

<body onload="changeClasses()">
    %PLACEHOLDER%

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://pc-ext-srv2.rtblw.com/caroline/exercice_perso/css/materialize.min.js"></script>
</body>
</html>
