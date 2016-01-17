// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/financeiro/controladores/TransferenciaContaControlador.php";
var dg           = $('#grid');
// inicialização
function init(){
    // tabs
    $('#tabs').tabs();
    
    $("#txtDataTransferencia").mask("99/99/9999"); 
    $("#txtDataTransferencia").datepicker();
        
    $('#txtValor').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
    $("#txtPesquisaDataInicial").mask("99/99/9999");
    $("#txtPesquisaDataInicial").datepicker();
    
    $("#txtPesquisaDataFinal").mask("99/99/9999");
    $("#txtPesquisaDataFinal").datepicker();
    
     
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
      
    // carrega o grid
    initGRID();
    consultar();     
}

function consultar(){    
    // limpa o grid
    dg.datagrid('getTbody').empty();
    
    var data = checarPermissao("ChecarPermissao", formularioID, "Consultar");
    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");         
    }else{        
        // FILTROS
        var limitConsulta     = 20; // limit padrão 
        var pesquisaDataInicial = $("#txtPesquisaDataInicial").val();
        var pesquisaDataFinal   = $("#txtPesquisaDataFinal").val();   

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        } 
        
        var params = {
            ACO_Descricao: "Consultar", 
                TRC_DataTransferenciaInicial: pesquisaDataInicial,
                TRC_DataTransferenciaFinal: pesquisaDataFinal,
                limit: limitConsulta,
                offset: 0
        };
        
        dg.datagrid().data('uiDatagrid').options.jsonStore.params = params;               
        dg.datagrid("load");
    }
}

function initGRID(){ 
        
     
    // PARA TESTE 
    /*$.post(controlador, {
        ACO_Descricao: "Consultar",        
        BAN_Descricao: pesquisaDescricao,
        BAN_Status: pesquisaStatus,
        limit: limitConsulta,
        offset: 0
    },
        function(data) {                            
            alert(data);
            return;
        }
    );
    
    return;*/
        
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
            /*{
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
                            TRC_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){          
                                    
                                    $("#selContaOrigem").val(data.rows[0].COB_De_ID); 
                                    $('#selContaOrigem').trigger('chosen:updated');
                                    
                                    $("#selContaDestino").val(data.rows[0].COB_Para_ID); 
                                    $('#selContaDestino').trigger('chosen:updated');
                                    
                                    $("#txtValor").val(data.rows[0].TRC_Valor);
                                    $("#txtDataTransferencia").val(data.rows[0].TRC_DataTransferencia);
                                    
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
            },*/{
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
            name: 'TRC_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'descricaoContaDe', title: 'Conta de', width: 350, align: 'left'
        },{
            name: 'descricaoContaPara', title: 'Conta para', width: 350, align: 'left'
        },{
            name: 'TRC_DataTransferencia', title: 'Data da transferência', width: 150, align: 'left'        
        },{
            name: 'TRC_Valor', title: 'Valor', width: 100, align: 'left'
        }
    
        
        ]
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
    
    if($.trim($('#selContaOrigem').val()) == ""){        
        $("#hddFocus").val("selContaOrigem");
        $("#dialog-atencao").html("Por favor, informe a conta de origem.");
        $("#dialog-atencao").dialog("open");
        return;
    }    
    if($.trim($('#selContaDestino').val()) == ""){        
        $("#hddFocus").val("selContaDestino");
        $("#dialog-atencao").html("Por favor, informe a conta de destino.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    
    
    if($.trim($('#selContaDestino').val()) == $.trim($('#selContaOrigem').val())){        
        $("#hddFocus").val("selContaDestino");
        $("#dialog-atencao").html("Por favor, informe contas diferentes para a transferência.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    
    if($.trim($('#txtValor').val()) == "0,00"){        
        $("#hddFocus").val("txtValor");
        $("#dialog-atencao").html("Por favor, informe o valor da transferência.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#txtDataTransferencia').val()) == ""){        
        $("#hddFocus").val("txtDataTransferencia");
        $("#dialog-atencao").html("Por favor, informe a data da transfrência.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(!isDataValida($('#txtDataTransferencia').val())){        
        $("#hddFocus").val("txtDataTransferencia");
        $("#dialog-atencao").html("Por favor, informe a data da transfrência válida.");
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
    // campos obrigatórios
    $("#hddID").val("");
    $("#hddFocus").val("");
    
    $("#selContaOrigem").val(""); 
    $('#selContaOrigem').trigger('chosen:updated');

    $("#selContaDestino").val(""); 
    $('#selContaDestino').trigger('chosen:updated');

    $("#txtValor").val("0,00");
    $("#txtDataTransferencia").val("");
    
    $("#saldoAtualContaDestino").html("");
    $("#saldoAtualContaOrigem").html("");                            
    
    
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
    // ### PERMISSAO ###    
    $.post(controlador, {
        ACO_Descricao: "Excluir",
        TRC_ID: dg.datagrid('getSelectedRows')[0].cells[0].innerHTML
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

function preencherValorContaDe(){
    if($('#selContaOrigem').val() > 0){
        $.post(controlador, {
        ACO_Descricao: "GetValorContaBancaria",
        COB_ID: $('#selContaOrigem').val()
        },
            function(data) {
                var dialog = "dialog-sucesso";
                if(data.excecao == "true"){
                    dialog = "dialog-excecao";                 
                    $("#" + dialog).html(data.mensagem);
                    $("#" + dialog).dialog("open");
                }else{
                    if(data.sucesso == "true"){                    
                        if(data.rows.valor > 0){
                            $("#saldoAtualContaOrigem").html("Saldo: R$ <span style='font-weight: bolder;' >"+data.rows.saldo+" </span> ");
                        }else{
                            $("#saldoAtualContaOrigem").html("Saldo: R$ <span style='font-weight: bolder;' >"+data.rows.saldo+" </span> ");
                        }
                    }
                }            
            }, "json"
        );
    }else{
        $("#saldoAtualContaOrigem").html("");
    }
    
}
function preencherValorContaPara(){    
    if($('#selContaDestino').val() > 0){
        $.post(controlador, {
        ACO_Descricao: "GetValorContaBancaria",
        COB_ID: $('#selContaDestino').val()
        },
            function(data) {
                var dialog = "dialog-sucesso";
                if(data.excecao == "true"){
                    dialog = "dialog-excecao";                 
                    $("#" + dialog).html(data.mensagem);
                    $("#" + dialog).dialog("open");
                }else{
                    if(data.sucesso == "true"){
                        if(data.rows.valor > 0){
                            $("#saldoAtualContaDestino").html("Saldo: R$ <span style='font-weight: bolder;' >"+data.rows.saldo+" </span> ");
                        }else{
                            $("#saldoAtualContaDestino").html("Saldo: R$ <span style='font-weight: bolder;' >"+data.rows.saldo+" </span> ");                            
                        }
                    }
                }            
            }, "json"
        );        
    }else{
        $("#saldoAtualContaDestino").html("");
    }
    
}


//para o autocomplete
var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, não encontrado!'},
    '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
//para o autocomplete