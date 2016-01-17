<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    $strDir = "../../livroRegistro/tipo-linha-livro";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmTipoLinhaLivro.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Tipos de Linhas Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Descri&ccedil;&atilde;o</label>
                        <input type="text" id="txtPesquisaDescricao" name="txtPesquisa" class="campoTextoPadrao" style="width: 350px" placeholder="DIGITE A DESCRIÇÃO" />
                    </fieldset>
                    
                    <fieldset class="coluna"> 
                        <label for="selTipoPesquisa">Tipo</label>
                        <select id="selTipoPesquisa" class="campoSelect" name="TIL_Tipo">
                            <option value="">TODAS</option>
                            <option value="D">DESPESA</option>
                            <option value="R">RECEITA</option>
                        </select>
                    </fieldset>
                    
                    <fieldset class="coluna"> 
                        <label>Status</label>
                        <select id="selPesquisaStatus" class="campoSelect">
                            <option value="">TODOS</option>
                            <option value="A">ATIVO</option>
                            <option value="I">INATIVO</option>
                        </select>                        
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
            <form id="frmCadastro" name="frmFormulario" action="<?php echo $strDir;?>/controladores/TipoLinhaLivroControlador.php" method="POST">
                <input type="hidden" id="hddAcao" name="ACO_Descricao" value="Salvar"/>
                <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="TIL_ID"/>                
                <input type="hidden" id="hddFocus"/>  
                
                <fieldset class="linha">
                    <label for="txtDescricao">Descri&ccedil;&atilde;o*</label>
                    <input type="text" id="txtDescricao" name="TIL_Descricao" class="campoTextoPadrao" style="width: 400px" placeholder="DESCRIÇÃO DA LINHA" />
                </fieldset>
                
                <fieldset class="linha"> 
                    <label for="selTipo">Tipo*</label>
                    <select id="selTipo" class="campoSelect" name="TIL_Tipo">
                        <option value="D">DESPESA</option>
                        <option value="R">RECEITA</option>
                    </select>                        
                </fieldset>
                
                
                
                
                <fieldset class="linha" style="margin-top: 10px;">
                    <input type="checkbox" id="ckbStatus" name="TIL_Status" value="I" />Inativo<br />
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