<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    $strDir = "../../livroRegistro/livro-previo";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmLivroPrevio.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Livros Prévios Cadastrados</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">
                    <fieldset class="coluna">
                        <label for="txtPesquisaNumero">Numero do livro</label>
                        <input type="text" id="txtPesquisaNumero" name="txtPesquisaNumero" class="campoTextoPadrao" style="width: 350px" placeholder="DIGITE O Nº DO LIVRO" />
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataCadastro">Data de Cadastro</label>
                        <input type="text" id="txtPesquisaDataCadastro" name="txtPesquisaData" class="campoTextoPadrao" style="width: 120px" placeholder="__/__/____" />
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>
                    </fieldset>
                </form>
            </div>
            <div id="grid" style="margin-top: 20px;"></div>
        </div>
        <div id="tabs-2">
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>                
                <!-- Janelas -->
                <div id="dialog-excluir" title="Exclusão">
                    <p id="dialogMensagemExcluir"></p>
                </div>
            </div><!-- dialogs -->
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" name="frmFormulario" action="<?php echo $strDir;?>/controladores/LivroPrevioControlador.php" method="POST">
                <input type="hidden" id="hddAcao" name="ACO_Descricao" value="Salvar"/>
                <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="LIP_ID"/>                
                <input type="hidden" id="hddFocus"/>                
                <fieldset class="linha">                    
                    <label for="txtNumeroLivro">Nº do Livro</label>
                    <input type="text" id="txtNumeroLivro" name="LIP_NumeroLivro" class="campoTextoPadrao" style="width: 350px" placeholder="NUMERO DO LIVRO" />
                </fieldset>
                
                <fieldset class="linha" style="margin-top: 10px;">
                    <input type="button" value="Salvar" onclick="salvar();" class="botao" id="btnSalvar"/><input type="button" value="Cancelar" onclick="cancelar();" class="botao"/>
                </fieldset>                
            </form>            
        </div>      
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>