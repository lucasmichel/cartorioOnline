<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");  
    
    // diretório do módulo
    $strDir = "../../sistema/gerencial";
    
    if(isset($_SESSION["DADOS_PARAMETRO_SISTEMA"])){
        unset($_SESSION["DADOS_PARAMETRO_SISTEMA"]);
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmParametro.js"></script>     
    
    <style>
        .campoTextoPadrao{
            text-transform: none !important;
        }
    </style>
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Parâmetros de Configuração</a></li>
        </ul>        
        <div id="tabs-1">
            <div id="dialogs">
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
            </div><!-- dialogs -->
            <form id="frm" action="<?php echo $strDir;?>/controladores/ParametroControlador.php" method="POST" onSubmit="return false;">
                <input type="hidden" id="hddFocus"/> 
                <input type="hidden" id="hddAcao" name="ACO_Descricao" value="Salvar" />
                <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" name="PAR_Logo" id="hddImagem">    
                
                <!--<div class="div-externa-fotos" style=" float: right; width: 362px; height: 70px; ">
                    <input type="file" id="fileImagem" class="file" accept="image/*" />
                    <div style="width: 100%; height: 80px;">                                    
                        <div id="div-visualizar-imagem" style="float: left; width: 362px; height: 70px;">
                            <div id="div-foto-nova">
                                <center>
                                    <img id="imagemAtual"  src="../../../modulos/sistema/gerencial/img/sem-logo.png"  width='362' height='70' />
                                </center>
                            </div>
                        </div>
                    </div>
                </div> -->
                <fieldset class="linha">   
                    <fieldset class="coluna">
                        <label for="txtQuantidadeFolhaLivro">Quantidade de folhas por livro</label>                    
                        <input id="txtQuantidadeFolhaLivro" name="PAR_TotFolhaLivro" class="campoTextoPadrao" /> 
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtQuantidadeLinhaFolha">Quantidade de linhas por folha</label>                    
                        <input id="txtQuantidadeLinhaFolha" name="PAR_TotLinhaFolha" class="campoTextoPadrao" /> 
                    </fieldset>
                </fieldset>
                
                <!--
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="txtRazaoSocial">Raz&atilde;o Social</label>                    
                        <input id="txtRazaoSocial" name="PAR_RazaoSocial" class="campoTextoPadrao" style="width: 300px" /> 
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtNomeFantasia">Nome Fantasia</label>                    
                        <input id="txtNomeFantasia" name="PAR_NomeFantasia" class="campoTextoPadrao" style="width: 300px"  /> 
                    </fieldset>
                </fieldset>
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="txtDenominacao">Denomina&ccedil;&atilde;o</label>                    
                        <input id="txtDenominacao" name="PAR_Denominacao" class="campoTextoPadrao" style="width: 300px" placeholder="DENOMINAÇÃO DA IGREJA."  /> 
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPastor">Pastor (Presidente)</label>                    
                        <input id="txtPastor" name="PAR_Pastor" class="campoTextoPadrao" style="width: 300px;" placeholder="NOME DO PASTOR DA IGREJA." /> 
                    </fieldset>                   
                </fieldset>
                <fieldset class="linha">                    
                    <fieldset class="coluna">
                        <label for="txtSite">Site</label>                    
                        <input id="txtSite" name="PAR_Site" class="campoTextoPadrao" style="width: 300px" placeholder="URL DO SITE DA IGREJA." /> 
                    </fieldset>
                </fieldset>
                
                
                
                
                <fieldset class="linha" >
                    <fieldset  style="margin-top: 10px;">
                        <legend>Endere&ccedil;o</legend>
                        <fieldset class="linha">
                            <label for="txtEnderecoCEP">Cep</label>
                            <input type="text" id="txtEnderecoCEP" name="PAR_EnderecoCep" class="campoTextoPadrao" style="width: 100px;" placeholder="_____-___"/>
                            <a href="javascript: void();" onclick="consultarEndereco();">
                                <img src="img/botao-pesquisar.png" border="0" align="absmiddle"/>
                            </a>
                            <span id="spnCarregandoCEP"></span>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoLogradouro">Logradouro</label>
                            <input type="text" id="txtEnderecoLogradouro" name="PAR_EnderecoLogradouro" placeholder="" class="campoTextoPadrao"  style="width: 300px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoNumero">N&uacute;mero</label>
                            <input type="text" id="txtEnderecoNumero" name="PAR_EnderecoNumero" placeholder="" class="campoTextoPadrao" style="width: 100px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoComplemento">Complemento</label>
                            <input type="text" id="txtEnderecoComplemento" name="PAR_EnderecoComplemento" class="campoTextoPadrao" style="width: 380px;"/>
                        </fieldset>                            
                        <fieldset class="coluna">
                            <label for="txtEnderecoBairro">Bairro</label>
                            <input type="text" id="txtEnderecoBairro" name="PAR_EnderecoBairro" placeholder="" class="campoTextoPadrao" style="width: 300px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtEnderecoCidade">Cidade</label>
                            <input type="text" id="txtEnderecoCidade" name="PAR_EnderecoCidade" class="campoTextoPadrao" style="width: 300px;"/>
                        </fieldset>
                        <fieldset class="coluna">
                            <label>Uf</label>
                            <?php
                                //echo UFSelectComponente::getInstance()->gerarSigla("selEnderecoUF", "PAR_EnderecoUf", true);
                            ?>
                        </fieldset>
                    </fieldset>
                </fieldset>
                
                <fieldset class="linha" >
                    <fieldset>
                    <legend>Contatos</legend>
                        <fieldset class="coluna" style="float: left; width: 49%; height: 100%">
                            <fieldset class="coluna">
                                <label for="txtFone">Telefone</label>
                                <input type="text" id="txtFone" name="TEL_Telefone" class="campoTextoPadrao" style="width: 100px;" placeholder="(__) ____.____" />
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
                                <input type="text" id="txtEmail" name="EMA_Email" class="campoTextoPadrao" style="width: 340px;" placeholder="EX.: JOAODASILVA@IGREJACONECTADA.COM" />
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
                </fieldset>-->
                
                
                <fieldset class="linha">
                    <input type="button" value="Atualizar" onclick="salvar();" class="botao" id="btnSalvar"/>
                </fieldset>                
            </form>
        </div><!-- tabs-1 --> 
    </div><!--  tabs -->    
    <script type="text/javascript">              
        init();
    </script>
</body>
</html>