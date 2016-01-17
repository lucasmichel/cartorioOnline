<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php"); 
    include("inc/autoload.inc.php"); 
    
    $strDir = "../../sistema/gerencial";    
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="../home/js/sistema.js"></script> 
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/senha.js"></script>    
</head>
<body>
    <div id="dialogs">     
        <div id="dialog-sucesso" title="Sucesso"></div>
        <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
        <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
    </div><!-- dialogs -->    
    
    <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/UsuarioControlador.php" method="POST" onSubmit="return false;">
        <!-- campos obrigatórios no Salvar/Alterar -->
        <input type="hidden" id="hddAcao" name="ACO_Descricao" value="AlterarSenha"/>
        <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>
        <input type="hidden" id="hddID" name="PAG_ID" value=""/>                
        <input type="hidden" id="hddUsuarioID" name="USU_ID" value="<?php echo $_SESSION["USUARIO_ID"];?>" />
        <input type="hidden" id="hddFocus"/>
          
        <div style="width: 210px; margin: auto;">
            <fieldset class="linha">
                <label>Senha atual*</label>
                <input type="password" id="txtSenhaAtual" name="USU_Senha" style="text-transform: none; width: 173px;" class="campoTextoPadrao"/>
            </fieldset>
            
            <fieldset class="linha">
                <label>Nova senha*</label>
                <input type="password" id="txtNovaSenha" name="USU_Nova_Senha" style="text-transform: none; width: 173px;" class="campoTextoPadrao" maxlength="12"/>
            </fieldset>
            
            <fieldset class="linha">
                <label>Confirme a nova senha*</label>
                <input type="password" id="txtConfirmaSenha" style="text-transform: none; width: 173px;" name="txtConfirmaSenha" class="campoTextoPadrao" maxlength="12" />
            </fieldset>
            
            <fieldset class="linha">
                <input type="button" id="btnCadastrar" name="btnCadastrar" class="botao" value="Salvar" onclick="salvar();"  />
                <input type="button" id="btnCancelar" name="btnCancelar" class="botao" value="Cancelar" onclick="cancelar();" />
            </fieldset>
        </div>
    </form>
    
    <script type="text/javascript">
        init();
        
        focus("txtSenhaAtual");
    </script>
</body>
</html>