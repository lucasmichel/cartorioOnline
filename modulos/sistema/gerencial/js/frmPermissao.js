// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../sistema/gerencial/controladores/PermissaoGrupoUsuarioControlador.php";

// inicialização
function init(){
    // tabs
    $('#tabs').tabs();
     
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
}

function marcarDesmarcarTodosGrupo(){    
    if ($("#ckbTodos").is(":checked")){       
      $('.checkboxTodos').each(
         function(){
            $(this).prop("checked", true);
            
            // split para identificar o ID de cada formulário
            // e posteriormente marcar todas ações do formulário
            // já que a opção selecionada foi TODAS AS AÇÕES
            arrID = this.id.split("_");
            
            // arrID[1] corresponde ao ID do registro
            marcarDesmarcarTodasAcoesGrupo(arrID[1]);
         }
      );
   }else{
      $('.checkboxTodos').each(
         function(){             
            $(this).prop("checked", false);
            
            // split para identificar o ID de cada formulário
            // e posteriormente marcar todas ações do formulário
            // já que a opção selecionada foi TODAS AS AÇÕES
            arrID = this.id.split("_");
            
            // arrID[1] corresponde ao ID do registro
            marcarDesmarcarTodasAcoesGrupo(arrID[1]);
         }
      );
   }
}

function marcarDesmarcarTodasAcoesGrupo(formularioID){    
    if ($("#checkboxTodos_" + formularioID).is(":checked")){
      $('.checkboxAcao_' + formularioID).each(
         function(){
            $(this).prop("checked", true);            
         }
      );
   }else{
      $('.checkboxAcao_' + formularioID).each(
         function(){
            $(this).prop("checked", false);            
         }
      );
   }
}

function marcarDesmarcarTodosUsuario(){
   if ($("#ckbTodosU").is(":checked")){
      $('.checkboxTodosU').each(
         function(){
            $(this).prop("checked", true);
            
            // split para identificar o ID de cada formulário
            // e posteriormente marcar todas ações do formulário
            // já que a opção selecionada foi TODAS AS AÇÕES
            arrID = this.id.split("_");
            
            // arrID[1] corresponde ao ID do registro
            marcarDesmarcarTodasAcoesUsuario(arrID[1]);
         }
      );
   }else{
      $('.checkboxTodosU').each(
         function(){
            $(this).prop("checked", false);
            
            // split para identificar o ID de cada formulário
            // e posteriormente marcar todas ações do formulário
            // já que a opção selecionada foi TODAS AS AÇÕES
            arrID = this.id.split("_");
            
            // arrID[1] corresponde ao ID do registro
            marcarDesmarcarTodasAcoesUsuario(arrID[1]);
         }
      );
   }
}

function marcarDesmarcarTodasAcoesUsuario(formularioID){    
    if ($("#checkboxTodosU_" + formularioID).is(":checked")){
      $('.checkboxAcaoU_' + formularioID).each(
         function(){
            $(this).prop("checked", true);            
         }
      );
   }else{
      $('.checkboxAcaoU_' + formularioID).each(
         function(){
            $(this).prop("checked", false);            
         }
      );
   }
}

function salvarPermissaoGrupo(){ 
    // ### PERMISSAO ###
    var data = checarPermissao("ChecarPermissao", formularioID, "Salvar");
    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");
        return;
    }
    // ### PERMISSAO (FIM) ###
    
    if($.trim($('#selGrupo').val()) == ""){        
        $("#hddFocus").val("selGrupo");
        $("#dialog-atencao").html("Por favor, selecione o grupo do usuário.");
        $("#dialog-atencao").dialog("open");
        return;
    }
         
    preLoadingOpen("Gravando, aguarde...");
    
    // bind form using ajaxForm 
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

            $("#" + dialog).html(data.mensagem);
            $("#" + dialog).dialog("open");
        }
    }).submit(); 
}

function salvarPermissaoUsuario(){ 
    // ### PERMISSAO ###
    var data = checarPermissao("ChecarPermissao", formularioID, "Salvar");
    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");
        return;
    }
    // ### PERMISSAO (FIM) ###
    
    if($.trim($('#selUsuario').val()) == ""){        
        $("#hddFocus").val("selGrupo");
        $("#dialog-atencao").html("Por favor, selecione o usuário.");
        $("#dialog-atencao").dialog("open");
        return;
    }
         
    preLoadingOpen("Gravando, aguarde...");
    
    // bind form using ajaxForm 
    $('#frmCadastroUsuario').ajaxForm({
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

            $("#" + dialog).html(data.mensagem);
            $("#" + dialog).dialog("open");
        }
    }).submit(); 
}

function consultarPermissoesGrupo(){
    var grupoID = $("#selGrupo").val();
    limparMarcacoesGrupo();
    
    if(grupoID != ""){                
        preLoadingOpen(null);

        $.post(controlador, {
            ACO_Descricao: "ConsultarGrupo",
            GRU_ID: grupoID
        },
            function(data){
                if(data.sucesso == "true"){                                    
                    for(var i=0; i<data.rows.length; i++){
                        $("#ckbAcao_" + data.rows[i].FRM_ID + "_" + data.rows[i].ACO_ID).prop("checked", true);
                    }
                }

                preLoadingClose();
            }, "json"
        );
    }
}

function consultarPermissoesUsuario(){
    var usuarioID = $("#selUsuario").val();
    limparMarcacoesUsuario();
    
    if(usuarioID != ""){        
        preLoadingOpen(null);

        $.post(controlador, {
            ACO_Descricao: "ConsultarUsuario",
            USU_ID: usuarioID
        },
            function(data){                
                if(data.sucesso == "true"){                                    
                    for(var i=0; i<data.rows.length; i++){
                        $("#ckbAcaoU_" + data.rows[i].FRM_ID + "_" + data.rows[i].ACO_ID).prop("checked", true);
                    }
                }

                preLoadingClose();
            }, "json"
        );
    }
}

function cancelarPermissaoGrupo(){
    $("#selGrupo").val("");
    limparMarcacoesGrupo();
}
function limparMarcacoesGrupo(){
    $("#ckbTodos").prop("checked", false);
    marcarDesmarcarTodosGrupo();
}

function cancelarPermissaoUsuario(){    
    $("#selUsuario").val("");
    limparMarcacoesUsuario();
}
function limparMarcacoesUsuario(){
    $("#ckbTodosU").prop("checked", false);
    marcarDesmarcarTodosUsuario();
}

function consultar(){}
function cancelar(){}