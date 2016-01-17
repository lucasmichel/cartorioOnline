<?php
/*error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', true);*/
include("../../../inc/config.inc.php");    
include("../../../lib/canvas/canvas.php");    
include("inc/autoload.inc.php");
include("../../sistema/home/inc/doc.inc.php");
    
if(isset($_GET["MDP_ID"])){    
    //consulta o objeto, se ja estiver preenchido a variavel nã atualiza mais..    
    $arrConsulta["MDP_ID"] = $_GET["MDP_ID"];    
    $arrObjRegistroEmail = NegMalaDiretaPessoa::getInstance()->consultar($arrConsulta);
    $arrObjRegistroEmail = $arrObjRegistroEmail["objects"];
    
    $objMalaPessoa = new MalaDiretaPessoa();
    $objMalaPessoa = $arrObjRegistroEmail[0];
    if($objMalaPessoa->getDataVisualizacao() == null){
        $_GET["MDP_DataHoraLeitura"] = date("d/m/Y H:i:s");
        $arrObjMalaPessoa = NegMalaDiretaPessoa::getInstance()->registrarVisualizacaoEmail($_GET);
    }
}

$can = new canvas();
$can->create_empty_image(1,1);
$can->show();


