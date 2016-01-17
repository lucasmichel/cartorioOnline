<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/financeiro";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmPlanoConta.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Plano de Contas Cadastrado</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">
                    <fieldset class="coluna">
                        <label for="txtPesquisa">Plano de Contas</label>
                        <input type="text" id="txtPesquisaDescricao" name="CCA_Descricao" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa();?>" class="campoTextoPadrao" style="width: 250px;"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaMovimentacao">Movimenta&ccedil;&atilde;o</label>
                        <select id="selPesquisaMovimentacao" name="PLA_Movimentacao" class="campoSelect"> 
                            <option value="" selected>TODAS</option>
                            <option value="E">ENTRADA</option>  
                            <option value="S">SA&Iacute;DA</option>  
                        </select>                    
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaTipo">Tipo</label>
                        <select id="selPesquisaTipo" name="PLA_Tipo" class="campoSelect"> 
                            <option value="" selected>TODOS</option>
                            <option value="S">SINT&Eacute;TICO</option>  
                            <option value="A">ANAL&Iacute;TICO</option>  
                        </select>                    
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaStatus">Status</label>
                        <select id="selPesquisaStatus" name="CCA_Status" class="campoSelect"> 
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
            <form id="frmCadastro" action="<?php echo $strDir; ?>/controladores/PlanoContaControlador.php" method="POST">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="PLA_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="coluna">
                    <label for="txtDescricao">Descri&ccedil;&atilde;o*</label>
                    <input type="text" id="txtDescricao" name="PLA_Descricao" class="campoTextoPadrao" placeholder="DESCRI&Ccedil;&Atilde;O PARA O PLANO DE CONTAS." style="width: 250px;"/>
                </fieldset>                
                <fieldset class="linha">
                    <label for="txtCodigoContabil">C&oacute;digo Cont&aacute;bil*</label>
                    <input type="text" id="txtCodigoContabil" name="PLA_CodigoContabil" class="campoTextoPadrao" style="width: 250px;" maxlength="45" placeholder="Ex.: 1.1.01"/>
                </fieldset>
                <fieldset class="linha">
                    <label for="txtCodigoContabil">Movimenta&ccedil;&atilde;o*</label>
                    <input type="radio" id="rdbTipoMovimentoE" name="PLA_Movimentacao" value="E" checked onclick="gerenciarTipo();"/>Entrada
                    <input type="radio" id="rdbTipoMovimentoS" name="PLA_Movimentacao" value="S" onclick="gerenciarTipo();"/>Sa&iacute;da
                </fieldset>
                <fieldset class="linha">
                    <label for="txtCodigoContabil">Tipo*</label>
                    <input type="radio" id="rdbTipoS" name="PLA_Tipo" value="S" checked onclick="gerenciarTipo();"/>Sint&eacute;tico
                    <input type="radio" id="rdbTipoA" name="PLA_Tipo" value="A" onclick="gerenciarTipo();"/>Anal&iacute;tico
                </fieldset>
                
                <fieldset class="linha" id="fieldsetContaPai" style="margin-top: 10px;">
                    <div class="side-by-side clearfix">
                        <label for="selContaPai">Conta Pai*</label>                                
                        <select data-placeholder="SELECIONE A CONTA PAI." name="PLA_CodigoContabilPai" class="chosen-select-deselect" id="selContaPai" style="width: 270px;">
                            <option value=""></option>
                        </select>
                    </div>
                </fieldset>
                
                <fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" name="PLA_Status" value="I" class="status" style="margin-top: 10px;"/>Inativo
                </fieldset>
                <fieldset class="linha">
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