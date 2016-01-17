// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/cadastro/controladores/StatusMembroControlador.php";
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
      
    // configura o grid
    initGRID();   
      
    // carrega o grid
    consultar();      
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
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();    
        var pesquisaStatus    = $("#selPesquisaStatus").val();    

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            MES_Descricao: pesquisaDescricao,
            MES_Status: pesquisaStatus,
            limit: limitConsulta,
            offset: 0
        };
        
        dg.datagrid().data('uiDatagrid').options.jsonStore.params = params;                
        dg.datagrid("load");
    }
}

function initGRID(){ 
    dg.datagrid({
        jsonStore: {
            url: controlador
            ,params: {
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
                        if(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML != 1 && dg.datagrid('getSelectedRows')[0].cells[0].innerHTML != 2){
                            $("#hddID").val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML);                                              
                            $.post(controlador, {
                                ACO_Descricao: "Consultar",
                                MES_ID: $("#hddID").val()
                            },
                                function(data){                                
                                    if(data.sucesso == "true"){                                    
                                        $("#txtDescricao").val(data.rows[0].MES_Descricao);
                                        if(data.rows[0].MES_Status == "I"){ 
                                            $("#ckbStatus").prop("checked", true);
                                        }
                                        $('#tabs').tabs('option', 'active', 1);
                                    }
                                    preLoadingClose();
                                }, "json"
                            );
                        }else{
                            preLoadingClose();
                            $("#dialog-atencao").html("Registro padr&atilde;o do sistema. Opera&ccedil;&atilde;o n&atilde;o permitida.");
                            $("#dialog-atencao").dialog("open");
                        }
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
                        if(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML != 1 && dg.datagrid('getSelectedRows')[0].cells[0].innerHTML != 2){
                            $("#dialogMensagemExcluir").html("Tem certeza que deseja remover o registro selecionado?");
                            $("#dialog-excluir").dialog("open");
                        }else{
                            preLoadingClose();
                            $("#dialog-atencao").html("Registro padr&atilde;o do sistema. Opera&ccedil;&atilde;o n&atilde;o permitida.");
                            $("#dialog-atencao").dialog("open");
                        }
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja excluir.");
                        $("#dialog-atencao").dialog("open");
                    }                    
                }
            }
        ]
        ,mapper:[{
            name: 'MES_ID', title: 'Cód.', width: 60, align: 'center'
        },{
            name: 'MES_Descricao', title: 'Descrição', width: 880, align: 'left'        
        },{
            name: 'MES_Status', title: 'Ativo', width: 60, align: 'center', render: function(d) {
                var status = 'SIM';
                if(d == "I"){
                    status = "NÃO";
                }
                return status;
            }
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
    
    if($.trim($('#txtDescricao').val()) == ""){        
        $("#hddFocus").val("txtDescricao");
        $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    //preLoadingOpen("Gravando, aguarde...");
    
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
    // campos obrigatórios
    $("#hddID").val("");
    $("#hddFocus").val("");
    $("#txtDescricao").val("");        
    $("#ckbStatus").attr("checked", false);
    $('#tabs').tabs('option', 'active', 0);
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
        MES_ID: ids
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