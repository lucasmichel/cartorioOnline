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
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmModuloCategoria.js"></script>       
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">M&oacute;dulos Sistema</a></li>            
        </ul>
        <div id="tabs-1">
            <div id="dialogs">                
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
            </div><!-- dialogs -->
            <form id="frm" onSubmit="return false;">
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <fieldset class="coluna">
                    <label for="txtPesquisaDescricao">M&oacute;dulo</label>
                    <input type="text" id="txtPesquisaDescricao" name="MCT_Descricao" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa()?>" class="campoTextoPadrao" style="width: 280px;"/>
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