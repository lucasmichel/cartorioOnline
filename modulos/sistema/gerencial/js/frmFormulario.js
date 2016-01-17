// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../sistema/gerencial/controladores/FormularioControlador.php";
var dg           = $('#grid');

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
    
    $("#dialog-excluir").dialog({
        autoOpen: false,
        buttons: {
            "Sim, eu tenho": function() {                         
                excluir();
            },
            "Não": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
     
    // inicia o grid
    initGRID();  
      
    // carrega o grid
    consultar();     
}

function consultarSubmodulos(moduloID, submoduloID){    
    var moduloID = $("#" + moduloID).val();
    
    if(moduloID == ""){
        $("#" + submoduloID).html("<option value=''>SELECIONE</option>");
    }else{    
        preLoadingOpen("Carregando submódulos, aguarde...");

        $("#" + submoduloID).html("<option value=''>SELECIONE</option>");

        $.ajax({
            type: "POST",
            url: "../../sistema/gerencial/controladores/ModuloControlador.php",
            dataType: "json",
            async: false,
            data: {ACO_Descricao: "Consultar", MCT_ID: moduloID}
        })
        .done(function( data ) {
             if(data.sucesso == "true"){                
                for(var i=0; i<data.rows.length; i++){
                    $("#" + submoduloID).append('<option value="' + data.rows[i].MOD_ID + '">' + data.rows[i].MOD_Descricao + '</option>');
                }                
            }
        });

        preLoadingClose();
    }
}

function consultar(){  
    dg.datagrid('getTbody').empty(); 
    
    var data = checarPermissao("ChecarPermissao", formularioID, "Consultar");
    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");         
    }else{
        // FILTROS
        var limitConsulta     = 20; // limit padrão    
        var moduloID          = $("#selPesquisaModulo").val();
        var submoduloID       = $("#selPesquisaSubmodulo").val();
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();    
        
        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }  
        
        var params = {
            ACO_Descricao: "Consultar", 
            MCT_ID: moduloID,
            MOD_ID: submoduloID,
            FRM_Descricao: pesquisaDescricao,
            limit: limitConsulta,
            offset: 0
        };
        
        //ATENÇÂO USAR ISTO PRA DEBUG!!!!!!!        
        /*$.post(controlador, params,
           function(data) {                            
               console.log(data);  
           }
        );*/
        
        //ATENÇÂO USAR ISTO PRA DEBUG!!!!!!!        
        
        dg.datagrid().data('uiDatagrid').options.jsonStore.params = params;               
        dg.datagrid("load");
    }
}

function initGRID(){
    dg.datagrid({
        jsonStore: {
            url: controlador,
            params: {
                ACO_Descricao: "Consultar"
            }
        }
        ,ajaxMethod: "POST"        
        ,pagination: true
        ,autoLoad: false        
        ,rowNumber: false
        ,onClickRow: function(row) {
            $(this).datagrid('selectRow',row);
        }
        ,toolBarButtons: [
            {
                label: 'Alterar'
                ,icon: 'pencil'
                ,fn: function() {
                    if(dg.datagrid('getSelectedRows').length > 0){
                        preLoadingOpen(null);
                        
                        // armazena o ID do registro para informar
                        // ao controlador qual registro será modificado
                        $("#hddID").val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML);
                                              
                        $.post(controlador, {
                            ACO_Descricao: "Consultar",
                            FRM_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                    
                                    $("#selModulo").val(data.rows[0].MCT_ID);
                                    consultarSubmodulos("selModulo", "selSubmodulo");
                                    $("#selSubmodulo").val(data.rows[0].MOD_ID);                                    
                                    
                                    $("#txtDescricao").val(data.rows[0].FRM_Descricao);
                                    $("#txtCaminho").val(data.rows[0].FRM_Caminho);
                                    $("#txtNivel1Descricao").val(data.rows[0].MFR_Nivel1Descricao);
                                    $("#txtNivel2Descricao").val(data.rows[0].MFR_Nivel2Descricao);
                                    $("#txtNivel3Descricao").val(data.rows[0].MFR_Nivel3Descricao);
                                                                        
                                    // seleciona os itens
                                    if(data.rows[0].ACO_ID != null){
                                        if (data.rows[0].ACO_ID.length > 0){
                                            // seleciona as ações gravadas
                                            for(i=0; i<data.rows[0].ACO_ID.length; i++){       
                                                $("#selAcao option[value='" + data.rows[0].ACO_ID[i] + "']").prop('selected', true);                                                                                                                                
                                            }
                                        }
                                    }

                                    if(data.rows[0].FRM_Status == "I"){ 
                                        $("#ckbStatus").prop("checked", true);
                                    }
                                    
                                    $('#tabs').tabs('option', 'active', 1);
                                }
                                
                                preLoadingClose();
                            }, "json"
                        );
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja alterar.");
                        $("#dialog-atencao").dialog("open");
                    }
                }
            },{
                label: 'Excluir'
                ,icon: 'closethick'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){                        
                        $("#dialogMensagemExcluir").html("Tem certeza que deseja remover o registro selecionado?");
                        $("#dialog-excluir").dialog("open");
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja excluir.");
                        $("#dialog-atencao").dialog("open");
                    }                    
                }
            }
        ]
        ,mapper:[{
            name: 'FRM_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'FRM_Descricao', title: 'Tela (Formul&aacute;rio)', width: 300, align: 'left'
        },{
            name: 'FRM_Caminho', title: 'Arquivo .php', width: 280, align: 'left'
        },{
            name: 'MCT_Descricao', title: 'M&oacute;dulo', width: 200, align: 'left'
        },{
            name: 'MOD_Descricao', title: 'Subm&oacute;dulo', width: 100, align: 'center'
        }]
    });
}

