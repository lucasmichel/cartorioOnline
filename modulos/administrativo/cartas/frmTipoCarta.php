<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/cartas";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <!-- jQuery Tinymce -->        
    <script type="text/javascript" src="../../../js/jquery.tinymce/tinymce.min.js"></script>
    <!-- jQuery Tinymce --> 
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmTipoCarta.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Modelos de Cartas Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">  
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Modelo de Carta</label>
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
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/TipoCartaControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="TCA_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <input type="hidden" id="hddTexto" name="TCA_Texto"/>
                
                <fieldset class="linha">
                    <label for="txtDescricao">Descri&ccedil;&atilde;o do Modelo*</label>
                    <input type="text" id="txtDescricao" name="TCA_Descricao" class="campoTextoPadrao" style="width: 500px;" placeholder="" />
                </fieldset>
                <p>
                    <strong>Hashtags:</strong> <span style="background-color: #EEE; padding: 5px;">#nomedomembro</span> (Exibe o nome do membro)
                </p>
                <fieldset class="linha" style="margin-top: 20px;">                    
                    <textarea id="txtConteudo" style="width:100%; height: 500px;"></textarea>
                </fieldset>                
                <fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" name="TCA_Status" value="I" />Inativo<br />
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
        tinymce.get("txtConteudo").setContent('');
    </script>
</body>
</html>