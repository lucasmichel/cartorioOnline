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
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmTransferenciaContas.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Transferências de Contas Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">  
                                        
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataInicial">Data Inicial</label>
                        <input type="text" id="txtPesquisaDataInicial" name="TRC_DataTransferenciaInicial" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisaDataInicial();?>" class="campoData" value="<?php echo date("01/m/Y"); ?>"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataFinal">Data Final</label>
                        <input type="text" id="txtPesquisaDataFinal" name="TRC_DataTransferenciaFinal" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisaDataFinal();?>" class="campoData" value="<?php echo date("d/m/Y"); ?>"/>                        
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
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/TransferenciaContaControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="BAN_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selContaOrigem">Conta origem*</label>                                
                        <select data-placeholder="SELECIONAR CONTA ORIGEM." class="chosen-select-deselect" id="selContaOrigem" name="COB_De_ID" style="width: 260px;" onchange="preencherValorContaDe();">
                                <option value=""></option>
                                <?php                                
                                    $arrStrFiltrosContaDe["COB_Status"] = "A";
                                    $arrObjsDe  = FachadaFinanceiro::getInstance()->consultarContaBancaria($arrStrFiltrosContaDe);
                                    if($arrObjsDe != null){
                                        $arrObjsDe = $arrObjsDe["objects"];                                                
                                        for($intI=0; $intI<count($arrObjsDe); $intI++){
                                            $contaDe = new ContaBancaria();
                                            $contaDe = $arrObjsDe[$intI];
                                           echo '<option value="'. $contaDe->getId().'">'.$contaDe->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna" id="saldoAtualContaOrigem">
                    </fieldset>
                </fieldset>
                
                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selContaDestino">Conta destino*</label>                                
                        <select data-placeholder="SELECIONAR CONTA DESTINO." class="chosen-select-deselect" id="selContaDestino" name="COB_Para_ID" style="width: 260px;" onchange="preencherValorContaPara();" >
                                <option value=""></option>
                                <?php                                
                                    $arrStrFiltrosContaPara["COB_Status"] = "A";
                                    $arrObjsPara  = FachadaFinanceiro::getInstance()->consultarContaBancaria($arrStrFiltrosContaPara);
                                    if($arrObjsPara != null){
                                        $arrObjsPara = $arrObjsPara["objects"];                                                
                                        for($intI=0; $intI<count($arrObjsPara); $intI++){
                                            $contaPara = new ContaBancaria();
                                            $contaPara = $arrObjsPara[$intI];
                                           echo '<option value="'. $contaPara->getId().'">'.$contaPara->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna" id="saldoAtualContaDestino">
                    </fieldset>
                </fieldset>
                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="txtValor">Valor(R$)*</label>
                        <input type="text" id="txtValor" name="TRC_Valor" class="campoValor" value="0,00" style="font-weight: bolder" />
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtDataTransferencia">Data da transeferência*</label>
                        <input type="text" class="campoData" id="txtDataTransferencia" name="TRC_DataTransferencia" placeholder="__/__/____"/>
                    </fieldset>
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