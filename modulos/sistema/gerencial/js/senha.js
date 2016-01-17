// codificação utf8
var controlador = "../../sistema/gerencial/controladores/UsuarioControlador.php";

function init(){
    // tabs
    $('#tabs').tabs();     
       
    // Dialog
    $('#dialog-sucesso').dialog({
        autoOpen: false,
        buttons: {
            "Ok": function() {
                cancelar();
                consultar();                
                $(this).dialog("close"); 
                window.location = '../home/sair.php'; 
            }
        }
    });
    
    $('#dialog-atencao').dialog({
        autoOpen: false,
        buttons: {
            "Ok": function() {
                focus($("#hddFocus").val());
                $(this).dialog("close"); 
            }
        }
    });    
      
    $("#dialog-excecao").dialog({
        autoOpen: false,
        buttons: {
            "Ok": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
}

function salvar(){    
    if($.trim($("#txtSenhaAtual").val()) == ""){        
        $("#hddFocus").val("txtSenhaAtual");
        $("#dialog-atencao").html("Por favor, informe a senha atual.");         
        $('#dialog-atencao').dialog('open');
        return;
    }
    
    if($.trim($("#txtNovaSenha").val()) == ""){        
        $("#hddFocus").val("txtNovaSenha");
        $("#dialog-atencao").html("Por favor, informe a nova senha.");         
        $('#dialog-atencao').dialog('open');
        return;
    }
    
    if($.trim($("#txtNovaSenha").val().length) <6 ){
        $("#hddFocus").val("txtNovaSenha");
        $("#txtNovaSenha").val("");
        $("#txtConfirmaSenha").val("");
        $("#dialog-atencao").html("A nova senha deve ter no mínimo 6 caracteres.");
        $('#dialog-atencao').dialog('open');
        return;
    }
    
    if($.trim($("#txtConfirmaSenha").val()) == ""){
        $("#hddFocus").val("txtConfirmaSenha");
        $("#dialog-atencao").html("Por favor, confirme a nova senha.");         
        $('#dialog-atencao').dialog('open');
        return;
    }
    
    if($.trim($("#txtConfirmaSenha").val()) != $.trim($("#txtNovaSenha").val())){
        $("#hddFocus").val("txtConfirmaSenha");
        $("#txtConfirmaSenha").val("");
        $("#dialog-atencao").html("Confirmação de senha inválida. Por favor, digite novamente.");         
        $('#dialog-atencao').dialog('open');
        return;
    }

    preLoadingOpen("Aguarde, verificando senha atual...");

    $.post(controlador, { ACO_Descricao: "VerificarSenha", USU_ID: $.trim($("#hddUsuarioID").val()), USU_Senha: $.trim($("#txtSenhaAtual").val()) },
        function(data) { 
            if(data.sucesso == "true"){
                preLoadingClose();
                
                preLoadingOpen("Aguarde, alterando senha...");
                $('#frmCadastro').ajaxForm({
                // dataType identifies the expected content type of the server response 
                dataType:  'json', // Comentar essa linha para debugar
                // success identifies the function to invoke when the server response 
                // has been received
                    success: function(data){              
                        preLoadingClose();

                        var dialog = "dialog-sucesso";

                        if(data.excecao == "true"){
                            dialog = "dialog-excecao";                    
                        }   

                        $("#" + dialog).html("Senha alterada com sucesso.");
                        $("#" + dialog).dialog("open");
                    }
                }).submit();                 
            }else{
                $("#hddFocus").val("txtSenhaAtual");
                $("#dialog-atencao").html("Senha atual não confere com a cadastrada no banco de dados e por isso não foi possível realizar a operação.");        
                $('#dialog-atencao').dialog('open');
            }     
            
            preLoadingClose();
        }, "json" 
    );
}

function consultar(){}
function cancelar(){
   $("#txtSenhaAtual").val(""); 
   $("#txtNovaSenha").val(""); 
   $("#txtConfirmaSenha").val("");
}