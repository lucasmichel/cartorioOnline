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
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmContaPagarReceber.js"></script>  
    <style type="text/css">
        .ui-datepicker {z-index:10100 !important;}
    </style>
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Contas a Pagar/Receber</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa">
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label><input id="rdbPesquisaPessoa" type="radio"  name="CON_OrigemPesquisa" value="P"  onclick="gerenciarTipoOrigemPesquisa();"/>Membro/Funcion&aacute;rio<input value="F" id="rdbPesquisaFornecedor" type="radio" name="CON_OrigemPesquisa" checked onclick="gerenciarTipoOrigemPesquisa();"/>Fornecedor</label>                                
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
                            <label for="selPesquisaTipo">Tipo</label>
                            <select id="selPesquisaTipo" name="CON_Tipo" class="chosen-select-deselect" style="width: 180px;" data-placeholder="FILTRO POR TIPO.">
                                <option value=""></option>
                                <option value="P">CONTAS A PAGAR</option>
                                <option value="R">CONTAS A RECEBER</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selPesquisaPlanoConta">Plano de Contas</label>                                
                            <select data-placeholder="FILTRO POR PLANO DE CONTAS." class="chosen-select-deselect" id="selPesquisaPlanoConta" style="width: 250px;" >
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros = array();
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
                        <label for="selPesquisaStatus">Status</label>                                
                            <select data-placeholder="FILTRO POR PAGAMENTOS." class="chosen-select-deselect" id="selPesquisaStatus"  style="width: 100px;" >
                                <option value="A">ABERTO</option>
                                <option value="P">PAGO</option>                                
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataInicial">Data Inicial</label>
                        <input type="text" id="txtPesquisaDataInicial" placeholder="__/__/____" class="campoData" value="<?php echo date("01/m/Y"); ?>"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataFinal">Data Final</label>
                        <input type="text" id="txtPesquisaDataFinal" placeholder="__/__/____" class="campoData" value="<?php echo date("d/m/Y"); ?>"/>
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
                <div id="dialog-sucesso-pagamento" title="Sucesso Pagamento"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
                
                <!-- Janelas -->
                <div id="dialog-excluir" title="Exclusão">
                    <p id="dialogMensagemExcluir"></p>
                </div>
                <div id="dialog-imegem-conta" title="Conta">
                    <img src="" width="180px" height="140px" id="imgConta"/>
                </div>
                
                <div id="dialog-parcelas" title="Gera&ccedil;&atilde;o de Parcelas">
                    <form>
                        <fieldset class="coluna">
                            <label>Data Inicial*</label>
                            <input type="text" class="campoData" id="txtDataInicioParcela" placeholder="__/__/____"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label>N&ordm; Inicial do Documento</label>
                            <input type="text" class="campoData" id="txtNumeroInicialDocumentoParcela"/>
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialog-baixa" title="Baixa de Parcelas"></div>
                
                <div id="dialog-pagamento" title="Pagamento/Recebimento da Parcela" style="padding: 10px;">
                    <form id="formPagamentoParcela" enctype="multipart/form-data" action="<?php echo $strDir; ?>/controladores/ContaPagarReceberControlador.php" method="POST">
                        <input type="hidden" id="hddParcelaID"/>
                        <input type="hidden" id="hddFotoparcela" name="PCL_Arquivo"/>
                        <fieldset class="linha">
                            <fieldset class="linha" style="font-weight: bold;">
                                Valor da Parcela: R$ <span id="spnValorParcela"></span>
                                <input type="hidden" id="hddValorParcela"/>
                            </fieldset>
                        </fieldset>    
                        <hr/>
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <label>Juros (R$)</label>
                                <input type="text" id="txtJurosParcela" class="campoValor" value="0,00" onkeyup="calcularValorPago();" onblur="calcularValorPago();"/>
                            </fieldset>
                            
                            <fieldset class="coluna">
                                <label>Mora(R$)</label>
                                <input type="text" id="txtMoraParcela" class="campoValor" value="0,00" onkeyup="calcularValorPago();" onblur="calcularValorPago();"/>
                            </fieldset>
                            
                            <fieldset class="coluna">
                                <label>Multa(R$)</label>
                                <input type="text" id="txtMultaParcela" class="campoValor" value="0,00" onkeyup="calcularValorPago();" onblur="calcularValorPago();"/>
                            </fieldset>
                            
                            <fieldset class="coluna">
                                <label>Desconto(-)(R$)</label>
                                <input type="text" id="txtDescontoParcela" class="campoValor" value="0,00" onkeyup="calcularValorPago();" onblur="calcularValorPago();"/>
                            </fieldset>
                            
                            <fieldset class="coluna">
                                <label>Total <span id="spnTotalPago">Pago</span>(R$)</label>
                                <input type="text" id="txtTotalPagoParcela" class="campoValor" value="0,00" readonly/>
                            </fieldset>
                        </fieldset>
                        <hr/>
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <label>Data Vencimento*</label>
                                <input type="text" id="txtDataVencimentoParcela" class="campoData campoDataParcela" placeholder="__/__/____" disabled/>
                            </fieldset>

                            <fieldset class="coluna">
                                <?php
                                    echo ReferenciaSelectComponente::getInstance()->gerar("selReferenciaParcela", "PCL_Referencia", "Refer&ecirc;ncia*");
                                ?>
                            </fieldset>
                            
                            <fieldset class="coluna">
                                <div class="side-by-side clearfix">
                                    <label for="selFormaPagamentoParcela">Forma de <span id="spnFormaPagamento">Pagamento</span>*</label>                                
                                    <select data-placeholder="SELECIONE A FORMA DE PAGAMENTO." style="width:215px;" class="chosen-select-deselect" id="selFormaPagamentoParcela"  name="FPG_ID" onchange="gerenciarExigeNumeroFormaPagamento(false);">
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
                            
                            <fieldset class="coluna" id="fieldsetNumeroDocumento">
                                <label>Número do Doc.</label>
                                <input type="text" id="txtFormaPagamentoNumero" name="PCL_FormaPagamentoNumero" class="campoTextoPadrao" style="width: 100px;"/>
                            </fieldset>
                            
                            <fieldset class="coluna">
                                <label>Data <span id="spnDataPagamento">Pagamento</span>*</label>
                                <input type="text" id="txtDataPagamentoParcela" class="campoData campoDataParcela" placeholder="__/__/____"/>
                            </fieldset>
                            
                            <fieldset class="linha">
                                <div class="side-by-side clearfix">
                                    <label for="selContaBancaria" id="labDescricaoContaBancaria">Conta a Debitar*</label>                                
                                    <select data-placeholder="SELECIONE A CONTA." class="chosen-select-deselect" id="selContaBancaria" style="width: 490px;" >
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
                            
                            <fieldset class="linha">
                                <div id="div-foto" style="width: 330px; height: 300px; ">
                                    <table cellpadding='5'>
                                        <tr>
                                            <td colspan="2" >Anexar:<br>
                                                <input type="radio" name="tipoAnexoParcela" id="rbTipAnexoFotoParcela" value="foto" checked >Foto 
                                                <input type="radio" name="tipoAnexoParcela" id="rbTipAnexoAquivoParcela" value="arquivo"  >Arquivo
                                            </td>
                                        </tr>
                                        <tr>                     
                                            <td id="colunaFoto">                                    
                                                <a href="../../../modulos/sistema/home/img/contas.png" data-lightbox="imagem1" id="lightboxFotoParcela">
                                                    <img src='../../../modulos/sistema/home/img/contas.png' id="imgFotoParcela" width='156px' height='156px'/>
                                                </a>
                                                <br/>
                                                <input type="button" class="botao" value="Capturar Imagem" onclick="janelaFotoParcela();"/>
                                                <br/>
                                                <input type="button" class="botao" value="Remover Imagem" onclick="removerFotoParcela();"/>
                                            </td>
                                            <td id="colunaArquivo">
                                                <br><br>
                                                Arquivo: <br>
                                                <input type="file" name="anexoParcela" id="anexoConta"><br><br>                                                
                                            </td>
                                        </tr>    
                                        
                                    </table>
                                </div>
                            </fieldset>
                            
                        </fieldset>
                    </form>
                </div>
                
                <div id="dialogFoto1" title="Imagem da conta">
                    <div id="dialogFoto1Camera" style="width: 754px; height:400px;"></div>
                </div>
                <div id="dialogFotoParcela" title="Imagem da parcela">
                    <div id="dialogFotoParcelaCamera" style="width: 754px; height:400px;"></div>
                </div>
                
                
                <!-- Janelas (FIM) -->                
                
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
            <form id="frmCadastro" enctype="multipart/form-data" action="<?php echo $strDir; ?>/controladores/ContaPagarReceberControlador.php" method="POST">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="CON_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                <input type="hidden" id="hddFoto1" name="CON_Foto1"/>
                <input type="hidden" id="hddAnexoConta" name="anexoContaEdicao" value=""/>
                
                <fieldset class="coluna" style="float: right; width: 338px; height: 300px; margin-top: 40px; margin-right: 8px;">
                    <div id="div-foto" style="width: 330px; height: 300px; margin: auto;">
                        <table cellpadding='5'>
                            <tr>
                                <td>Anexar:<br>
                                    <input type="radio" id="rbTipAnexoFoto" name="tipoAnexo" value="foto" checked >Foto 
                                    <input type="radio" name="tipoAnexo" value="arquivo" id="rbTipAnexoAquivo" >Arquivo
                                </td>
                            </tr>                            
                            <tr id="linhaFoto">
                                <td>                                    
                                    <a href="../../../modulos/sistema/home/img/contas.png" data-lightbox="imagem1" id="lightboxFoto1"><img src='../../../modulos/sistema/home/img/contas.png' id="imgFoto1" width='156px' height='156px'/></a>
                                    <br/>
                                    <input type="button" class="botao" value="Capturar Imagem 1" onclick="janelaFoto1();"/>
                                    <br/>
                                    <input type="button" class="botao" value="Remover Imagem 1" onclick="removerFoto1();"/>
                                </td>
                            </tr>                            
                            <tr id="linhaArquivo">
                                <td>                                    
                                    Arquivo: <br>
                                    <input type="file" name="anexoConta" id="anexoConta"><br><br>
                                    <div id="arquivoExistente">
                                        
                                            <a id="caminhoArquivo" style="cursor: pointer;" title="Download do anexo aqui." href="" target="_blank">
                                                
                                            </a>&nbsp;&nbsp;                                            
                                            <strong onclick="excluirAnexo();" title="Excluir Anexo" style="cursor: pointer; color: red; " style="">Excluir anexo</strong>
                                            
                                        
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </fieldset> 
                
                <fieldset class="coluna">
                    <fieldset class="linha">                    
                        <div class="side-by-side clearfix">
                            <label for="selTipo">Tipo*</label>
                            <select id="selTipo" name="CON_Tipo" class="chosen-select-deselect" style="width: 180px;" onchange="gerenciarTipo(); getPlanoContasDinamico();">
                                <option value="P">CONTAS A PAGAR</option>
                                <option value="R">CONTAS A RECEBER</option>
                            </select>
                        </div>
                    </fieldset>

                    <fieldset class="linha">
                        <fieldset class="coluna">                         
                            <label for="txtValor">Valor Total(R$)*</label>
                            <input type="text" id="txtValor" name="CON_Valor" class="campoTextoPadrao" value="0,00" style="width: 80px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtNumero">N&ordm; do Documento</label>
                            <input type="text" id="txtNumero" name="CON_Numero" class="campoTextoPadrao" style="width: 100px;" placeholder=""/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtDescricao">Hist&oacute;rico*</label>
                            <input type="text" id="txtDescricao" name="CON_Descricao" class="campoTextoPadrao" style="width: 400px;" placeholder=""/>
                        </fieldset>        
                    </fieldset>

                    <fieldset class="linha">
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selPlanoConta">Plano de Contas* <a href="javascript: void(0);" onclick="janelaAdicionarPlanoConta();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>
                                <select id="selPlanoConta" name="PLA_ID" class="chosen-select-deselect" style="width: 322px;">
                                    <option value=""></option>
                                    <?php
                                       $arrStrFiltros = array();                                
                                       $arrStrFiltros["PLA_Tipo"] = "A";
                                       $arrStrFiltros["PLA_Movimentacao"] = "S";
                                        $arrStrFiltros["PLA_Status"] = "A";
                                        $arrObjs = FachadaFinanceiro::getInstance()->consultarPlanoConta($arrStrFiltros);
                                        $arrObjs = $arrObjs["objects"];

                                        if($arrObjs != null){
                                            if(count($arrObjs) > 0){
                                                $strHtml = "";

                                                for($intI=0; $intI<count($arrObjs); $intI++){
                                                    $strHtml .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                                }

                                                echo $strHtml;
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selCentroCusto">Centro de Custo* <a href="javascript: void(0);" onclick="janelaAdicionarCentroCusto();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>
                                <select id="selCentroCusto" name="CEN_ID" class="chosen-select-deselect" style="width: 322px;">
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros = array();                                
                                        $arrStrFiltros["CEN_Status"] = "A";
                                        $arrObjs = FachadaFinanceiro::getInstance()->consultarCentroCusto($arrStrFiltros);
                                        $arrObjs = $arrObjs["objects"];

                                        if($arrObjs != null){
                                            if(count($arrObjs) > 0){
                                                $strHtml = "";

                                                for($intI=0; $intI<count($arrObjs); $intI++){
                                                    $strHtml .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                                }

                                                echo $strHtml;
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </fieldset>
                    </fieldset>

                    <fieldset class="linha">
                        <fieldset class="coluna" id="colunaAPagar">
                            <div class="side-by-side clearfix">
                                <label for="selFornecedor">Fornecedor* <a href="javascript: void(0);" onclick="janelaAdicionarFornecedor();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>
                                <select id="selFornecedor" data-placeholder="SELECIONE O FORNECEDOR." name="FOR_ID" class="chosen-select-deselect" style="width: 322px;">
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros = array();                                
                                        $arrStrFiltros["FOR_Status"] = "A";
                                        $arrObjs = FachadaFinanceiro::getInstance()->consultarFornecedor($arrStrFiltros);
                                        $arrObjs = $arrObjs["objects"];

                                        if($arrObjs != null){
                                            if(count($arrObjs) > 0){
                                                $strHtml = "";

                                                for($intI=0; $intI<count($arrObjs); $intI++){
                                                    $strHtml .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNomeFantasia().'</option>';
                                                }

                                                echo $strHtml;
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="coluna" id="colunaAReceber">
                            <div class="side-by-side clearfix">
                                <label><input id="rdbOrigemPessoa" type="radio"  name="CON_TipoOrigem" value="P" checked onclick="gerenciarTipoOrigemContaAReceber();"/>Membro/Funcion&aacute;rio<input value="F" id="rdbOrigemFornecedor" type="radio" name="CON_TipoOrigem" onclick="gerenciarTipoOrigemContaAReceber();"/>Fornecedor</label>                                
                                <fieldset class="coluna" id="colunaOrigemPessoa">
                                    <select data-placeholder="SELECIONE O MEMBRO/FUNCION&Aacute;RIO." class="chosen-select-deselect" id="selOrigemPessoa" name="PES_ID" style="width: 322px;" >
                                        <option value=""></option>                                    
                                        <?php
                                            /*$arrStrFiltros["PES_Status"] = "A";
                                            $arrObjs  = FachadaGerencial::getInstance()->consultarPessoa($arrStrFiltros);
                                            if($arrObjs != null){                                                                                
                                                for($intI=0; $intI<count($arrObjs); $intI++){
                                                   echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNome().'</option>';
                                                }
                                            }*/
                                        ?> 
                                    </select>
                                    <a href="javascript: void(0);" onclick="janelaAdicionarPessoa();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a>
                                </fieldset>
                                <fieldset class="coluna" id="colunaOrigemFornecedor">
                                    <select data-placeholder="SELECIONE O FORNECEDOR." class="chosen-select-deselect" id="selOrigemFornecedor" name="FOR_Origem_ID" style="width: 322px;" >
                                        <option value=""></option>                                    
                                        <?php
                                            /*$arrStrFiltros["FOR_Status"] = "A";
                                            $arrObjs  = FachadaFinanceiro::getInstance()->consultarFornecedor($arrStrFiltros);
                                            if($arrObjs != null){
                                                $arrObjs = $arrObjs["objects"];                                                
                                                for($intI=0; $intI<count($arrObjs); $intI++){
                                                   echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNomeFantasia().'</option>';
                                                }
                                            }*/
                                        ?> 
                                    </select>
                                    <a href="javascript: void(0);" onclick="janelaAdicionarFornecedor();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a>
                                </fieldset>
                            </div>
                        </fieldset>
                    </fieldset>

                    <fieldset class="linha">
                        <fieldset class="linha">
                            <label for="txtObservacao">Anota&ccedil;&otilde;es</label>
                            <textarea id="txtObservacao" name="CON_Observacao" class="campoTextoPadrao" rows="5" style="width: 628px;"></textarea>
                        </fieldset>
                    </fieldset>

                    <fieldset class="linha" style="border: 1px solid #F4F4F4; width: 636px; padding: 5px;"> 
                        <legend>Parcelas</legend>
                        <fieldset class="coluna">                    
                            <label>N&ordm; de Parcelas*</label>
                            <input type="text" id="txtQuantidadeParcelas" name="CON_NumeroParcelas" class="campoTextoPadrao" value="1" style="width: 80px;"/>
                        </fieldset>
                        <fieldset class="coluna">                    
                            <input type="button" class="botao" value="Gerar Parcela(s)" onclick="abrirGeracaoParcelas();"/>
                        </fieldset>

                        <div id="lista-pacelas" style="margin-top: 10px;"></div>
                    </fieldset>

                    <fieldset class="linha" style="margin-top: 20px;">
                        <input type="button" value="Salvar" onclick="salvar();" class="botao" id="btnSalvar"/><input type="button" value="Cancelar" onclick="cancelar();" class="botao"/>
                    </fieldset> 
                </fieldset>
            </form>            
        </div>      
    </div>    
    <script type="text/javascript">        
        init();
    </script>
</body>
</html>