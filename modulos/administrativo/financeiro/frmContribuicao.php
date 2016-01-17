<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");      
    
    // diret�rio do módulo
    $strDir = "../../administrativo/financeiro";     
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>           
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmContribuicao.js"></script> 
</head>

<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Contribui&ccedil;&otilde;es Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selPesquisaPessoa">Origem (Pessoa)</label>                                
                            <select data-placeholder="FILTRO POR PESSOA." class="chosen-select-deselect" id="selPesquisaPessoa" style="width: 250px;" >
                                <option value=""></option>
                                <option value="N/I">N&Atilde;O IDENTIFICADO</option>
                                <?php
                                    $arrStrFiltros["PES_Status"] = "A";
                                    $arrStrFiltros["GRID"] = true; // simplifica a consulta
                                    $arrObjs  = FachadaGerencial::getInstance()->consultarPessoa($arrStrFiltros);
                                    if($arrObjs != null){                             
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNome().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset> 
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selPesquisaPlanoConta">Plano de Contas</label>                                
                            <select data-placeholder="FILTRO POR PLANO DE CONTAS." class="chosen-select-deselect" id="selPesquisaPlanoConta" style="width: 250px;" >
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
                            <select data-placeholder="FILTRO POR CENTOR DE CUSTO." class="chosen-select-deselect" id="selPesquisaCentroCusto"  style="width: 250px;" >
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
                            <label for="selPesquisaContaBancaria">Conta/Caixa</label>                                
                            <select data-placeholder="FILTRO POR BANC&Aacute;RIA." class="chosen-select-deselect" id="selPesquisaContaBancaria"  style="width: 250px;" >
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
                        <div class="side-by-side clearfix">
                            <label for="selPesquisaLote">Lote</label>                                
                            <select data-placeholder="FILTRAR POR LOTE." class="chosen-select-deselect" id="selPesquisaLote"  style="width: 250px;" >
                                <option value=""></option>
                                <?php                                    
                                    $arrObjs  = FachadaFinanceiro::getInstance()->consultarLote($arrStrFiltros);
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
                    include("inc/adicionarOrigemPessoa.inc.php");
                    include("inc/adicionarPlanoConta.inc.php");
                    include("inc/adicionarContaBancaria.inc.php");
                    include("inc/adicionarCentroCusto.inc.php");
                    include("inc/adicionarFormaPagamento.inc.php");
                    include("inc/adicionarLote.inc.php");
                ?>
            </div><!-- dialogs --> 
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" name="frmCadastro" action="<?php echo $strDir;?>/controladores/ContribuicaoControlador.php" method="POST" onSubmit="return false;">
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>                
                <input type="hidden" id="hddID" name="CTB_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/>                  
                
                
                <fieldset class="linha">
                    <div class="side-by-side clearfix">
                        <label for="selLote">Lote <a href="javascript: void(0);" onclick="janelaAdicionarLote();" title="Adicionar novo lote." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                        <select data-placeholder="SELECIONE O LOTE." style="width:270px;" class="chosen-select-deselect" id="selLote"  name="LOT_ID">
                            <option value=""></option>
                            <?php                                   
                                $arrObjLote  = FachadaFinanceiro::getInstance()->consultarLote($arrStrFiltros);
                                if($arrObjLote != null){
                                    $arrObj = $arrObjLote["objects"];                                                
                                    for($intI=0; $intI<count($arrObj); $intI++){
                                       echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                    }
                                }
                            ?> 
                        </select>
                    </div>
                </fieldset>
                
                <fieldset class="linha">                        
                    <fieldset class="coluna">
                        <label for="txtData">Data*</label>
                        <input type="text" id="txtData" name="CTB_DataContribuicao" class="campoData" placeholder="__/__/____"/>                
                    </fieldset>                    
                    <fieldset class="coluna">
                        <?php
                            echo ReferenciaSelectComponente::getInstance()->gerar("selReferencia", "CTB_Referencia", "Refer&ecirc;ncia");
                        ?>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtValor">Valor (R$)*</label>
                        <input type="text" id="txtValor" name="CTB_Valor" class="campoTextoPadrao" value="0,00" style="width: 113px;"/>
                    </fieldset> 
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selConta">Plano de Contas* <a href="javascript: void(0);" onclick="janelaAdicionarPlanoConta();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
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
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selContaBancaria">Conta/Caixa de Entrada* <a href="javascript: void(0);" onclick="janelaAdicionarContaBancaria();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
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
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPessoa">Pessoa* <a href="javascript: void(0);" onclick="janelaAdicionarPessoa();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                            <select data-placeholder="SELECIONE UMA PESSOA." style="width:406px;" class="chosen-select-deselect" id="selPessoa"  name="PES_ID">
                                <option value="">N&Atilde;O IDENTIFICADO</option>
                                <?php
                                    $arrStrFiltros["PES_Status"] = "A";
                                    $arrObjs  = FachadaGerencial::getInstance()->consultarPessoa($arrStrFiltros);
                                    if($arrObjs != null){                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNome().'</option>';
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
                                    }else{
                                        echo '<option value="">NENHUMA FORMA DE PAGAMENTO CADASTRADA.</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                </fieldset>
                <fieldset class="linha">
                    <label for="txtAnotacao">Anota&ccedil;&otilde;es</label>                                                        
                    <textarea id="txtAnotacao" name="CTB_Observacao" class="campoTextoPadrao" rows="5" style="width: 702px;"></textarea>
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