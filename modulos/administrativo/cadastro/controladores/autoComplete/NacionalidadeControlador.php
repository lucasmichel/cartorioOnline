<?php
// codificação utf-8
session_start();
include("../../../../../inc/config.inc.php");
include("../../../../sistema/gerencial/inc/seguranca.inc.php");
include("../../inc/autoload.inc.php");
$term = trim(strip_tags($_GET['term']));//recebe o valor pelo parâmetro term
if($term != ""){
    $arrConsulta["PES_Nacionalidade"] = strtoupper($term);
    //faz uma conulta com distinct no campo PES_Naturalidade
    $strSQL = "SELECT DISTINCT(PES_Nacionalidade) FROM CAD_PES_PESSOAS WHERE PES_Nacionalidade LIKE '%".$arrConsulta["PES_Nacionalidade"]."%' ";
    $strDados = Db::getInstance()->select($strSQL);
    if($strDados != ""){
        for($intI=0; $intI<count($strDados); $intI++){
            $row['value'] = htmlentities(stripslashes($strDados[$intI]["PES_Nacionalidade"]));
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