function salvar(){
    var acaoExecutada = "Salvar"; 
    
    // caso o elemento hddID venha com algum valor preenchido
    // o sistema entenderá que a ação que será executada 
    // é o ALTERAR
    if($.trim($("#hddID").val()) != ""){
        acaoExecutada = "Alterar";
    }
 
    // ### PERMISSAO ###
    var data = checarPermissao("ChecarPermissao", formularioID, acaoExecutada);
    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");
        return;
    }
    // ### PERMISSAO (FIM) ###
    
    if($.trim($('#selModulo').val()) == ""){        
        $("#hddFocus").val("selModulo");
        $("#dialog-atencao").html("Por favor, selecione um módulo.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selSubmodulo').val()) == ""){        
        $("#hddFocus").val("selSubmodulo");
        $("#dialog-atencao").html("Por favor, informe o submódulo que o formulário pertence.");
        $("#dialog-atencao").dialog("open");
        return;
    }

    if($.trim($('#txtDescricao').val()) == ""){        
        $("#hddFocus").val("txtDescricao");
        $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o do formulário.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#txtCaminho').val()) == ""){        
        $("#hddFocus").val("txtCaminho");
        $("#dialog-atencao").html("Por favor, informe o arquivo PHP do formulário.");        
        $("#dialog-atencao").dialog("open");
        return;
    }

    if($.trim($('#txtNivel1Descricao').val()) == ""){        
        $("#hddFocus").val("txtNivel1Descricao");
        $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o do nível 1 do menu.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    var count = $("#selAcao :selected").length;
    
    if(count == 0){        
        $("#hddFocus").val("selAcao");
        $("#dialog-atencao").html("Por favor, informe pelo menos uma ação.");
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

function cancelar(){
    $('#tabs').tabs('option', 'active', 0);
    
    // campos obrigatórios
    $("#hddID").val("");
    $("#hddFocus").val(""); 
    
    $("#selModulo").val("");    
    consultarSubmodulos("selModulo", "selSubmodulo");
    
    $("#selSubmodulo").val("");
    $("#txtDescricao").val("");
    $("#txtCaminho").val("");
    $("#txtNivel1Descricao").val("");
    $("#txtNivel2Descricao").val("");
    $("#txtNivel3Descricao").val("");
    
    // desmarca o multiselect caso tenha registros selecionados
    $('#selAcao option').prop('selected', false);
    
    $("#ckbStatus").prop("checked", false);
}

function excluir(){
    var acaoExecutada = "Excluir"; 
 
    // ### PERMISSAO ###
    var data = checarPermissao("ChecarPermissao", formularioID, acaoExecutada);
        
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // monta um array com os selecionados
    var ids = new Array();

    for(var i=0; i<dg.datagrid('getSelectedRows').length; i++){
        ids.push(dg.datagrid('getSelectedRows')[i].cells[0].innerHTML); 
    }
    
    $.post(controlador, {
        ACO_Descricao: "Excluir",
        FRM_ID: ids
    },
        function(data) {
            var dialog = "dialog-sucesso";

            if(data.excecao == "true"){
                dialog = "dialog-excecao";                 
            }   

            $("#dialog-excluir").dialog("close");

            $("#" + dialog).html(data.mensagem);
            $("#" + dialog).dialog("open");
        }, "json"
    );
}