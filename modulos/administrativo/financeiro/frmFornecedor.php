<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/financeiro";     
    
    if(isset($_SESSION["DADOS_FORNECEDOR"])){
        unset($_SESSION["DADOS_FORNECEDOR"]);
    }    
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmFornecedor.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Fornecedores Cadastrados</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">  
                    <fieldset class="coluna">
                        <label for="selPesquisaFiltro">Filtro</label>
                        <select id="selPesquisaFiltro" class="campoSelect">
                            <option value="NOME">NOME/NOME FANTASIA</option>
                            <option value="CPF">CPF</option>
                            <option value="CNPJ">CNPJ</option>  
                        </select>                    
                    </fieldset>                    
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao"></label>
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
                <div id="dialog-excluir" title="Exce&ccedil;&atilde;o">
                    <input type="hidden" id="hddIDExcluir" />
                    <p>
                        Tem certeza que deseja remover?
                    </p>
                </div>
                <div id="dialog-editar-email" title="Editar E-mail">
                    <form id="frmNivelEscolaridade" onsubmit="return false;" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="SalvarEditarEmail"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddIDEmail" name="ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="linha">
                            <label for="txtEmailEdicao">E-mail</label>
                            <input type="text" id="txtEmailEdicao" name="EMA_Email" class="campoTextoPadrao" style="width: 250px;" placeholder="EX.: JOAODASILVA@IGREJACONECTADA.COM" />
                        </fieldset>                        
                    </form>
                </div>
                
                <div id="dialog-editar-fone" title="Editar Telefone">
                    <form id="frmNivelEscolaridade" onsubmit="return false;" method="POST">
                        <input type="hidden" name="ACO_Descricao" value="SalvarEditarFone"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" id="hddIDFone" name="ID"/><!-- PK do registro, utilizado no ALTERAR -->
                        <fieldset class="coluna">
                            <label for="txtFoneEdicao">Telefone</label>
                            <input type="text" id="txtFoneEdicao" name="TEL_Telefone" class="campoTextoPadrao" style="width: 95px;" placeholder="(__) ____.____" />
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="selOperadoraEdicao">Operadora</label>
                            <?php echo OperadorasTelefoniaSelectComponente::getInstance()->gerar("selOperadoraEdicao", "TEL_Operadora")?>
                        </fieldset>                                
                        <fieldset class="coluna">
                            <label for="txtResponsavelEdicao">Nome do Contato</label>
                            <input type="text" id="txtResponsavelEdicao" name="TEL_Responsavel" class="campoTextoPadrao" style="width: 160px;" placeholder="EX.: JOS&Eacute; DA SILVA" />
                        </fieldset>
                    </form>
                </div>
            </div><!-- dialogs -->
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/FornecedorControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="FOR_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <div id="tabs-dados" style="margin-top: 10px;">
                    <ul>
                        <li><a href="#tabs-fornecedor">Dados B&aacute;sicos</a></li>
                        <li><a href="#tabs-endereco">Endere&ccedil;o</a></li>  
                        <li><a href="#tabs-contato">Contato</a></li>  
                        <li><a href="#tabs-outros-dados">Outros Dados</a></li>
                    </ul> 
                   
                    <div id="tabs-fornecedor">
                        
                        <fieldset class="linha" style="margin-bottom: 20px;">
                            <fieldset class="linha" >
                                <input type="checkbox" id="ckbMembro" value="I" onclick="exibirMembro();"/>Este fornecedor é um membro?
                            </fieldset>

                            <fieldset class="linha" id="divMembro" >
                                <div class="side-by-side clearfix">
                                    <label for="selMembro">Membro</label>                                
                                    <select data-placeholder="SELECIONE O MEMBRO." class="chosen-select-deselect" id="selMembro"  name="PES_ID" onchange="preencheDadosMembro();"  style="width: 260px;" >
                                        <option value=""></option>
                                        <?php
                                            /*$arrStrFiltros["PES_Status"] = "A";
                                            $arrStrFiltros["MembroNaoFornecedor"] = true; //pra trazer mebros que não estão relacionados com fornecedores ainda                                                
                                            $arrStrFiltros["MES_ID"] = "1";
                                            $arrObjMembro  = FachadaCadastro::getInstance()->consultarMembro($arrStrFiltros);
                                            if($arrObjMembro != null){
                                                $arrObj = $arrObjMembro["objects"];                                                
                                                for($intI=0; $intI<count($arrObj); $intI++){
                                                   echo '<option value="'. $arrObj[$intI]->getId().'">   '.utf8_encode($arrObj[$intI]->getNome()).'</option>';
                                                }
                                            }*/
                                        ?> 
                                    </select>
                                </div>
                            </fieldset>
                        </fieldset>
                        
                        
                        
                        <fieldset class="linha" style="margin-bottom: 20px;">
                            <input type="checkbox" id="ckbTipo" value="PF" name="FOR_Tipo" onclick="verificaTipoPessoa()"  />Pessoa F&iacute;sica
                        </fieldset>    
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <label id="labNomeFantasiaLabel" for="txtNomeFantasia">Nome Fantasia*</label>
                                <input type="text" id="txtNomeFantasia" name="FOR_NomeFantasia" class="campoTextoPadrao"  style="width: 250px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label id="labRazaoSocial" for="txtRazaoSocial">Raz&atilde;o Social</label>
                                <input type="text" id="txtRazaoSocial" name="FOR_RazaoSocial"  class="campoTextoPadrao"  style="width: 250px;"/>
                            </fieldset>
                        </fieldset>
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <label id="labInscricaoEstadual" for="txtInscricaoEstadual">Inscri&ccedil;&atilde;o Estadual</label>
                                <input type="text" id="txtInscricaoEstadual" name="FOR_InscricaoEstadual"  class="campoTextoPadrao"  style="width: 250px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                <label id="labCNPJ" for="txtCNPJ">CNPJ</label>
                                <input type="text" id="txtCNPJ" name="FOR_CNPJ"  class="campoTextoPadrao"  style="width: 250px;"/>
                            </fieldset>
                        </fieldset>
                        <fieldset class="linha">                            
                            <label for="txtConta">Site</label>
                            <input type="text" id="txtSite" name="FOR_Site" class="campoTextoPadrao" style="width: 250px;" />
                        </fieldset>
                        <fieldset class="linha">
                            <label for="txtObservacao">Anota&ccedil;&otilde;es</label>
                            <textarea id="txtObservacao" name="FOR_Observacao" class="campoTextoPadrao" rows="5" style="width: 525px;" ></textarea>
                        </fieldset>    
                    </div>
                    
                    
                    <div id="tabs-endereco">
                        <fieldset class="linha">
                            <label for="txtEnderecoCEP">CEP</label>
                            <input type="text" id="txtEnderecoCEP" name="FOR_EnderecoCep" class="campoTextoPadrao" style="width: 100px;" placeholder="_____-___"/>
                            <a href="javascript: void();" onclick="consultarEndereco();" id="btConsultarCep">
                                <img src="img/botao-pesquisar.png" border="0" align="absmiddle"/>
                            </a>
                            <span id="spnCarregandoCEP"></span>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoLogradouro">Logradouro</label>
                            <input type="text" id="txtEnderecoLogradouro" name="FOR_EnderecoLogradouro" placeholder="" class="campoTextoPadrao"  style="width: 300px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoNumero">N&uacute;mero</label>
                            <input type="text" id="txtEnderecoNumero" name="FOR_EnderecoNumero" placeholder="" class="campoTextoPadrao" style="width: 80px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoComplemento">Complemento</label>
                            <input type="text" id="txtEnderecoComplemento" name="FOR_EnderecoComplemento" class="campoTextoPadrao" style="width: 197px;"/>
                        </fieldset>    
                        <fieldset class="coluna">
                            <label for="txtDescricao">Ponto de refer&ecirc;ncia</label>
                            <input type="text" id="txtEnderecoPontoReferencia" name="FOR_EnderecoPontoReferencia"  placeholder="" class="campoTextoPadrao" style="width: 300px" />
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoBairro">Bairro</label>
                            <input type="text" id="txtEnderecoBairro" name="FOR_EnderecoBairro" placeholder="" class="campoTextoPadrao" style="width: 300px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoCidade">Cidade</label>
                            <input type="text" id="txtEnderecoCidade" name="FOR_EnderecoCidade"  placeholder="" class="campoTextoPadrao" style="width: 300px;"/>
                        </fieldset>
                        <fieldset class="coluna" >
                            <label for="selEnderecoUF">Uf</label>
                            <?php
                                echo UFSelectComponente::getInstance()->gerarSigla("selEnderecoUF", "FOR_EnderecoUf", true);
                            ?>
                        </fieldset> 
                    </div>
                    
                    <div id="tabs-contato">
                        <fieldset class="linha" >
                            <fieldset>
                            <legend>Contatos</legend>
                                <fieldset class="coluna" style="float: left; width: 49%; height: 100%">
                                    <fieldset class="coluna">
                                        <label for="txtFone">Telefone</label>
                                        <input type="text" id="txtFone" name="TEL_Telefone" class="campoTextoPadrao" style="width: 95px;" placeholder="(__) ____.____" />
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="selOperadora">Operadora</label>
                                        <?php echo OperadorasTelefoniaSelectComponente::getInstance()->gerar("selOperadora", "TEL_Operadora")?>
                                    </fieldset>                                
                                    <fieldset class="coluna">
                                        <label for="txtResponsavel">Nome do Contato</label>
                                        <input type="text" id="txtResponsavel" name="TEL_Responsavel" class="campoTextoPadrao" style="width: 160px;" placeholder="EX.: JOS&Eacute; DA SILVA" />
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <input type="button" value="Adicionar" onclick="adicionarFone();" class="botao" id="btnAddFone" title="Adicionar telefone"/>
                                    </fieldset>
                                    <fieldset class="linha" style="margin-top: 10px;">                                                            
                                        <fieldset class="linha" style="height: 150px;">
                                            <div id="div-fones" style="width: 100%; height: 100%; overflow: auto;">Nenhum telefone adicionado.</div>
                                        </fieldset>
                                    </fieldset>
                                </fieldset>
                                <fieldset class="coluna" style="float: left; width: 2%; height: 100% ">
                                    <hr size="238" width="1" align="left" style="color: #f4f4f4; background-color: #f4f4f4; ">                            
                                </fieldset>
                                <fieldset class="coluna" style="float: left; width: 49%; height: 100%">
                                    <fieldset class="coluna">
                                        <label for="txtEmail">E-mail</label>
                                        <input type="text" id="txtEmail" name="EMA_Email" class="campoTextoPadrao" style="width: 393px;" placeholder="EX.: JOAODASILVA@IGREJACONECTADA.COM" />
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <input type="button" value="Adicionar" onclick="adicionarEmail();" class="botao" id="btnAddFone" title="Adicionar email"/>
                                    </fieldset>
                                    <fieldset class="linha" style="margin-top: 10px;">                                                            
                                        <fieldset class="linha" style="height: 150px;">
                                            <div id="div-emails" style="width: 100%; height: 100%; overflow: auto;">Nenhum e-mail adicionado.</div>
                                        </fieldset>
                                    </fieldset>
                                </fieldset>
                            </fieldset>
                        </fieldset>
                    </div>
                    
                    <div id="tabs-outros-dados">
                        <fieldset class="coluna" id="fieldsetDataFundacao">
                            <label for="txtDataFundacao">Data Funda&ccedil;&atilde;o</label>
                            <input type="text" id="txtDataFundacao" name="FOR_DataFundacao" class="campoTextoPadrao" placeholder="__/__/____" style="width: 100px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtRamoAtividade">Ramo Atividade</label>
                            <input type="text" id="txtRamoAtividade" name="FOR_RamoAtividade" class="campoTextoPadrao" style="width: 323px;" />
                        </fieldset> 
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <div class="side-by-side clearfix">
                                    <label for="selBanco">Banco</label>                                
                                    <select data-placeholder="SELECIONE O BANCO." name="BAN_ID" class="chosen-select-deselect" id="selBanco"  style="width: 320px;">
                                        <option value=""></option>
                                        <?php
                                            $arrObjBancos                 = array(); 
                                            $arrStrFiltros               = array();
                                            $arrStrFiltros["BAN_Status"] = "A";
                                            $arrObjBancos                 = FachadaFinanceiro::getInstance()->consultarBanco($arrStrFiltros);
                                            $arrObjBancos2 = $arrObjBancos["objects"];
                                            for($intI=0; $intI<count($arrObjBancos2); $intI++){
                                                echo '<option value="'.$arrObjBancos2[$intI]->getId().'">'.$arrObjBancos2[$intI]->getCodigo()." - ".$arrObjBancos2[$intI]->getDescricao().'</option>';
                                            }
                                        ?> 
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtAgencia">Ag&ecirc;ncia</label>
                                <input type="text" id="txtAgencia" name="FOR_Agencia" class="campoTextoPadrao" style="width: 50px;" />
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtConta">Conta</label>
                                <input type="text" id="txtConta" name="FOR_Conta" class="campoTextoPadrao" style="width: 50px;" />
                            </fieldset>
                        </fieldset>                        
                    </div>  
                </div>
                
                <fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" value="I" name="FOR_Status" />Inativo<br />
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