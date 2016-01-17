<?php
    //codificação utf-8...
    if(isset($_SESSION["USUARIO_ID"]) && isset($_SESSION["ACESSOPERMITIDO"])){
        if($_SESSION["ACESSOPERMITIDO"] != "TRUE"){
            echo "
            <script type='text/javascript'>
                parent.location = '".SISTEMA_HTTP."/index.php';
            </script>";
            exit;
        }
    }else{        
        echo "
        <script type='text/javascript'>
            parent.location = '".SISTEMA_HTTP."/index.php';
        </script>";
        exit;
    }
?>