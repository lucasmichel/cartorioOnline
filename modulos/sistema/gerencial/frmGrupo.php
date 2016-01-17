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
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmGrupo.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Grupos de Usu&aacute;rios Cadastrados</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">  
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Grupo</label>
                        <input type="text" id="txtPesquisaDescricao" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa();?>" class="campoTextoPadrao" style="width: 250px;"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaStatus">Status</label>
                        <select id="selPesquisaStatus" class="campoSelect">                            
                            <option value="A" selected>ATIVO</option>
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
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/GrupoControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="GRU_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="linha">
                    <label for="txtDescricao">Descri&ccedil;&atilde;o*</label>
                    <input type="text" id="txtDescricao" name="GRU_Descricao" class="campoTextoPadrao" style="width: 250px;" placeholder="DESCRI&Ccedil;&Atilde;O DO GRUPO." />
                </fieldset>
                <fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" name="GRU_Status" value="I" />Inativo<br />
                </fieldset>
                <fieldset class="linha">
                    <input type="button" value="Salvar" onclick="salvar();" class="botao" id="btnSalvar"/>
                    <input type="button" value="Cancelar" onclick="cancelar();" class="botao"/>
                </fieldset>                
            </form>            
        </div>      
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>