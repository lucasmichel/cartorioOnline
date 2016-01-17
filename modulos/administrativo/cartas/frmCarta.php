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
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmCarta.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Cartas Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">                      
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selTipoCartaPesquisa">Modelo de Carta</label>                                
                            <select data-placeholder="SELECIONE O MODELO DA CARTA" style="width:200px;" class="chosen-select-deselect" id="selTipoCartaPesquisa"  name="TCA_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["TCA_Status"] = "A";
                                    $arrObjTipoCartaPesquisa  = FachadaCarta::getInstance()->consultarTipoCarta($arrStrFiltros);
                                    if($arrObjTipoCartaPesquisa != null){
                                        $arrObj = $arrObjTipoCartaPesquisa["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getDescricao()).'</option>';
                                        }
                                    }else{
                                        echo '<option value="">NENHUM TIPO DE CARTA CADASTRADO</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset> 
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPessoaCartaPesquisa">Selecione o membro</label>
                            <select data-placeholder="SELECIONE O MEMBRO" style="width:200px;" class="chosen-select-deselect" id="selPessoaCartaPesquisa" >
                                <option value=""></option>
                                <?php                                    
                                    $arrObjMembro = FachadaCadastro::getInstance()->consultarMembro(null);
                                    if($arrObjMembro != null){
                                        $arrObj = $arrObjMembro["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                            $membro = new Membro();
                                            $membro = $arrObj[$intI];
                                           echo '<option value="'. $membro->getId().'">'.$membro->getNome().'</option>';
                                        }
                                    }else{
                                        echo '<option value="">NENHUM MEMBRO CADASTRADO</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataInicial">Data Inicial</label>
                        <input type="text" id="txtPesquisaDataInicial" name="EMP_DataInicial" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisaDataInicial();?>" class="campoData" value="<?php echo date("01/m/Y"); ?>"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataFinal">Data Final</label>
                        <input type="text" id="txtPesquisaDataFinal" name="EMP_DataFinal" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisaDataFinal();?>" class="campoData" value="<?php echo date("d/m/Y"); ?>"/>                        
                    </fieldset>
                    
                    
                    
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>
                    </fieldset>
                </form>
            </div>
            <!--<fieldset style="margin-top: 5px; margin-bottom: 5px; padding: 0px; border: 0px;">
                <input type="checkbox" style="margin-left: 0px; " id="ckbSelecionarTodos" onclick="selecionarTodos();"/>Selecionar todos
            </fieldset>-->
            <div id="grid" style="margin-top: 20px;"></div>
        </div>
        <div id="tabs-2">
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
                <div id="dialog-excluir" title="Excluir">
                    <input type="hidden" id="hddIDExcluir" />
                    <p id="dialog-excluir-msg"></p>
                </div>
            </div><!-- dialogs -->            
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/CartaControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="CAR_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <input type="hidden" id="hddTexto" name="CAR_Texto"/>
                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selTipoCarta">Modelo de Carta*</label>
                            <select data-placeholder="SELECIONE O MODELO DA CARTA" style="width:280px;" class="chosen-select-deselect" id="selTipoCarta"  name="TCA_ID" onchange="preencherTextoComTipoDeCarta();">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["TCA_Status"] = "A";
                                    $arrObjTipoCarta = FachadaCarta::getInstance()->consultarTipoCarta($arrStrFiltros);
                                    if($arrObjTipoCarta != null){
                                        $arrObj = $arrObjTipoCarta["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                        }
                                    }else{
                                        echo '<option value="">NENHUM MODELO DE CARTA CADASTRADO</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selPessoa">Selecione o membro*</label>
                            <select data-placeholder="SELECIONE O MEMBRO" style="width:280px;" class="chosen-select-deselect" id="selPessoa"  name="PES_ID" onchange="preencherTextoComNomePessoa();" >
                                <option value=""></option>
                                <?php
                                    
                                    $arrObjMembro = FachadaCadastro::getInstance()->consultarMembro(null);
                                    if($arrObjMembro != null){
                                        $arrObj = $arrObjMembro["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                            $membro = new Membro();
                                            $membro = $arrObj[$intI];
                                           echo '<option value="'. $membro->getId().'">'.$membro->getNome().'</option>';
                                        }
                                    }else{
                                        echo '<option value="">NENHUM MEMBRO CADASTRADO</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                </fieldset>
                
                
                
                <fieldset class="linha">
                    <label for="selTipoCarta">Texto da Carta*</label>
                    <textarea id="txtConteudo" style="width:100%; height: 500px;"></textarea>
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
        tinymce.get("editor").setContent('');
    </script>
</body>
</html>