<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    $strDir = "../../livroRegistro/livro-auxiliar";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmLinhaAuxiliar.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Linhas Auxiliares Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">
                    
                    
                    <fieldset class="coluna" >                    
                        <label for="selLivroPesquisa">Livro</label>
                        <div class="side-by-side clearfix">                                                            
                            <select data-placeholder="SELECIONE O LIVRO" style="width:200px;" class="chosen-select-deselect"  id="selLivroPesquisa"  onchange="preencheFolhaPesquisa();">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros[""] = null;                                    
                                    $arrObjs = FachadaLivroAuxiliar::getInstance()->consultarLivroAuxiliar($arrStrFiltros);

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
                    
                    <fieldset class="coluna" >                    
                        <label for="selFolhaPesquisa">Folha</label>
                        <div class="side-by-side clearfix">                                                            
                        <select data-placeholder="SELECIONE A LINHA" style="width:200px;" class="chosen-select-deselect"  id="selFolhaPesquisa"  >
                            <option value=""></option>
                        </select>
                        </div>
                    </fieldset>
                    
                    
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Descri&ccedil;&atilde;o</label>
                        <input type="text" id="txtPesquisaDescricao" name="txtPesquisa" class="campoTextoPadrao" style="width: 300px" placeholder="DIGITE A DESCRIÇÃO" />
                    </fieldset>
                    
                    <fieldset class="coluna"> 
                        <label for="selTipoPesquisa">Tipo</label>
                        <select id="selTipoPesquisa" class="campoSelect" name="TIL_Tipo">
                            <option value="">TODAS</option>
                            <option value="D">DESPESA</option>
                            <option value="R">RECEITA</option>
                        </select>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <label for="txtPesquisaProtocolo">Protocolo</label>
                        <input type="text" id="txtPesquisaProtocolo" name="txtProtocolo" class="campoTextoPadrao" style="width: 200px" placeholder="DIGITE O PROTOCOLO" />
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <label for="txtPesquisaGuia">Nº da guia</label>
                        <input type="text" id="txtPesquisaGuia" name="txtGuia" class="campoTextoPadrao" style="width: 150px" placeholder="DIGITE A GUIA" />
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
                <div id="dialog-excluir" title="Exclusão">
                    <p id="dialogMensagemExcluir"></p>
                </div>
            </div><!-- dialogs -->
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" name="frmFormulario" action="<?php echo $strDir;?>/controladores/LinhaAuxiliarControlador.php" method="POST">
                <input type="hidden" id="hddAcao" name="ACO_Descricao" value="Salvar"/>
                <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="LAU_ID"/>                
                <input type="hidden" id="hddFolhaEditar" name="FAU_ID"/>                
                <input type="hidden" id="hddFocus"/>  
                
                <fieldset class="linha" id="fildSelectLivro">                    
                    <label for="selLivro">Livro</label>
                    <div class="side-by-side clearfix">                                                            
                        <select data-placeholder="SELECIONE O LIVRO" style="width:365px;" class="chosen-select-deselect"  id="selLivro"  name="LIA_ID" onchange="preencheFolha();">
                            <option value=""></option>
                            <?php
                                $arrStrFiltros[""] = null;                                    
                                $arrObjs = FachadaLivroAuxiliar::getInstance()->consultarLivroAuxiliar($arrStrFiltros);

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
                
                <fieldset class="linha" id="fildSelectLinha">                    
                    <label for="selFolha">Folha</label>
                    <div class="side-by-side clearfix">                                                            
                    <select data-placeholder="SELECIONE A FOLHA" style="width:365px;" class="chosen-select-deselect"  id="selFolha"  name="FAU_ID">
                        <option value=""></option>
                    </select>
                    </div>
                </fieldset>
                
                
                <fieldset class="linha">
                    
                        
                        <fieldset class="linha">
                            <input type="radio" id="ckbTipoReceita" class="TipoTipoLinha" name ="TipoTipoLinha" value="R" onclick="preencheTipoLinha();" />Receita&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="ckbTipoDespesa" class="TipoTipoLinha" name ="TipoTipoLinha" value="D" onclick="preencheTipoLinha();"  />Despesa&nbsp;&nbsp;&nbsp;&nbsp;
                        </fieldset>

                        <fieldset class="linha">
                            <label for="selTipoLinha">Tipo</label>
                            <div class="side-by-side clearfix">                                                            
                            <select data-placeholder="SELECIONE O TIPO DA LINHA" style="width:365px;" class="chosen-select-deselect"  id="selTipoLinha"  name="TIL_ID">
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros["TIL_Status"] = "A";                                    
                                        $arrObjs = FachadaTipoLinhaLivro::getInstance()->consultarTipoLinhaLivro($arrStrFiltros);

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
                    <label for="txtDescricao">Descri&ccedil;&atilde;o</label>
                    <input type="text" id="txtDescricao" name="LAU_Descricao" class="campoTextoPadrao" style="width: 350px" placeholder="DESCRIÇÃO" />
                </fieldset>
                <fieldset class="linha">                    
                    <label for="txtGuia">Guia</label>
                    <input type="text" id="txtGuia" name="LAU_Guia" class="campoTextoPadrao" style="width: 350px" placeholder="GUIA" />
                </fieldset>
                <fieldset class="linha">                    
                    <label for="txtProtocoloRecepcao">Protocolo de Recepção</label>
                    <input type="text" id="txtProtocoloRecepcao" name="LAU_ProtocoloRecepcao" class="campoTextoPadrao" style="width: 350px" placeholder="PROTOCOLO DE RECEPÇÃO" />
                </fieldset>
                
                
                
                <fieldset class="linha" >                    
                    <fieldset class="coluna" >                    
                        <label for="selFolhaPesquisa">Tipo</label>
                        <div class="side-by-side clearfix">                                                            
                            <select data-placeholder="" style="width:200px;" class="chosen-select-deselect"  id="tipoPessoaLinha" onchange="mudaEditTipoPessoa();"  >
                            <option value="F">PESSOA FÍSICA</option>
                            <option value="J">PESSOA JURÍDICA</option>
                        </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna">                    
                        <label for="txtCpfCnpj" id="lbCpfCnpj">CPF</label>
                        <input type="text" id="txtCpfCnpj" name="LAU_Cpf" class="campoTextoPadrao" style="width: 120px" placeholder="000.000.000-00" />
                    </fieldset>
                </fieldset>
                
                
                <fieldset class="linha">                    
                    <fieldset class="coluna">                    
                        <label for="txtQuantidade">Quantidade</label>
                        <input type="text" id="txtQuantidade" name="LAU_Quantidade" class="campoTextoPadrao" style="width: 120px" placeholder="3" />
                    </fieldset>
                </fieldset>
                
                <fieldset class="linha">                    
                    <fieldset class="coluna">                    
                        <label for="txtData">Data</label>
                        <input type="text" id="txtData" name="LAU_Data" class="campoTextoPadrao" style="width: 120px" placeholder="__/__/____" />
                    </fieldset>
                    <fieldset class="coluna">                    
                        <label for="txtValor">Valor</label>
                        <input type="text" id="txtValor" name="LAU_Valor" class="campoTextoPadrao" style="width: 120px" placeholder="R$ 100,00" />
                    </fieldset>
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