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
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmCongregacao.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Congrega&ccedil;&otilde;es Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">  
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Descri&ccedil;&atilde;o</label>
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
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/CongregacaoControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="UNI_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="txtDescricao">Nome da Congregação*</label>
                        <input type="text" id="txtDescricao" name="UNI_Descricao" class="campoTextoPadrao" style="width: 250px;"/>
                    </fieldset>                 
                    <fieldset class="coluna">
                        <label for="txtTelefone">Telefone</label>
                        <input type="text" id="txtTelefone" name="UNI_Telefone" placeholder="(__) ____.____" class="campoTextoPadrao" style="width: 100px;" />
                    </fieldset>                 
                    <fieldset class="coluna">
                        <label for="txtFax">Fax</label>
                        <input type="text" id="txtFax" name="UNI_Fax" class="campoTextoPadrao"  placeholder="(__) ____.____" style="width: 100px;"/>
                    </fieldset>  
                    
                    <fieldset class="coluna">
                        <label for="txtFax">Responsável</label>
                        <input type="text" id="txtResponsavel" name="UNI_Responsavel" class="campoTextoPadrao" style="width: 250px;"/>
                    </fieldset> 
                </fieldset>
                <fieldset class="linha">
                    <fieldset>
                        <legend>Endere&ccedil;o</legend>
                        <fieldset class="linha">
                            <fieldset class="linha">
                                 <label for="txtEnderecoCEP">CEP</label>
                                 <input type="text" id="txtEnderecoCEP" name="UNI_EnderecoCep" class="campoTextoPadrao" style="width: 100px;" placeholder="_____-___"/>
                                 <a href="javascript: void();" onclick="consultarEndereco();">                                         
                                     <img src="../../../modulos/sistema/home/img/botao-pesquisar.png" border="0" align="absmiddle"/>
                                 </a>
                                 <span id="spnCarregandoCEP"></span>
                            </fieldset>
                        </fieldset>
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                 <label for="txtEnderecoLogradouro">Logradouro</label>
                                 <input type="text" id="txtEnderecoLogradouro" name="UNI_EnderecoLogradouro" class="campoTextoPadrao"  style="width: 300px;"/>
                            </fieldset>
                            <fieldset class="coluna">
                                 <label for="txtEnderecoNumero">N&uacute;mero</label>
                                 <input type="text" id="txtEnderecoNumero" name="UNI_EnderecoNumero" class="campoTextoPadrao" style="width: 60px;"/>
                             </fieldset>
                             <fieldset class="coluna">
                                 <label for="txtEnderecoComplemento">Complemento</label>
                                 <input type="text" id="txtEnderecoComplemento" name="UNI_EnderecoComplemento" class="campoTextoPadrao" style="width: 200px;"/>
                             </fieldset>
                        </fieldset>
                        <fieldset class="linha">
                             <fieldset class="coluna">
                                 <label for="txtEnderecoBairro">Bairro</label>
                                 <input type="text" id="txtEnderecoBairro" name="UNI_EnderecoBairro" class="campoTextoPadrao" style="width: 300px;"/>
                             </fieldset>
                             <fieldset class="coluna">
                                 <label for="txtEnderecoCidade">Cidade</label>
                                 <input type="text" id="txtEnderecoCidade" name="UNI_EnderecoCidade" class="campoTextoPadrao" style="width: 282px;"/>
                             </fieldset>
                            <fieldset class="linha">
                                <fieldset class="coluna">
                                     <label for="txtEnderecoPontoReferencia">Ponto de referência</label>
                                     <input type="text" id="txtEnderecoPontoReferencia" name="UNI_EnderecoPontoReferencia" class="campoTextoPadrao" style="width: 300px;"/>
                                 </fieldset>
                                 <fieldset class="coluna" >
                                     <label for="selEnderecoUF">Estado</label>
                                     <?php
                                         echo UFSelectComponente::getInstance()->gerarSigla("selEnderecoUF", "UNI_EnderecoUf", true);
                                     ?>
                                 </fieldset>
                            </fieldset>
                        </fieldset>
                    </fieldset>  
                </fieldset>  
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="txtObservacao">Anotações</label>
                        <textarea id="txtObservacao" name="UNI_Observacao" class="campoTextoPadrao" style="width: 620px;" rows="4"></textarea>
                    </fieldset>
                </fieldset>
                <fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" name="UNI_Status" value="I" />Inativo<br />
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