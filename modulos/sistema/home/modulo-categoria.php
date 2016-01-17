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
    <div id="container-categoria">        
        <?php
            try{
                // identifica o usuário e o seu grupo
                // toda vez que for chamada a tela de módulos categoria
                // será realizada esta consulta para checar se houve mudança
                // no perfil (grupo) do usuário
                // pois poderá haver mudança de permissões e o mesmo deixar
                // de acessar módulos que antes acessava
                // esta rotina permite que seja sempre identificadas as permissões
                // atuais do usuário
                $arrStrFiltrosUsuario = array();
                $arrStrFiltrosUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];            
                $arrObjs = FachadaGerencial::getInstance()->consultarUsuario($arrStrFiltrosUsuario);
                $arrObjs = $arrObjs["objects"];
                
                // permissões
                $arrStrFiltrosPermissoes = array();
                $arrStrFiltrosPermissoes["MCT_Status"] = "A";
                $arrStrFiltrosPermissoes["GRU_ID"] = $arrObjs[0]->getGrupo()->getId();
                $arrStrFiltrosPermissoes["USU_ID"] = $arrObjs[0]->getId();
                $arrObjs = FachadaGerencial::getInstance()->consultarModuloCategoria($arrStrFiltrosPermissoes);
                $arrObjs = $arrObjs["objects"];
                
                if($arrObjs != null){
                    if(count($arrObjs) > 0){
                        $strHtml  = "<table align='center' cellspacing='6px\' cellpadding='6px\'>";
                        $intNumTD = 0;

                        for($intI=0;$intI<count($arrObjs);$intI++){                
                            $objModuloCategoria = $arrObjs[$intI];

                            if($intNumTD == 0){
                                $strHtml .= "<tr class=\"linhaCategoria\">";
                            }

                            $strHtml .= "<td class=\"colunaCategoria\" style=\"background: url('img/".$objModuloCategoria->getBackgroundModulo()."');background-repeat:no-repeat;\">";
                                $strHtml .= "<a href=\"javascript: void(0);\" title='".$objModuloCategoria->getDescricao()."' onclick=\"atualizarBarraNavegacao('navegacao', 'inc/navegacao.inc.php?moduloCategoria=".$objModuloCategoria->getId()."'); exibirTela('content', 'modulo.php?moduloCategoria=".$objModuloCategoria->getId()."');\">";
                                    $strHtml .= "<img src=\"img/botoes/modulos/".$objModuloCategoria->getImagem()."\" border=\"0\"/>";
                                $strHtml .= "</a>";
                            $strHtml .= "</td>";

                            // o máximo de colunas são 4
                            // se o sistema encontrar um número de módulos inferior a 4
                            // o TR finaliza com o número encontrado
                            // assim evita colunas vazias e o menu fica centralizado
                            // mas lembrando: SÓ QUANDO O count($arrObjModulosCategorias) for 
                            // menor que 4
                            if(count($arrObjs) >= 4){
                                if($intNumTD == 2){
                                    $strHtml .= "</tr>";
                                    $intNumTD = 0;
                                }else{
                                    $intNumTD++;
                                }
                            }else{
                                if($intNumTD == count($arrObjs) - 1){
                                    $strHtml .= "</tr>";
                                    $intNumTD = 0;
                                }else{
                                    $intNumTD++;
                                }
                            }
                        }

                        // se for igual a 1 indica que ele não concluiu a linha
                        // e por isso completa-se os TDs da tabela
                        if($intNumTD > 0){                        
                            for($intI=1; $intI<=(4 - $intNumTD); $intI++){
                                $strHtml .= "<td></td>";
                            }      

                            $strHtml .= "</tr>";
                        }

                        $strHtml .= "</table>";

                        echo $strHtml;
                    }
                }
            }catch(Exception $objException){
                echo $objException->getMessage();
            }
        ?>        
    </div>
</body>
</html>