<?php
    // codificação UTF-8
    session_start();    
    session_destroy();
    
    include("../../../inc/config.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO;?></title>
    <link type="image/ico" rel="shortcut icon" href="../home/img/favi.png"/>
    
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
    <link type="text/css" rel="stylesheet" href="css/frmLogin.css"/>    
    <script type="text/javascript" src="js/frmLogin.js"></script>    
</head>
<body>    
    <div id="container">         
        <div id="dialogs">
            <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div>
            <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
        </div><!-- dialogs -->        
        <div id="formulario">
            <img src="img/logo-login.png"/>
            <form id="frm" action="controladores/UsuarioControlador.php" method="POST" onsubmit="return false;">
                <fieldset style="border: 1px; text-align: center; padding-top: 10px;">
                    <!-- Campos Obrigatórios (Início) -->
                    <input type="hidden" id="hddFocus"/>
                    <input type="hidden" name="ACO_Descricao" value="ChecarAcesso"/>
                    <!-- Campos Obrigatórios (Fim) -->
                    
                    <label for="txtUsuario">Usu&aacute;rio</label>
                    <input type="text" id="txtUsuario" name="USU_Login" maxlength="30" placeholder="INFORME SEU USUARIO." onkeypress="proximoENTER(event, $('#txtSenha'));" onblur="fimFocus(this.id);" style="margin-bottom: 5px; text-align: center; width: 200px;" class="campoTextoPadrao"/>
                    <label for="txtSenha">Senha</label>
                    <input type="password"  id="txtSenha" name="USU_Senha" maxlength="16" class="campoTextoPadrao" onkeypress="proximoENTER(event, $('#btnAcessar'));" onblur="fimFocus(this.id);" style="text-align: center; text-transform: none;  width: 200px;" placeholder="INFORME SUA SENHA."/>
                    <input type="button" id="btnAcessar" value="Acessar" onclick="acessar();" onFocus="acessar();" class="botao" style="margin-top: 15px;"/>   
                    <!--<a href="frmResetaSenha.php" class="linkEsqueceuSuaSenha">Esqueceu sua senha?</a>-->
                </fieldset>
            </form>
        </div><!-- formulario -->
        <div id="versao">
            <?php
                // identifica a versão do sistema
                /*$arrStrSys = Db::getInstance()->select("SELECT SYS_Versao FROM CAD_SYS_SYSTEM");                
                
                //identifica o nome da igreja
                $arrObjs = FachadaGerencial::getInstance()->consultarParametro(null);                
                if($arrObjs != null){
                    $arrObjs = $arrObjs["objects"];                    
                    echo '<p>';                        
                        echo '<strong>Ambiente: </strong>' .$arrObjs[0]->getNomeFantasia();                        
                    echo '</p>';
                }*/
            ?>            
            <!--<p>
                <b>Vers&atilde;o do Software:</b> <?php //echo $arrStrSys[0]["SYS_Versao"];?>
            </p>-->
        </div><!-- versao -->
        <div id="licenca">
            <p>
                <b>Desenvolvido pela <?php echo EMPRESA;?></b>
                <br/>
                <!--<a href="http://<?php echo EMPRESA_SITE;?>" target="_blank" title="Clique para visitar o site da empresa <?php echo EMPRESA;?>."><?php echo EMPRESA_SITE;?></a>-->
            </p>
        </div><!-- licenca -->
    </div><!-- container -->    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>