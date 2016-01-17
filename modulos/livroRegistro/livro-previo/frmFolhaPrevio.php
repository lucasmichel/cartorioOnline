<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    $strDir = "../../livroRegistro/livro-previo";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmFolhaPrevio.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Folhas Prévias Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">
                    
                    <fieldset class="coluna">
                        <label for="selPesquisaLivro">Livro</label>
                        <div class="side-by-side clearfix">                                                            
                        <select data-placeholder="SELECIONE O LIVRO" style="width:365px;" class="chosen-select-deselect"  id="selPesquisaLivro"  name="selPesquisaLivro">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros[""] = null;                                    
                                    $arrObjs = FachadaLivroPrevio::getInstance()->consultarLivroPrevio($arrStrFiltros);

                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNumero().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div> 
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaNumeroFolha">Número da folha</label>
                        <input type="text" id="txtPesquisaNumeroFolha" name="txtPesquisaNumeroFolha" class="campoTextoPadrao" style="width: 350px" placeholder="DIGITE O NUMERO DA FOLHA" />
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaData">Data</label>
                        <input type="text" id="txtPesquisaData" name="txtPesquisaData" class="campoTextoPadrao" style="width: 120px" placeholder="__/__/____" />
                    </fieldset>
                    
                    <!--<fieldset class="coluna"> 
                        <label for="selTipoPesquisa">Tipo</label>
                        <select id="selTipoPesquisa" class="campoSelect" name="TIL_Tipo">
                            <option value="">TODAS</option>
                            <option value="D">DESPESA</option>
                            <option value="R">RECEITA</option>
                        </select>
                    </fieldset>-->
                    
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
            <form id="frmCadastro" name="frmFormulario" action="<?php echo $strDir;?>/controladores/FolhaPrevioControlador.php" method="POST">
                <input type="hidden" id="hddAcao" name="ACO_Descricao" value="Salvar"/>
                <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="FPR_ID"/>                
                <input type="hidden" id="hddFocus"/>  
                
                <fieldset class="linha">
                    <label for="selLivro">Livro</label>
                    <div class="side-by-side clearfix">                                                            
                    <select data-placeholder="SELECIONE O LIVRO" style="width:365px;" class="chosen-select-deselect"  id="selLivro"  name="LIP_ID">
                            <option value=""></option>
                            <?php
                                $arrStrFiltros[""] = null;                                    
                                $arrObjs = FachadaLivroPrevio::getInstance()->consultarLivroPrevio($arrStrFiltros);

                                if($arrObjs != null){
                                    $arrObjs = $arrObjs["objects"];                                                
                                    for($intI=0; $intI<count($arrObjs); $intI++){
                                       echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNumero().'</option>';
                                    }
                                }
                            ?> 
                        </select>
                    </div> 
                </fieldset>
                
                
                <fieldset class="linha">                    
                    <label for="txtNumeroFolha">Número da Folha</label>
                    <input type="text" id="txtNumeroFolha" name="FPR_NumeroFolha" class="campoTextoPadrao" style="width: 350px" placeholder="NUMERO DA FOLHA" />
                </fieldset>
                
                <fieldset class="coluna">                    
                    <label for="txtData">Data</label>
                    <input type="text" id="txtData" name="FPR_DataFolha" class="campoTextoPadrao" style="width: 120px" placeholder="__/__/____" />
                </fieldset>
                
                <fieldset class="linha" style="margin-top: 10px;">
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