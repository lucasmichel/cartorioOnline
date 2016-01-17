// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/financeiro/controladores/ContribuicaoControlador.php";
var dg           = $('#grid');
    
// inicialização
function init(){
    // cria as tabs
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
       
    $('#txtData').mask("99/99/9999");
    $('#txtData').datepicker();  
    
    $('#txtPesquisaDataInicial').mask("99/99/9999");
    $('#txtPesquisaDataInicial').datepicker();  
    $('#txtPesquisaDataFinal').mask("99/99/9999");
    $('#txtPesquisaDataFinal').datepicker();  
    
    
    $('#txtValor').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    }); 
       
    // carrega o grid
    initGRID();
    consultar(); 
    
    // adicionar
    /*getFormaPagamentoDinamico();
    getCentroCustoDinamico();
    getPlanoContasDinamico();
    getPessoaDinamico();
    getContasBancariasDinamico();*/
}

function excluir(){
    var acaoExecutada = "Excluir"; 
 
    // ### PERMISSAO ###
    var data = checarPermissao("ChecarPermissao", formularioID, acaoExecutada);
        console.log(data);
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
        CTB_ID: ids
    },
        function(data) {  
            if(data.sucesso == "true"){
                $("#dialog-excluir").dialog("close");

                $("#dialog-sucesso").html(data.mensagem);        
                $("#dialog-sucesso").dialog("open");  
            }
        }, "json"
    );
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
        var pesquisaPessoa    = $("#selPesquisaPessoa").val();    
        var pesquisaDataInicial    = $("#txtPesquisaDataInicial").val();    
        var pesquisaDataFinal    = $("#txtPesquisaDataFinal").val();
        var pesquisaCentroCusto    = $("#selPesquisaCentroCusto").val();
        var pesquisaPlanoConta    = $("#selPesquisaPlanoConta").val();
        var pesquisaLote    = $("#selPesquisaLote").val();

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }   
        
        var params = {
            ACO_Descricao: "Consultar", 
            PES_ID: pesquisaPessoa,                
            CTB_DataInicial: pesquisaDataInicial,
            CTB_DataFinal: pesquisaDataFinal,
            CEN_ID: pesquisaCentroCusto,
            PLA_ID: pesquisaPlanoConta,
            LOT_ID: pesquisaLote,
            limit: limitConsulta,
            offset: 0
        };
        
        // Cálculo total das ofertas e dos dizimos no período     
        $.post(controlador, params,
            function(data) {   
                if(data.sucesso == "true"){
                    $("#spnTotal").html(data.totalContribuicoes);
                }else{
                    $("#spnTotal").html("0,00");
                }
            }, "json"
        );
        
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
        ,uniqueRow: true
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
                            CTB_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                      
                                    $("#selCentroCusto").val(data.rows[0].CEN_ID);    
                                    $('#selCentroCusto').trigger('chosen:updated');
                                    
                                    $("#selContaBancaria").val(data.rows[0].COB_ID);    
                                    $('#selContaBancaria').trigger('chosen:updated');
                                    
                                    $("#selPessoa").val(data.rows[0].PES_ID);    
                                    $('#selPessoa').trigger('chosen:updated'); 
                                    
                                    $("#txtData").val(data.rows[0].CTB_DataContribuicao); 
                                    
                                    $("#selReferencia").val(data.rows[0].CTB_Referencia); 
                                    $('#selReferencia').trigger('chosen:updated');
                                    
                                    $("#txtValor").val(data.rows[0].CTB_Valor);
                                    
                                    $("#selFormaPagamento").val(data.rows[0].FPG_ID);    
                                    $('#selFormaPagamento').trigger('chosen:updated');   
                                    
                                    $("#selPlanoConta").val(data.rows[0].PLA_ID);    
                                    $('#selPlanoConta').trigger('chosen:updated');
                                    
                                    $("#selLote").val(data.rows[0].LOT_ID);    
                                    $('#selLote').trigger('chosen:updated');
                                    
                                    $("#txtAnotacao").val(data.rows[0].CTB_Observacao);
                                                                        
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
            name: 'CTB_ID', title: 'C&oacute;d.', width: 60, align: 'left'
        },{
            name: 'CTB_DataContribuicao', title: 'Data', width: 80, align: 'center'                
        },{
            name: 'CTB_Referencia', title: 'Referente a', width: 80, align: 'center'                
        },{        
            name: 'PLA_Descricao', title: 'Tipo Contribui&ccedil;&atilde;o', width: 180, align: 'left'                
        },{        
            name: 'CTB_Valor', title: 'Valor (R$)', width: 80, align: 'right'                
        },{        
            name: 'PES_Nome', title: 'Origem', width: 380, align: 'left', render: function(d) {
                var nome;
                
                if(d == ""){
                    nome = "N/I";
                }else{
                    if(d == null){
                        nome = "N/I";
                    }else{
                        nome = d;
                    }
                }
                
                return nome;
            }                
        },{        
            name: 'CEN_Descricao', title: 'Centro de Custo', width: 200, align: 'left'
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
    
    /*if($.trim($('#selMembro').val()) == ""){                
        $("#hddFocus").val("selMembro");
        $("#dialog-atencao").html("Por favor, informe o membro.");
        $("#dialog-atencao").dialog("open");        
        return;
    }*/
    
    if($.trim($('#txtData').val()) == ""){                
        $("#hddFocus").val("txtData");
        $("#dialog-atencao").html("Por favor, informe uma data.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    if(!isDataValida($.trim($('#txtData').val()))){                        
        $("#hddFocus").val("txtData");
        $("#dialog-atencao").html("Por favor, informe uma data v&aacute;lida.");
        $("#dialog-atencao").dialog("open");        
        return;
    }    
   
    if($.trim($('#txtValor').val()) == "" || $.trim($('#txtValor').val()) == "0,00"){
        $("#hddFocus").val("txtValor");
        $("#dialog-atencao").html("Por favor, informe o valor.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    if($.trim($('#selPlanoConta').val()) == ""){                
        $("#hddFocus").val("selPlanoConta");
        $("#dialog-atencao").html("Por favor, informe o plano de contas.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    if($.trim($('#selContaBancaria').val()) == ""){                
        $("#hddFocus").val("selPlanoConta");
        $("#dialog-atencao").html("Por favor, informe a conta banc�ria.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    if($.trim($('#selCentroCusto').val()) == ""){                
        $("#hddFocus").val("selCentroCusto");
        $("#dialog-atencao").html("Por favor, informe o centro de custo.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    if($.trim($('#selFormaPagamento').val()) == ""){                
        $("#hddFocus").val("selFormaPagamento");
        $("#dialog-atencao").html("Por favor, informe a forma de pagamento.");
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
    $("#selPessoa").val("");    
    $('#selPessoa').trigger('chosen:updated');  
    
    $("#txtData").val("");    
    $("#txtValor").val("0,00");
    
    $("#selFormaPagamento").val("");    
    $('#selFormaPagamento').trigger('chosen:updated');   
    
    $("#selContaBancaria").val("");    
    $('#selContaBancaria').trigger('chosen:updated');   
    
    $("#selCentroCusto").val("");    
    $('#selCentroCusto').trigger('chosen:updated'); 
    
    $("#selPlanoConta").val("");    
    $('#selPlanoConta').trigger('chosen:updated'); 
    
    $("#selLote").val("");    
    $('#selLote').trigger('chosen:updated'); 
    
    $("#txtAnotacao").val("");  
        
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "ReferenciaAtual"}
    })
    .done(function( data ) {
        $("#selReferencia").val(data.referenciaAtual);  
        $('#selReferencia').trigger('chosen:updated');
    });
       
    $('#tabs').tabs('option', 'active', 0);
}

// adicionar
// ao incluir o arquivo adicionarFormaPagamento.inc.php, esta função deverá ser implementada
// ela é responsável por manter atualizado o SELECT 
function getFormaPagamentoDinamico(){
    $.ajax({
        type: "POST",
        url: controladorFormaPagamento, // controlador criado no arquivo adicionarFormaPagamento.inc.php
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", CEN_Status: "A"}
    })
    .done(function( data ) {        
        $("#selFormaPagamento").html("<option value=''></option>");

        if(data.sucesso == "true"){            
            var html = '';

            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].FPG_ID + '">' + data.rows[i].FPG_Descricao + '</option>';
            }

            $("#selFormaPagamento").append(html);
            $("#selFormaPagamento").trigger('chosen:updated');
        }
    });
}

// centro de custo
function getCentroCustoDinamico(){
    $.ajax({
        type: "POST",
        url: controladorCentroCusto,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", CEN_Status: "A"}
    })
    .done(function( data ) {        
        $("#selCentroCusto").html("<option value=''></option>");
        $("#selPesquisaCentroCusto").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].CEN_ID + '">' + data.rows[i].CEN_Descricao + '</option>';
            }
            
            $("#selCentroCusto").append(html);
            $("#selCentroCusto").trigger('chosen:updated');
            
            $("#selPesquisaCentroCusto").append(html);
            $("#selPesquisaCentroCusto").trigger('chosen:updated');
        }
    });
}
function getContasBancariasDinamico(){
    $.ajax({
        type: "POST",
        url: controladorContaBancaria,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", COB_Status: "A"}
    })
    .done(function( data ) {        
        $("#selContaBancaria").html("<option value=''></option>");
        $("#selPesquisaContaBancaria").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].COB_ID + '">' + data.rows[i].COB_Descricao + '</option>';
            }
            
            $("#selContaBancaria").append(html);
            $("#selContaBancaria").trigger('chosen:updated');
            
            $("#selPesquisaContaBancaria").append(html);
            $("#selPesquisaContaBancaria").trigger('chosen:updated');
        }
    });
}
function getPessoaDinamico(){    
    $.ajax({
        type: "POST",
        url: controladorPessoa,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", PES_Status: "A"}
    })
    .done(function( data ) {   
        $("#selPessoa").html("<option value=''>NÃO IDENTIFICADO</option>");
        $("#selPesquisaPessoa").html("<option value=''></option><option value='N/I'>NÃO IDENTIFICADO</option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].PES_ID + '">' + data.rows[i].PES_Nome + '</option>';
            }
            
            $("#selPessoa").append(html);
            $("#selPessoa").trigger('chosen:updated');
            
            $("#selPesquisaPessoa").append(html);
            $("#selPesquisaPessoa").trigger('chosen:updated');
        }
    });
}
function getPlanoContasDinamico(){
    $.ajax({
        type: "POST",
        url: controladorPlanoContas,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", PLA_Status: "A", PLA_Tipo: "A", PLA_Movimentacao: "E"}
    })
    .done(function( data ) {        
        $("#selPlanoConta").html("<option value=''></option>");
        $("#selPesquisaPlanoConta").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].PLA_ID + '">' + data.rows[i].PLA_CodigoContabil + " - " + data.rows[i].PLA_Descricao + '</option>';
            }
            
            $("#selPlanoConta").append(html);
            $("#selPlanoConta").trigger('chosen:updated');
            
            $("#selPesquisaPlanoConta").append(html);
            $("#selPesquisaPlanoConta").trigger('chosen:updated');
        }
    });
}



function getLoteDinamico(){
    $.ajax({
        type: "POST",
        url: controladorLote,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar" }
    })
    .done(function( data ) {        
        $("#selLote").html("<option value=''></option>");
        $("#selLote").trigger('chosen:updated');        
        $("#selPesquisaLote").html("<option value=''></option>");
        $("#selPesquisaLote").trigger('chosen:updated');
        if(data.sucesso == "true"){            
            var html = '';            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].LOT_ID + '">'+ data.rows[i].LOT_Descricao + '</option>';
            }            
            $("#selLote").append(html);
            $("#selLote").trigger('chosen:updated');
            $("#selPesquisaLote").append(html);
            $("#selPesquisaLote").trigger('chosen:updated');
        }
    });
}

//para o autocomplete
var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Ops, n&atilde;o encontrado!'},
    '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
//para o autocomplete