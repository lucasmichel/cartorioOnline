<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");  
    
    // diretório do módulo
    $strDir = "../../sistema/gerencial";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmModulo.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Subm&oacute;dulos Sistema</a></li>            
        </ul>
        <div id="tabs-1">
            <div id="dialogs">                
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
            </div><!-- dialogs -->
            <form id="frm" onSubmit="return false;">
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <fieldset class="coluna">
                    <label for="txtDescricao">M&oacute;dulo</label>
                    <select id="selPesquisaCategoria" name="MCT_ID" class="campoTextoPadrao" style="width: 250px;">
                        <option value=""></option>
                        <?php                            
                            $arrObjs = FachadaGerencial::getInstance()->consultarModuloCategoria(null);
                            $arrObjs = $arrObjs["objects"];
                            
                            $strOption = '';
                            
                            for($intI=0; $intI<count($arrObjs); $intI++){
                                $strOption .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                            }
                            
                            echo $strOption;
                        ?>
                    </select>
                </fieldset>
                <fieldset class="coluna">
                    <label for="txtPesquisaDescricao">Subm&oacute;dulo</label>
                    <input type="text" id="txtPesquisaDescricao" name="MOD_Descricao" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa()?>" class="campoTextoPadrao" style="width: 280px;"/>
                </fieldset> 
                <fieldset class="coluna">                                                    
                    <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>
                </fieldset>
            </form>
            <div id="grid" style="margin-top: 20px;"></div><!-- grid -->
        </div><!-- tabs-1 -->
    </div><!-- tabs -->
    <script type="text/javascript">
        init();
    </script>
</body>
</html>