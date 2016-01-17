<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>
    <link type="image/ico" rel="shortcut icon" href="../home/img/favicon.ico"/> 
    
    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP;?>/js/jquery.1.10.2.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP;?>/js/jquery.ui/jquery.ui.1.10.4.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo SISTEMA_HTTP;?>/js/jquery.ui/overcast/jquery.ui.1.10.4.custom.css"/>
    
    <!-- Ajax Form -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP;?>/js/jquery.form/jquery.form.js"></script>
    
    <!-- Loading -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP;?>/js/jquery.utilitarios/jquery.blockUI.js"></script>
    
    <!-- Sistema -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP;?>/modulos/sistema/home/js/sistema.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo SISTEMA_HTTP;?>/modulos/sistema/home/css/sistema.css"/>
    
    <!-- Tela -->
    <link type="text/css" rel="stylesheet" href="../../sistema/home/css/sistema.css"/>
    <link type="text/css" rel="stylesheet" href="css/frmLogin.css"/>    
    <script type="text/javascript" src="js/frmResetaSenha.js"></script>
    
</head>
<body>    
    <div id="container">        
        <div id="dialogs">     
            <div id="dialog-sucesso" title="Sucesso"></div>
            <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
            <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
        </div><!-- dialogs --> 
        
        <div id="formulario">
            <img src="img/logo-login.png"/>
            <form id="frm" action="controladores/UsuarioControlador.php" method="POST" onSubmit="return false;">                                
                <fieldset style="padding-top: 10px; border-color: #5B8CB9;">
                    <legend style="color: #FFF;">Recuperar senha</legend>                    
                    <input type="hidden" id="hddFocus"/>
                    <input type="hidden" name="ACO_Descricao" value="RecuperarSenha"/>
                    
                    <label for="txtUsuario">Informe o e-mail do usuario</label>
                    <input type="text" id="txtEmail" name="USU_Email" maxlength="30" class="campoTextoPadrao" placeholder="Ex.: joao.bastista@email.com" style="margin-bottom: 5px; text-align: center;text-transform: none; width: 142px;"/>
                    
                    <input type="hidden" id="hddStatus" name="USU_Status" value="A"/>
                    
                    <input type="button" id="btnAcessar" value="Alterar" onclick="recuperar();" class="botao" style="margin-top: 15px; height: 38px; "/>   
                    <br/><br/>
                    <a href="frmLogin.php  " class="linkEsqueceuSuaSenha">Efetuar Login</a>
                    
                    
                </fieldset>
            </form>
        </div>        
    </div> 
    
    
    
    <!--<div id="container">         
        <div id="dialogs">
            <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div>
            <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
        </div>
        <div id="formulario">
            <img src="img/logo-login.png"/>
            <form id="frm" action="controladores/UsuarioControlador.php" method="POST" onsubmit="return false;">
                <fieldset style="border: 1px; text-align: center; padding-top: 10px;">
                    
                    <input type="hidden" id="hddFocus"/>
                    <input type="hidden" name="ACO_Descricao" value="ChecarAcesso"/>
                    
                    
                    <label for="txtUsuario">Usu&aacute;rio</label>
                    <input type="text" id="txtUsuario" name="USU_Login" maxlength="30" placeholder="INFORME SEU USUARIO." onkeypress="proximoENTER(event, $('#txtSenha'));" onblur="fimFocus(this.id);" style="margin-bottom: 5px; text-align: center; width: 200px;" class="campoTextoPadrao"/>
                    <label for="txtSenha">Senha</label>
                    <input type="password"  id="txtSenha" name="USU_Senha" maxlength="16" class="campoTextoPadrao" onkeypress="proximoENTER(event, $('#btnAcessar'));" onblur="fimFocus(this.id);" style="text-align: center; text-transform: none;  width: 200px;" placeholder="INFORME SUA SENHA."/>
                    <input type="button" id="btnAcessar" value="Acessar" onclick="acessar();" onFocus="acessar();" class="botao" style="margin-top: 15px;"/>   
                    <a href="frmResetaSenha.php" class="linkEsqueceuSuaSenha">Esqueceu sua senha?</a>
                </fieldset>
            </form>
        </div>
        <div id="versao">
            <p>
                <b>Vers&atilde;o do Software:</b> <?php echo SISTEMA_VERSAO; ?>
            </p>
        </div>
        <div id="licenca">
            <p>
                <b>Desenvolvido pela <?php echo EMPRESA;?></b>
                <br/>
                <a href="http://<?php echo EMPRESA_SITE;?>" target="_blank" title="Clique para visitar o site da <?php echo EMPRESA;?>."><?php echo EMPRESA_SITE;?></a>
            </p>
        </div>
    </div>-->
    
    
    
    
    
    
    
    
</body>
</html>