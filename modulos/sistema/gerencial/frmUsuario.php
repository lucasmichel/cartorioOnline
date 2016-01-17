<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");
    
    // diretório do módulo
    $strDir = "../../sistema/gerencial";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmUsuario.js"></script>      
</head>
<body>
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Usu&aacute;rios Cadastrados</a></li>
            <li><a href="#tabs-2" onClick="exibirFuncionario();">Novo Registro*</a></li>
        </ul>        
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" onSubmit="return false;">
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Login</label>
                        <input type="text" id="txtPesquisaDescricao" name="USU_Login" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa();?>" class="campoTextoPadrao" style="width: 250px;"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaStatus">Ativo</label>
                        <select id="selPesquisaStatus" name="USU_Status" class="campoSelect">                            
                            <option value="A" selected>SIM</option>
                            <option value="I">NÃO</option>  
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
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/UsuarioControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="USU_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="linha">
                    <label for="selGrupo">Grupo*</label>
                    <select id="selGrupo" name="GRU_ID" class="campoSelect" style="width: 258px;">                        
                        <option value="">SELECIONE</option>
                        <?php                             
                            $arrStrFiltros = array();
                            $arrStrFiltros["USU_Status"] = "A";                            
                            $arrObjs = FachadaGerencial::getInstance()->consultarGrupo($arrStrFiltros);                            
                            $arrObjs = $arrObjs["objects"];
                            
                            $strHtml = ""; 
                            
                            if($arrObjs != null){
                                if(count($arrObjs) > 0){                                                                      
                                    for($intI=0; $intI<count($arrObjs); $intI++){
                                        $strHtml .= "<option value='".$arrObjs[$intI]->getId()."'>".$arrObjs[$intI]->getDescricao()."</option>";
                                    }
                                }
                            }     
                            
                            echo $strHtml;
                        ?>
                    </select>
                </fieldset>
                <fieldset class="linha">
                    <label for="txtNome">Nome*</label>
                    <input type="text" id="txtNome" name="USU_Nome" class="campoTextoPadrao" maxlength="50" style="width: 238px;" placeholder="INFORME O NOME DO USUÁRIO."/>
                </fieldset>
                <fieldset class="linha">
                    <label for="txtLogin">Login*<b> (M&iacute;nimo 6 caracteres)</b></label>
                    <input type="text" id="txtLogin" name="USU_Login" class="campoTextoPadrao" style="width: 238px;" placeholder="INFORME O LOGIN."/>
                </fieldset>
                <fieldset class="linha">
                    <label for="txtSenha">Senha* <b>(M&iacute;nimo 6 caracteres)</b></label>
                    <input type="password" id="txtSenha" name="USU_Senha" class="campoTextoPadrao" maxlength="32" style="width: 238px;"/>
                </fieldset>
                <fieldset class="linha">
                    <label for="txtSenha">Confirme a senha*</label>
                    <input type="password" id="txtConfirmeSenha" class="campoTextoPadrao" maxlength="32" style="width: 238px;"/>
                </fieldset>
                <fieldset class="linha">
                    <label for="txtEmail">Email*</label>
                    <input type="text" id="txtEmail" name="USU_Email" class="campoTextoPadrao" placeholder="EX.: JOAO.BATISTA@DOMINIO.COM" style="width: 238px;" />
                </fieldset>
                <fieldset class="coluna">
                    <label for="txtTelefone">Telefone</label>
                    <input type="text" id="txtTelefone" name="USU_Telefone" class="campoTextoPadrao" placeholder="(__)____.____"/>                
                </fieldset>                
                <fieldset class="linha">
                    <input type="checkbox" id="ckbStatus" name="USU_Status" value="I"/>Inativo
                </fieldset>
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