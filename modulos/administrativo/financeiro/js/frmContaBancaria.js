// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/financeiro/controladores/ContaBancariaControlador.php";
var dg           = $('#grid');

// inicialização
function init(){
    // tabs
    $('#tabs').tabs();
    
    $("#txtDataAbertura").mask("99/99/9999"); 
    $("#txtDataAbertura").datepicker(); 
    
    $('#txtSaldoInicial').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
    $("#txtAgencia").alphanumeric();
    $("#txtConta").alphanumeric({allow: '-'});
     
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
        var bancoID           = $("#selPesquisaBanco").val();
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();    
        var pesquisaStatus    = $("#selPesquisaStatus").val();    

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }  
        
        var params = {
            ACO_Descricao: "Consultar", 
                BAN_ID: bancoID, 
                COB_Descricao: pesquisaDescricao,
                COB_Status: pesquisaStatus,
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
                        $("#hddID").val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML);
                                              
                        $.post(controlador, {
                            ACO_Descricao: "Consultar",
                            COB_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                    
                                    $("#txtDescricao").val(data.rows[0].COB_Descricao);
                                    $("#selBanco").val(data.rows[0].BAN_ID);
                                    $("#selBanco").trigger('chosen:updated');
                                    
                                    $("#txtAgencia").val(data.rows[0].COB_Agencia);
                                    $("#txtConta").val(data.rows[0].COB_Conta);
                                    $("#txtDataAbertura").val(data.rows[0].COB_DataAbertura);
                                    
                                    $("#txtSaldoInicial").val(data.rows[0].COB_SaldoInicial);
                                    $("#txtObservacao").val(data.rows[0].COB_Observacao);
                                    
                                    if(data.rows[0].COB_Status == "I"){ 
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
            name: 'COB_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'COB_Descricao', title: 'Descrição', width: 440, align: 'left'
        },{
            name: 'BAN_Descricao', title: 'Banco', width: 150, align: 'left'
        },{
            name: 'COB_Agencia', title: 'Agência', width: 150, align: 'left'
        },{
            name: 'COB_Conta', title: 'Conta', width: 150, align: 'left'
        },{
            name: 'COB_SaldoInicial', title: 'Saldo Inicial (R$)', width: 80, align: 'center'
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
        $("#dialog-atencao").html("Por favor, informe a descrição da conta bancária.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selBanco').val()) == ""){        
        $("#hddFocus").val("selBanco");
        $("#dialog-atencao").html("Por favor, selecione um banco.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#txtAgencia').val()) == ""){        
        $("#hddFocus").val("txtAgencia");
        $("#dialog-atencao").html("Por favor, informe a agência.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#txtConta').val()) == ""){        
        $("#hddFocus").val("txtConta");
        $("#dialog-atencao").html("Por favor, informe o número da conta.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#txtSaldoInicial').val()) == ""){        
        $("#hddFocus").val("txtSaldoInicial");
        $("#dialog-atencao").html("Por favor, informe o saldo inicial.");
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
    $("#txtDescricao").val("");    
    $("#selBanco").val("");
    $("#selBanco").trigger('chosen:updated');
    $("#selPlanoConta").val("");
    $("#selPlanoConta").trigger('chosen:updated');
    $("#txtAgencia").val("");
    $("#txtConta").val("");
    $("#txtDataAbertura").val("");
    
    $("#txtSaldoInicial").val("0,00");
    $("#txtObservacao").val("");
    
    $("#ckbStatus").prop("checked", false);
    
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
        COB_ID: ids
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