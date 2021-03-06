<?php
// codificação utf-8
session_start();
include("../../../../../inc/config.inc.php");
include("../../../../sistema/gerencial/inc/seguranca.inc.php");
include("../../inc/autoload.inc.php");
$term = trim(strip_tags($_GET['term']));//recebe o valor pelo parâmetro term
if($term != ""){
    $arrConsulta["DAM_IgrejaNome"] = strtoupper($term);
    //faz uma conulta com distinct no campo PES_Naturalidade
    $strSQL = "SELECT DISTINCT(DAM_IgrejaNome) FROM ADM_DAM_DADOS_ECLESIASTICOS_MEMBROS WHERE DAM_IgrejaNome LIKE '%".$arrConsulta["DAM_IgrejaNome"]."%' ";
    $strDados = Db::getInstance()->select($strSQL);
    if($strDados != ""){
        for($intI=0; $intI<count($strDados); $intI++){
            $row['value'] = htmlentities(stripslashes($strDados[$intI]["DAM_IgrejaNome"]));
            $row['id']=(int)$intI;
            $row_set[] = $row;
        }
    }else{
        $row_set[] = null;
    }    
}else{
    $row_set[] = null;
}
echo json_encode($row_set);//format the array into json data