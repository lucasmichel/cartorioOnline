// codificação utf-8
$(document).ready(function(){     
    // Dialog
    $('#dialog-sucesso').dialog({
        autoOpen: false,
        buttons: {
            "Ok": function() {
                cancelar();
                consultar();                
                $(this).dialog("close");
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
    
    $("#txtEmail").focus();
});


function recuperar(){
    if($.trim($("#txtEmail").val()) == ""){
        $("#dialog-atencao").html("Por favor, informe o email.");
        $("#dialog-atencao").dialog("open");
        $("#txtEmail").focus();
        return;
    }
    
    preLoadingOpen("Aguarde, verificando e-mail...");
    
    // bind form using ajaxForm 
    $('#frm').ajaxForm({
        // dataType identifies the expected content type of the server response 
        dataType:  'json', // Comentar essa linha para debugar
 
        // success identifies the function to invoke when the server response 
        // has been received 
        success: function(data) {
            if(data.excecao == "true"){
                preLoadingClose();
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
                return;
            } 
            
            preLoadingOpen("Enviando e-mail com a nova senha, aguarde...");
            
            if(data.sucesso == "true"){                
                $("#dialog-sucesso").html("A nova senha foi enviada para o e-mail <storng>" + $.trim($("#txtEmail").val()) + "</strong>.");
                $("#dialog-sucesso").dialog("open");
            }  
            
            preLoadingClose();
        } 
    }).submit();
}

function cancelar(){    
     $("#txtEmail").val("");     
}

function consultar(){}
