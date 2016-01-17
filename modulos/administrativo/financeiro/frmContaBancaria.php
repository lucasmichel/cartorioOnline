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
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmContaBancaria.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Contas Banc&aacute;rias Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">  
                    <fieldset class="coluna">
                        <label for="selPesquisaBanco">Banco</label>
                        <select id="selPesquisaBanco" name="BAN_ID" class="campoSelect">
                            <option value="">TODOS</option>
                            <?php
                                $arrStrFiltros = array();
                                $arrStrFiltros["BAN_Status"] = "A";
                                $arrObjs = FachadaFinanceiro::getInstance()->consultarBanco($arrStrFiltros);
                                $arrObjs = $arrObjs["objects"];
                                $strHtml = '';                            

                                for($intI=0; $intI<count($arrObjs); $intI++){
                                    $strHtml .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().' (COD. '.$arrObjs[$intI]->getCodigo().') '.'</option>';
                                }

                                echo $strHtml;
                            ?>
                        </select>
                    </fieldset> 
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Conta Banc&aacute;ria</label>
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
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/ContaBancariaControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="COB_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="txtDescricao">Descri&ccedil;&atilde;o* </label>
                        <input type="text" id="txtDescricao" name="COB_Descricao" class="campoTextoPadrao" style="width: 259px;" placeholder="Ex.: Conta, Poupan&ccedil;a, etc" />
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selBanco">Banco*</label>
                        <select id="selBanco" name="BAN_ID" data-placeholder="SELECIONE O BANCO." class="chosen-select-deselect" style="width: 281px;">
                            <option value=""></option>
                            <?php
                                $arrStrFiltros = array();
                                $arrStrFiltros["BAN_Status"] = "A";
                                $arrObjs = FachadaFinanceiro::getInstance()->consultarBanco($arrStrFiltros);
                                $arrObjs = $arrObjs["objects"];
                                $strHtml = '';                            

                                for($intI=0; $intI<count($arrObjs); $intI++){
                                    $strHtml .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().' (COD. '.$arrObjs[$intI]->getCodigo().') '.'</option>';
                                }

                                echo $strHtml;
                            ?>
                        </select>
                    </fieldset>                    
                </fieldset>
                <fieldset class="linha" style="margin-top: 10px;">
                    <fieldset class="coluna">
                        <label for="txtAgencia">Ag&ecirc;ncia*</label>
                        <input type="text" id="txtAgencia" name="COB_Agencia" class="campoTextoPadrao" />
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtConta">Conta*</label>
                        <input type="text" id="txtConta" name="COB_Conta" class="campoTextoPadrao" style="width: 120px;" />
                    </fieldset> 
                    <fieldset class="coluna">
                        <label for="txtDataAbertura">Data Abertura</label>
                        <input type="text" id="txtDataAbertura" name="COB_DataAbertura" class="campoData" placeholder="__/__/____" />
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtSaldoInicial">Saldo Inicial*</label>
                        <input type="text" id="txtSaldoInicial" name="COB_SaldoInicial" class="campoTextoPadrao" value="0,00" style="width: 100px;"  />
                    </fieldset>
                </fieldset>
                
                <fieldset class="linha" style="margin-top: 10px;">
                    <fieldset class="linha">
                        <label for="txtSite">Anota&ccedil;&otilde;es</label>
                        <textarea id="txtObservacao" name="COB_Observacao" rows="5" class="campoTextoPadrao" style="width: 544px;"></textarea>
                    </fieldset>
                </fieldset>
                
                <fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" name="COB_Status" value="I" />Inativo<br />
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