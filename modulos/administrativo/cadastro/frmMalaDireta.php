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
    <!-- jQuery Tinymce -->        
    <script type="text/javascript" src="../../../js/jquery.tinymce/tinymce.min.js"></script>
    <!-- jQuery Tinymce --> 
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmMalaDireta.js"></script>    
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
                        <label for="txtPesquisaDescricao">Assunto</label>
                        <input type="text" id="txtPesquisaDescricao" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa();?>" class="campoTextoPadrao" style="width: 250px;"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>
                    </fieldset>
                </form>
            </div>
            <fieldset style="margin-top: 5px; margin-bottom: 5px; padding: 0px; border: 0px;">
                <input type="checkbox" style="margin-left: 0px; " id="ckbSelecionarTodos" onclick="selecionarTodos();"/>Selecionar todos
            </fieldset>
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
                
                <div id="dialog-envio-mala-direta" title="Envio da mala">
                    <form id="frmEnvioEmail" action="<?php echo $strDir;?>/controladores/MalaDiretaControlador.php" method="POST" onSubmit="return false;">
                        <input type="hidden" name="ACO_Descricao" value="EnviarEmails"/> <!-- para o Salvar/Alterar -->
                        <input type="hidden" name="MAD_ID" id="idMala"/> <!-- para o Salvar/Alterar -->
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <label for="selFilraPessoaPor">Grupos para envio</label>                                
                                <select style="width: 150px;" class="campoSelect" id="selFilraPessoaPor" onchange="preencherPessoasEnvio();" >
                                    <option value="FUNCIONARIO">FUNCIONÁRIO</option>
                                    <option value="MEMBRO" selected="true">MEMBRO</option>
                                    <option value="TODOS">TODOS</option>                        
                                    <option value="VISITANTE">VISITANTE</option>                                    
                                </select>
                            </fieldset>                            
                        </fieldset>
                        <fieldset class="linha">
                            <fieldset>
                                <legend>Emails para envio</legend>
                                <div style="width: 100%; height: 400px; overflow: auto; ">
                                    <div id="div-grid-emails-envio">
                                        
                                    </div>
                                </div>
                            </fieldset>
                        </fieldset>
                        
                    </form>
                </div>
                
                <div id="dialog-executa-envio-email" title="Envio de emails">                    
                    <p>
                        <span id="totEmailEnviado">1</span> / 
                        <span id="totEmail">10</span> 
                        <span style="padding-left: 5px; padding-top: 3px;" id="spanImagemLoad" ></span>
                    </p>
                    <p>
                       <progress style="width:100%" value="0" max="0" ></progress>
                    </p>
                    <p id="resultadoEnvio">
                    </p>
                </div>
                
                
                
                
                
            </div><!-- dialogs -->            
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/MalaDiretaControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="MAD_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <input type="hidden" id="hddTexto" name="MAD_Conteudo"/>
                
                <fieldset class="linha">
                    <label for="txtAssunto">Assunto*</label>
                    <input type="text" id="txtAssunto" name="MAD_Assunto" class="campoTextoPadrao" style="width: 350px;" placeholder="" />
                </fieldset>
                
                <fieldset class="linha">
                    <label >Conteúdo*</label>                    
                    <textarea id="txtConteudo" style="width:100%; height: 500px;"><?php //echo $arrObjs[0]->getTexto();?></textarea>
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