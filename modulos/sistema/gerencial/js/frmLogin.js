// codificação utf-8
function init(){    
    $("#dialog-atencao").dialog({
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
    
    focus("txtUsuario"); // começa com o focus no elemento txtUsuario
}

function acessar(){   
    if($.trim($("#txtUsuario").val()) == ""){
        $("#dialog-atencao").html("Por favor, informe o usuário.");
        $("#dialog-atencao").dialog("open");
        $("#hddFocus").val("txtUsuario");
        return;
    }
    
    if($.trim($("#txtSenha").val()) == ""){
        $("#dialog-atencao").html("Por favor, informe a senha.");
        $("#dialog-atencao").dialog("open");
        $("#hddFocus").val("txtSenha");
        return;
    }

    preLoadingOpen("Verificando usuário e senha, aguarde..."); 
   
    // bind form using ajaxForm 
    $('#frm').ajaxForm({
        // dataType identifies the expected content type of the server response 
        dataType:  'json', // Comentar essa linha para debugar 
        // success identifies the function to invoke when the server response 
        // has been received 
        success: function(data) {            
            //console.log(data);return;
            if(data.sucesso == "true"){                
                window.location = "../../../modulos/sistema/home/principal.php";                                
            }else{
                preLoadingClose();
                var dialog = "dialog-atencao";
                if(data.excecao == "true"){
                    dialog = "dialog-excecao"; 
                    
                }
                $("#txtSenha").val("");
                $("#hddFocus").val("txtUsuario");
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
                $("#txtUsuario").select();                
            }   
        } 
    }).submit();
}