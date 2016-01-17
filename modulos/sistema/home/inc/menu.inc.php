<?php
    // codificação UTF-8
    function consultarIndiceMenu($strNivelDescricao, &$arrStrMenuItens){
        $intIndiceEncontrado = -1;
        
        for($intI=0; $intI<count($arrStrMenuItens); $intI++){
            if(isset($arrStrMenuItens[$intI]["DESCRICAO"])){
                if($arrStrMenuItens[$intI]["DESCRICAO"] == $strNivelDescricao){
                    $intIndiceEncontrado = $intI;                
                    break;
                }
            }
        }
        
        return $intIndiceEncontrado;
    }
    
    if(isset($_GET["modulo"])){
        $arrStrFiltros = array();
        $arrStrFiltros["MOD_ID"]     = $_GET["modulo"];
        $arrStrFiltros["FRM_Status"] = "A";
        $arrObjFormularios           = FachadaGerencial::getInstance()->consultarFormulario($arrStrFiltros);
        $arrObjFormularios           = $arrObjFormularios["objects"];
        
        if($arrObjFormularios != null){
            if(count($arrObjFormularios) > 0){                
                $arrStrMenuItens = array();                
                
                for($intI=0;$intI<count($arrObjFormularios);$intI++){                       
                    // verifica se há permissão para exibir o menu do 
                    // formulário para o usuário                    
                    if(permitirFormulario($arrObjFormularios[$intI], $arrObjPermissoesSistema)){  
                        $objFormulario    = $arrObjFormularios[$intI];
                        
                        // pega o caminho do módulo
                        $arrStrModuloFiltros           = array();
                        $arrStrModuloFiltros["MOD_ID"] = $objFormulario->getModulo()->getId();
                        $arrObjModulos       = FachadaGerencial::getInstance()->consultarModulo($arrStrModuloFiltros);  
                        
                        $strCaminhoModulo = SISTEMA_HTTP."/modulos/".$arrObjModulos["objects"][0]->getCaminho(); // caminho módulo
                        $strCaminho       = SISTEMA_HTTP."/modulos/".$arrObjModulos["objects"][0]->getCaminho();
                        $strCaminho      .= $objFormulario->getCaminho();
                        
                        // o nível 1 é OBRIGATÓRIO existir
                        $strNivel1 = utf8_decode($objFormulario->getNivel1Descricao());
                        $strNivel2 = utf8_decode($objFormulario->getNivel2Descricao());
                        $strNivel3 = utf8_decode($objFormulario->getNivel3Descricao());
                         
                        if(trim($strNivel1) != ""){
                            if(!isset($arrStrMenuItens["NIVEL1"])){
                                $arrStrMenuItens["NIVEL1"] = array();
                            }
                            
                            // identifica em qual posição encontra-se o nível
                            // essa pesquisa é realizada pela descrição do menu
                            // sobre o array do respectivo nível
                            $intIndiceNivel1 = consultarIndiceMenu($strNivel1, $arrStrMenuItens["NIVEL1"]);
                            
                            if($intIndiceNivel1 == -1){
                                // novo menu
                                $arrStrDados = array();
                                $arrStrDados["DESCRICAO"] = $strNivel1;
                                $arrStrDados["CAMINHO"] = $strCaminho;
                                $arrStrDados["ID"] = $objFormulario->getId();
                                $arrStrMenuItens["NIVEL1"][] = $arrStrDados;
                                $intIndiceNivel1 = count($arrStrMenuItens["NIVEL1"]) - 1; // calcula o índice do nível 1
                            }
                            
                            // verificando existência do nível 2
                            if(trim($strNivel2) != ""){                                
                                // cria o nível 2
                                if(!isset($arrStrMenuItens["NIVEL1"][$intIndiceNivel1]["NIVEL2"])){
                                    $arrStrMenuItens["NIVEL1"][$intIndiceNivel1]["NIVEL2"] = array();                                
                                }
                                                        
                                // nível 2
                                $intIndiceNivel2 = consultarIndiceMenu($strNivel2, $arrStrMenuItens["NIVEL1"][$intIndiceNivel1]["NIVEL2"]);

                                if($intIndiceNivel2 == -1){                                
                                    // novo menu
                                    $arrStrDados = array();
                                    $arrStrDados["DESCRICAO"] = $strNivel2;
                                    $arrStrDados["CAMINHO"] = $strCaminho;
                                    $arrStrDados["ID"] = $objFormulario->getId();
                                    $arrStrMenuItens["NIVEL1"][$intIndiceNivel1]["NIVEL2"][] = $arrStrDados;                                
                                    $intIndiceNivel2 = count($arrStrMenuItens["NIVEL1"][$intIndiceNivel1]["NIVEL2"]) - 1;
                                }
                                
                                // nível 3
                                if(trim($strNivel3) != ""){
                                    if(!isset($arrStrMenuItens[$intIndiceNivel2]["nivel3"])){
                                        $arrStrMenuItens[$intIndiceNivel1][$intIndiceNivel2]["nivel2"] = array();                                
                                    }
                                    
                                    // índice do nível 3
                                    $intIndiceNivel3 = consultarIndiceMenu($strNivel3, $arrStrMenuItens["NIVEL1"][$intIndiceNivel1]["NIVEL2"][$intIndiceNivel2]["NIVEL3"]);
                                    
                                     if($intIndiceNivel3 == -1){
                                        // novo menu
                                        $arrStrDados["DESCRICAO"] = $strNivel3;
                                        $arrStrDados["CAMINHO"] = $strCaminho;
                                        $arrStrDados["ID"] = $objFormulario->getId();
                                        $arrStrMenuItens["NIVEL1"][$intIndiceNivel1]["NIVEL2"][$intIndiceNivel2]["NIVEL3"][] = $arrStrDados;                                
                                    }
                                }
                            }                            
                        }
                    }
                }
?>

<div id="menu">
    <ul id="navmenu-v">
    <?php
        $boolResumo = true;
    
        if(isset($boolHabilitarResumo)){
            if(!$boolHabilitarResumo){
                $boolResumo = false;
            }
        }
        
        if($boolResumo){
    ?>
    <li>
        <a href="javascript: void(0);" onclick="exibirTela('content-modulo', '<?php echo $strCaminhoModulo; ?>resumo.php');">Resumo</a>
    </li>
                
<?php
        }

                for ($intI=0;$intI<count($arrStrMenuItens["NIVEL1"]);$intI++) {
?>
        
        <li>
<?php                    
                    $boolExisteNivel2 = false;
                    
                    // caso exista o nível 2
                    // o menu é montado sem o link
                    if(isset($arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"])){
                        $boolExisteNivel2 = true;
                    }

                    if (!$boolExisteNivel2) {
?>
            <a href="javascript: void(0);" onclick="exibirTela('content-modulo', '<?php echo $arrStrMenuItens["NIVEL1"][$intI]["CAMINHO"]."?FRM_ID=".$arrStrMenuItens["NIVEL1"][$intI]["ID"]; ?>');"><?php echo utf8_encode($arrStrMenuItens["NIVEL1"][$intI]["DESCRICAO"]); ?></a>
<?php
                    } else {                       
?>
            <a href="javascript: void(0);"><?php echo utf8_encode($arrStrMenuItens["NIVEL1"][$intI]["DESCRICAO"]); ?></a>
            <ul>
<?php
                
                    if(isset($arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"])){
                        for ($intJ=0;$intJ<count($arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"]);$intJ++) {
?>
                <li>
<?php                            
                            $boolExisteNivel3 = false;

                            // caso exista o nível 3
                            // o menu é montado sem o link
                            if(isset($arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["NIVEL3"])){
                                $boolExisteNivel3 = true;
                            }

                            if (!$boolExisteNivel3) {
?>
                    <a href="javascript: void(0);" onclick="exibirTela('content-modulo', '<?php echo $arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["CAMINHO"]."?FRM_ID=".$arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["ID"]; ?>');"><?php echo utf8_encode($arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["DESCRICAO"]); ?></a>
<?php
                            } else {
?>
                    <a href="javascript: void(0);"><?php echo utf8_encode($arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["DESCRICAO"]); ?></a>
                    <ul>
<?php
                                for ($intK=0;$intK<count($arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["NIVEL3"]);$intK++) {
?>
                        <li>
                            <a href="javascript: void(0);" onclick="exibirTela('content-modulo', '<?php echo $arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["NIVEL3"][$intK]["CAMINHO"]."?FRM_ID=".$arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["NIVEL3"][$intK]["ID"]; ?>');"><?php echo utf8_encode($arrStrMenuItens["NIVEL1"][$intI]["NIVEL2"][$intJ]["NIVEL3"][$intK]["DESCRICAO"]); ?></a>
                        </li>
<?php
                                }
?>
                    </ul>
<?php
                            }
?>
                </li>
<?php
                        }
                    }
?>
            </ul>
<?php
                    }
?>
        </li>
<?php
                }
            }
        }
    }

?>
    </ul>
</div>