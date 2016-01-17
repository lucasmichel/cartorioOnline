<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/cadastro";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmMinisterio.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Minist&eacute;rios Cadastrados</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">  
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Minist&eacute;rio</label>
                        <input type="text" id="txtPesquisaDescricao" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa();?>" class="campoTextoPadrao" style="width: 250px;"/>
                    </fieldset>                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPesquisaAreaMinisterial">Área Ministerial</label>                                
                            <select data-placeholder="ÁREA MINISTERIAL" style="width:250px;" class="chosen-select-deselect" id="selPesquisaAreaMinisterial" name="AMI_ID">                                
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["AMI_Status"] = "A";
                                    $arrObjFaixa  = FachadaCadastro::getInstance()->consultarAreaMinisterial($arrStrFiltros);
                                    if($arrObjFaixa != null){
                                        $arrObj = $arrObjFaixa["objects"];
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
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
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/MinisterioControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="MIN_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="txtDescricao">Nome do Minist&eacute;rio*</label>
                        <input type="text" id="txtDescricao" name="MIN_Descricao" class="campoTextoPadrao" style="width: 350px;" placeholder="EX.: PASTORAL" />
                    </fieldset>
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selAreaMinisterial">Área Ministerial</label>                                
                            <select data-placeholder="ÁREA MINISTERIAL" style="width:250px;" class="chosen-select-deselect" id="selAreaMinisterial" name="AMI_ID">                                
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["AMI_Status"] = "A";
                                    $arrObjFaixa  = FachadaCadastro::getInstance()->consultarAreaMinisterial($arrStrFiltros);
                                    if($arrObjFaixa != null){
                                        $arrObj = $arrObjFaixa["objects"];
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </fieldset>
                </fieldset>
                <fieldset style="margin-top: 10px;">
                    <legend>Dias/Hor&aacute;rios de Reuni&atilde;o</legend>
                    <?php
                        $arrStrFiltros = array();
                        $arrStrFiltros["DIA_Status"] = "A";
                        $arrObjs = FachadaGerencial::getInstance()->consultarDiasSemana($arrStrFiltros);                         
                        $arrObjs = $arrObjs["objects"];
                        $strHtml = '<table>';
                        
                        if(count($arrObjs) > 0){
                            if($arrObjs != null){
                                $strHtml .= '<tr>';

                                for($intI=0; $intI<count($arrObjs); $intI++){                                
                                    $strHtml .= '<td>';
                                        $strHtml .= '<input type="checkbox" class="dia" id="ckbDiaSemana_'.$arrObjs[$intI]->getId().'" name="DIA_ID[]" value="'.$arrObjs[$intI]->getId().'" onclick="habilitarDesabilitarHorarioDia('.$arrObjs[$intI]->getId().');"/> '.$arrObjs[$intI]->getDescricao();
                                    $strHtml .= '</td>';
                                    $strHtml .= '<td>';
                                        $strHtml .= '<input type="text" id="txtHorario_'.$arrObjs[$intI]->getId().'" name="MDR_Horario[]" class="campoTextoPadrao horario" style="width: 40px;" placeholder="__:__" value="00:00"/> ';
                                    $strHtml .= '</td>';
                                }
                                $strHtml .= '</tr>';
                            }
                        }else{
                            $strHtml .= '<tr>';
                                $strHtml .= '<td align="center">';
                                    $strHtml .= 'NENHUM DIA DA SEMANA CADASTRADO!!!';
                                $strHtml .= '</td>';
                            $strHtml .= '</tr>';
                        }
                        $strHtml .= '</table>';                        
                        echo $strHtml;
                    ?>
                </fieldset>                
                <div id="tabsEndereco" style="margin-top: 20px;">
                    <ul>
                        <li><a href="#tabs-1">Endere&ccedil;o (Complemento)</a></li>                        
                    </ul>
                    <div id="tabsEndereco-1" style="padding-left: 5px;">
                        <!--<fieldset class="linha">
                            <input type="checkbox" id="ckbEnderecoIgreja" style="margin-left: 0px;" value="S"/>Reuni&atilde;o realizada na pr&oacute;pria igreja.
                        </fieldset>-->
                        <fieldset class="linha" style="margin-top: 20px;">
                            <label for="txtEnderecoCep">CEP</label>
                            <input type="text" id="txtEnderecoCep" name="MIN_EnderecoCep" class="campoTextoPadrao" style="width: 100px;" placeholder="EX.: 55000-000"/>
                            <a href="javascript: void();" onclick="consultarEndereco();">
                                <img src="../../../modulos/sistema/home/img/botao-pesquisar.png" border="0" align="absmiddle"/>
                            </a>
                        <span id="spnCarregandoCep"></span>
                        </fieldset>
                    <fieldset class="coluna">
                        <label for="txtEnderecoLogradouro">Logradouro</label>
                        <input type="text" id="txtEnderecoLogradouro" name="MIN_EnderecoLogradouro" class="campoTextoPadrao"  style="width: 300px;"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtEnderecoNumero">N&uacute;mero</label>
                        <input type="text" id="txtEnderecoNumero" name="MIN_EnderecoNumero" class="campoTextoPadrao" style="width: 100px;"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtEnderecoComplemento">Complemento</label>
                        <input type="text" id="txtEnderecoComplemento" name="MIN_EnderecoComplemento" class="campoTextoPadrao" style="width: 300px;"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtEnderecoPontoReferencia">Ponto de refer&ecirc;ncia</label>
                        <input type="text" id="txtEnderecoPontoReferencia" name="MIN_EnderecoPontoReferencia" class="campoTextoPadrao" style="width: 300px;"/>
                    </fieldset>                            
                    <fieldset class="coluna">
                        <label for="txtEnderecoBairro">Bairro</label>
                        <input type="text" id="txtEnderecoBairro" name="MIN_EnderecoBairro" class="campoTextoPadrao" style="width: 300px;"/>
                    </fieldset>
                    <fieldset class="linha">
                        <fieldset class="coluna">
                            <label for="txtEnderecoCidade">Cidade</label>
                            <input type="text" id="txtEnderecoCidade" name="MIN_EnderecoCidade" class="campoTextoPadrao" style="width: 300px;"/>
                        </fieldset>
                        <fieldset class="coluna" >
                            <label>UF</label>
                            <?php
                                echo UFSelectComponente::getInstance()->gerarSigla("selEnderecoUf", "MIN_EnderecoUf", true);
                            ?>
                        </fieldset>
                    </div>
                </div>
                <fieldset style="margin-top: 10px;">
                    <legend>Anota&ccedil;&otilde;es</legend>
                    <textarea id="txtObservacao" name="MIN_Observacao" rows="5" style="width: 500px;" class="campoTextoPadrao" placeholder="ESPA&Ccedil;O RESERVADO PARA ANOTA&Ccedil;&Otilde;ES/DESCRI&Ccedil;&Atilde;O SOBRE O MINIST&Eacute;RIO."></textarea>
                </fieldset>
                <fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" name="MIN_Status" />Inativo<br />
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