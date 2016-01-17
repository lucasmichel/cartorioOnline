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
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmFluxoCaixa.js"></script> 
</head>

<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Fluxo de Caixa (Movimentos Cadastrados)</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label><input id="rdbPesquisaPessoa" type="radio"  name="LCA_OrigemPesquisa" value="P" onclick="gerenciarTipoOrigemPesquisa();"/>Membro/Funcion&aacute;rio<input value="F" id="rdbPesquisaFornecedor" type="radio" name="LCA_OrigemPesquisa" onclick="gerenciarTipoOrigemPesquisa();" checked/>Fornecedor</label>                                
                            <fieldset class="coluna" id="colunaPesquisaPessoa">
                                <select data-placeholder="FILTRO POR MEMBRO/FUNCION&Aacute;RIO." class="chosen-select-deselect" id="selPesquisaPessoa" style="width: 250px;" >
                                    <option value=""></option>                                    
                                    <?php
                                        /*$arrStrFiltros["PES_Status"] = "A";
                                        $arrObjs  = FachadaGerencial::getInstance()->consultarPessoa($arrStrFiltros);
                                        
                                        if($arrObjs != null){                                                                                           
                                            for($intI=0; $intI<count($arrObjs); $intI++){
                                               echo '<option value="'. $arrObjs[$intI]->getId().'">'. $arrObjs[$intI]->getNome().'</option>';
                                            }
                                        }*/
                                    ?> 
                                </select>
                            </fieldset>
                            <fieldset class="coluna" id="colunaPesquisaFornecedor">
                                <select data-placeholder="FILTRO POR FORNECEDOR." class="chosen-select-deselect" id="selPesquisaFornecedor" style="width: 250px;" >
                                    <option value=""></option>                                    
                                    <?php
                                        $arrStrFiltros["FOR_Status"] = "A";
                                        $arrObjs  = FachadaFinanceiro::getInstance()->consultarFornecedor($arrStrFiltros);
                                        if($arrObjs != null){
                                            $arrObjs = $arrObjs["objects"];                                                
                                            for($intI=0; $intI<count($arrObjs); $intI++){
                                               echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNomeFantasia().'</option>';
                                            }
                                        }
                                    ?> 
                                </select>
                            </fieldset>
                        </div>
                    </fieldset>  
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPesquisaTipoMovimento">Movimento</label>                                
                            <select data-placeholder="FILTRO POR MOVIMENTO." class="chosen-select-deselect" id="selPesquisaTipoMovimento" style="width: 200px;">
                                <option value=""></option>
                                <option value="E">ENTRADA</option>
                                <option value="S">SA&Iacute;DA</option>
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPesquisaPlanoConta">Plano de Contas</label>                                
                            <select data-placeholder="FILTRO POR PLANO DE CONTAS." class="chosen-select-deselect" id="selPesquisaPlanoConta" style="width: 250px;">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["PLA_Tipo"] = "A";
                                    $arrStrFiltros["PLA_Status"] = "A";
                                    $arrObjs  = FachadaFinanceiro::getInstance()->consultarPlanoConta($arrStrFiltros);
                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selPesquisaCentroCusto">Centro de Custo</label>                                
                            <select data-placeholder="FILTRO POR CENTOR DE CUSTO." class="chosen-select-deselect" id="selPesquisaCentroCusto" style="width: 250px;" >
                                <option value=""></option>
                                <?php
                                    
                                    $arrStrFiltros["CEN_Status"] = "A";
                                    $arrObjs  = FachadaFinanceiro::getInstance()->consultarCentroCusto($arrStrFiltros);
                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPesquisaContaBancaria">Conta/Caixa Entrada/Sa&iacute;da</label>                                
                        <select data-placeholder="FILTRO POR CONTA." class="chosen-select-deselect" id="selPesquisaContaBancaria" style="width: 250px;" >
                                <option value=""></option>
                                <?php
                                    
                                    $arrStrFiltros["COB_Status"] = "A";
                                    $arrObjs  = FachadaFinanceiro::getInstance()->consultarContaBancaria($arrStrFiltros);
                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna" >
                        <label for="txtPesquisaDataInicial">Data Inicial</label>
                        <input type="text" id="txtPesquisaDataInicial" value="<?php echo date("01/m/Y");?>" class="campoData"> 
                    </fieldset>
                    <fieldset class="coluna" >
                        <label for="txtPesquisaDataFinal">Data Final</label>
                        <input type="text" id="txtPesquisaDataFinal" value="<?php echo date("d/m/Y");?>" class="campoData" >
                    </fieldset>
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>
                    </fieldset>
                </form>
            </div>      
            <div>
                <p align="right">
                    <b>Total R$:</b> <span id="spnTotal"></span>
                </p>
            </div>            
            <div id="grid"></div>
        </div>
        <div id="tabs-2">
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div>                 
                <div id="dialog-excluir" title="Exce&ccedil;&atilde;o">
                    <input type="hidden" id="hddIDExcluir" />
                    <p id="dialogMensagemExcluir"></p>
                </div>
                               
                <?php
                    include("inc/adicionarOrigemFornecedor.inc.php");
                    include("inc/adicionarOrigemPessoa.inc.php");
                    include("inc/adicionarPlanoConta.inc.php");
                    include("inc/adicionarContaBancaria.inc.php");
                    include("inc/adicionarCentroCusto.inc.php");
                    include("inc/adicionarFormaPagamento.inc.php");
                ?>
            </div><!-- dialogs --> 
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" name="frmCadastro" action="<?php echo $strDir;?>/controladores/FluxoCaixaControlador.php" method="POST" onSubmit="return false;">
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>                
                <input type="hidden" id="hddID" name="LCA_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/> 
                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label>Tipo*</label>
                        <select data-placeholder="SELECIONE O TIPO DO MOVIMENTO." onchange="gerenciarTipoMovimentacao(); getPlanoContasDinamico();" style="width: 100px;" class="chosen-select-deselect" id="selTipo"  name="LCA_Tipo">
                            <option value="E">ENTRADA</option>
                            <option value="S">SA&Iacute;DA</option>
                        </select>
                    </fieldset>
                </fieldset>
                
                <fieldset class="linha">                        
                    <fieldset class="coluna">
                        <label for="txtData">Data*</label>
                        <input type="text" id="txtData" name="LCA_DataMovimento" class="campoData" placeholder="__/__/____"/>                
                    </fieldset>                    
                    <fieldset class="coluna">
                        <?php
                            echo ReferenciaSelectComponente::getInstance()->gerar("selReferencia", "LCA_Referencia", "Refer&ecirc;ncia");
                        ?>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtValor">Valor (R$)*</label>
                        <input type="text" id="txtValor" name="LCA_Valor" class="campoTextoPadrao" value="0,00" style="width: 113px;"/>
                    </fieldset> 
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPlanoConta">Plano de Contas* <a href="javascript: void(0);" onclick="janelaAdicionarPlanoConta();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                            <select data-placeholder="SELECIONE O PLANO DE CONTAS." style="width:312px;" class="chosen-select-deselect" id="selPlanoConta"  name="PLA_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["PLA_Status"] = "A"; // ativa
                                    $arrStrFiltros["PLA_Tipo"] = "A"; // anal�tica                                    
                                    $arrObjConta  = FachadaFinanceiro::getInstance()->consultarPlanoConta($arrStrFiltros);
                                    if($arrObjConta != null){
                                        $arrObj = $arrObjConta["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>            
                </fieldset>
                
                <fieldset class="linha">
                    <fieldset class="linha">
                        <label>Hist&oacute;rico*</label>
                        <input type="text" id="txtHistorico" name="LCA_Descricao" class="campoTextoPadrao" style="width: 702px;"/>
                    </fieldset>
                </fieldset>
                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selContaBancaria">Conta/Caixa de Entrada/Sa&iacute;da* <a href="javascript: void(0);" onclick="janelaAdicionarContaBancaria();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                            <select data-placeholder="SELECIONE A CONTA BANC&Aacute;RIA." style="width:406px;" class="chosen-select-deselect" id="selContaBancaria"  name="COB_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["COB_Status"] = "A";
                                    $arrObjCentroCusto  = FachadaFinanceiro::getInstance()->consultarContaBancaria($arrStrFiltros);
                                    if($arrObjCentroCusto != null){
                                        $arrObj = $arrObjCentroCusto["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selCentroCusto">Centro de Custo* <a href="javascript: void(0);" onclick="janelaAdicionarCentroCusto();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                            <select data-placeholder="SELECIONE O CENTRO DE CUSTO." style="width:313px;" class="chosen-select-deselect" id="selCentroCusto"  name="CEN_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["CEN_Status"] = "A";
                                    $arrObjCentroCusto  = FachadaFinanceiro::getInstance()->consultarCentroCusto($arrStrFiltros);
                                    if($arrObjCentroCusto != null){
                                        $arrObj = $arrObjCentroCusto["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getDescricao()).'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>  
                </fieldset>
                <fieldset class="linha">
                    <input type="radio" id="rdbPessoa" onclick="gerenciarTipoOrigem();" name="LCA_TipoOrigem" value="P"/>Origem/Destino em Membro/Funcion&aacute;rio
                    <input type="radio" id="rdbFornecedor" onclick="gerenciarTipoOrigem();" name="LCA_TipoOrigem" checked value="F"/>Origem/Destino em Fornecedores
                </fieldset>
                <fieldset class="linha">
                    <fieldset class="coluna" id="fieldsetPessoa">
                        <div class="side-by-side clearfix">
                            <label id="labelOrigemPessoa" for="selOrigemPessoa">Origem* <a href="javascript: void(0);" onclick="janelaAdicionarPessoa();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                            <select data-placeholder="SELECIONE UM MEMBRO/FUNCION&Aacute;RIO." style="width:406px;" class="chosen-select-deselect" id="selOrigemPessoa"  name="PES_ID">
                                <option value=""></option>
                                <?php
                                    /*$arrStrFiltros["PES_Status"] = "A";
                                    $arrObjPessoas  = FachadaGerencial::getInstance()->consultarPessoa($arrStrFiltros);
                                    
                                    if($arrObjPessoas != null){
                                        $arrObjs = $arrObjPessoas;                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNome().'</option>';
                                        }
                                    }*/
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna" id="fieldsetFornecedor">
                        <div class="side-by-side clearfix">
                            <label id="labelOrigemFornecedor" for="selOrigemFornecedor">Origem* <a href="javascript: void(0);" onclick="janelaAdicionarFornecedor();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                            <select data-placeholder="SELECIONE UM FORNECEDOR." style="width:406px;" class="chosen-select-deselect" id="selOrigemFornecedor"  name="FOR_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["FOR_Status"] = "A";
                                    $arrObjFornecedores  = FachadaFinanceiro::getInstance()->consultarFornecedor($arrStrFiltros);
                                    $arrObjFornecedores = $arrObjFornecedores["objects"];
                                    
                                    if($arrObjFornecedores != null){
                                        $arrObjs = $arrObjFornecedores;                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNomeFantasia().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selFormaPagamento">Forma de Pagamento* <a href="javascript: void(0);" onclick="janelaAdicionarFormaPagamento();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                            <select data-placeholder="SELECIONE A FORMA DE PAGAMENTO." style="width:313px;" class="chosen-select-deselect" id="selFormaPagamento"  name="FPG_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["FPG_Status"] = "A";
                                    $arrObjs  = FachadaFinanceiro::getInstance()->consultarFormaPagamento($arrStrFiltros);
                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                </fieldset>
                <fieldset class="linha">
                    <label for="txtAnotacao">Anota&ccedil;&otilde;es</label>                                                        
                    <textarea id="txtAnotacao" name="LCA_Observacao" class="campoTextoPadrao" rows="5" style="width: 702px;"></textarea>
                </fieldset>                    
                
                <!--<fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" name="DIO_Status" value="I" class="status"/>Inativo
                </fieldset>-->
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