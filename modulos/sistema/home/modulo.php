<?php
    // codificação utf-8
    session_start();
    include("../../../inc/config.inc.php");
    include("../gerencial/inc/seguranca.inc.php");
    include("inc/autoload.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
</head>
<body>
    <div id="container-modulo">        
        <?php        
            if(isset($_GET["moduloCategoria"])){
                $arrStrFiltrosUsuario = array();
                $arrStrFiltrosUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];            
                $arrObjs = FachadaGerencial::getInstance()->consultarUsuario($arrStrFiltrosUsuario);
                $arrObjs = $arrObjs["objects"];
                
                $arrStrFiltros               = array();
                $arrStrFiltros["MCT_ID"]     = $_GET["moduloCategoria"];
                $arrStrFiltros["MOD_Status"] = "A";
                $arrStrFiltros["GRU_ID"]     = $arrObjs[0]->getGrupo()->getId();
                $arrStrFiltros["USU_ID"]     = $arrObjs[0]->getId();
                $arrObjModulos               = FachadaGerencial::getInstance()->consultarModulo($arrStrFiltros);
                
                if($arrObjModulos != null){
                    // $arrObjModulos["objects"] fica a lista de objetos retornados
                    // controla o número de módulos por linha
                    $intNumeroModulosPorLinha = 6;
                    
                    if($intNumeroModulosPorLinha > count($arrObjModulos["objects"])){
                        $intNumeroModulosPorLinha = count($arrObjModulos["objects"]);
                    }
                    
                    if(count($arrObjModulos["objects"]) > 0){
                        $strHtml  = "<table align='center' cellspacing='10px' cellpadding='10px'>";
                        $intNumTD = 0;
                        
                        for($intI=0;$intI<count($arrObjModulos["objects"]);$intI++){
                            $objModulo = $arrObjModulos["objects"][$intI];

                            if($intNumTD == 0){
                                $strHtml .= "<tr class=\"linhaModulo\">";
                            }

                            $strHtml .= "<td class=\"colunaModulo\" style=\"width: 145px;text-align: center;background: url('img/".$objModulo->getModuloCategoria()->getBackgroundSubModulo()."') no-repeat; width: 145px; height: 145px;\">";                                                
                                $strHtml .= "<a href=\"javascript: void(0);\" title='".$objModulo->getDescricao()."' onclick=\"atualizarBarraNavegacao('navegacao', 'inc/navegacao.inc.php?modulo=".$objModulo->getId()."'); exibirTela('content', '".SISTEMA_HTTP."/modulos/".$objModulo->getCaminho()."principal.php?modulo=".$objModulo->getId()."&categoria=".$_GET["moduloCategoria"]."');\">";
                                    $strHtml .= "<img src=\"img/botoes/submodulos/".$objModulo->getImagem()."\" border=\"0\">";
                                    $strHtml .= "<br><b style=\"text-align: left;\">".$objModulo->getDescricao()."</b>";
                                $strHtml .= "</a>";
                            $strHtml .= "</td>";
                            
                            if($intNumTD == $intNumeroModulosPorLinha - 1){
                                $strHtml .= "</tr>";
                                $intNumTD = 0;
                            }else{
                                $intNumTD++;
                            }
                        }

                        if($intNumTD > 0){
                            for($intI=1; $intI<=($intNumeroModulosPorLinha - $intNumTD); $intI++){
                                $strHtml .= "<td></td>";
                            }

                            $strHtml .= "</tr>";
                        }

                        $strHtml .= "</table>";                        
                        echo $strHtml;
                    }
                }
            }
        ?>
    </div>
</body>
</html>