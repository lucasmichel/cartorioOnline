<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    $strDir = "../../livroRegistro/grafico-impressao";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmPrintLivroPrevio.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Impressão de Livro Prévio</a></li>            
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">
                    <fieldset class="coluna">                    
                        <label for="selLivroPesquisa">Livro</label>
                        <div class="side-by-side clearfix">                                                            
                            <select data-placeholder="SELECIONE O LIVRO" style="width:200px;" class="chosen-select-deselect"  id="selLivroPesquisa"  onchange="preencheFolhaPesquisa();">
                                <option value="">TODOS</option>
                                <?php
                                    $arrStrFiltros[""] = null;                                    
                                    $arrObjs = FachadaLivroPrevio::getInstance()->consultarLivroPrevio($arrStrFiltros);

                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNumero().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna" >                    
                        <label for="selFolhaPesquisa">Folha</label>
                        <div class="side-by-side clearfix">                                                            
                        <select data-placeholder="SELECIONE A FOLHA" style="width:200px;" class="chosen-select-deselect"  id="selFolhaPesquisa" >
                            <option value="">TODAS</option>
                        </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>
                    </fieldset>
                </form>
            </div>            
            <?php
                // exportacao de conteúdo
                include("../../sistema/gerencial/inc/export.inc.php");  
            ?>
            <div id="relatorio" style="margin-top: 20px; width: 100%; height: 325px;" ></div>
        </div>             
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>