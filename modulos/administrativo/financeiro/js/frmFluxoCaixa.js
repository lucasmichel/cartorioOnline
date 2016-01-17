// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/financeiro/controladores/FluxoCaixaControlador.php";
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
    
    gerenciarTipoOrigem();
    gerenciarTipoOrigemPesquisa();
    
    // carrega os select's
    //getPlanoContasDinamico();
    //getContasBancariasDinamico();   
    //getCentroCustoDinamico();    
    //getFormaPagamentoDinamico();    
}

function gerenciarTipoOrigem(){
    var tipo = $('input:radio[name=LCA_TipoOrigem]:checked').val();
    
    if(tipo == "F"){
        $("#fieldsetPessoa").hide();
        $("#fieldsetFornecedor").show();
        $("#selOrigemFornecedor").val("");
        $("#selOrigemFornecedor").trigger('chosen:updated');
        
        getFornecedorDinamico();
    }else{
        $("#fieldsetPessoa").show();
        $("#fieldsetFornecedor").hide();
        $("#selOrigemPessoa").val("");
        $("#selOrigemPessoa").trigger('chosen:updated');
        
        getPessoaDinamico();
    }
}

function gerenciarTipoOrigemPesquisa(){
    var tipo = $('input:radio[name=LCA_OrigemPesquisa]:checked').val();
    
    if(tipo == "F"){
        $("#colunaPesquisaPessoa").hide();
        $("#colunaPesquisaFornecedor").show();
        $("#selPesquisaFornecedor").val("");
        $("#selPesquisaFornecedor").trigger('chosen:updated');
        
        getFornecedorDinamico();
    }else{
        $("#colunaPesquisaFornecedor").hide();
        $("#colunaPesquisaPessoa").show();        
        $("#selPesquisaPessoa").val("");
        $("#selPesquisaPessoa").trigger('chosen:updated');
        
        getPessoaDinamico();
    }
}

function gerenciarTipoMovimentacao(){
    var tipoOrigem = $('input:radio[name=LCA_TipoOrigem]:checked').val();
    
    if($("#selTipo").val() == "E"){        
        if(tipoOrigem == "P"){            
            $("#labelOrigemPessoa").html("Origem*");
        }else{
            $("#labelOrigemFornecedor").html("Origem*");
        }
    }else{        
        if(tipoOrigem == "P"){
            $("#labelOrigemPessoa").html("Destino*");
        }else{
            $("#labelOrigemFornecedor").html("Destino*");
        }
    }
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
        LCA_ID: ids
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
        var limitConsulta       = 20; // limit padrão     
        var pesquisaEntidade    = "";   
        var pesquisaTipoMov     = $("#selPesquisaTipoMovimento").val();
        var pesquisaDataInicial = $("#txtPesquisaDataInicial").val();    
        var pesquisaDataFinal   = $("#txtPesquisaDataFinal").val();
        var pesquisaCentroCusto = $("#selPesquisaCentroCusto").val();
        var pesquisaPlanoConta  = $("#selPesquisaPlanoConta").val();

        var pesquisaTipoEntidade = $('input:radio[name=LCA_OrigemPesquisa]:checked').val();

        if(pesquisaTipoEntidade == "P"){
            pesquisaEntidade = $("#selPesquisaPessoa").val();
        }else{
            pesquisaEntidade = $("#selPesquisaFornecedor").val();
        }
        
        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }   
        
        var params = {
            ACO_Descricao: "Consultar", 
            LCA_TipoEntidade: pesquisaTipoEntidade, 
            LCA_EntidadeID: pesquisaEntidade,       
            LCA_Tipo: pesquisaTipoMov,
            LCA_DataInicial: pesquisaDataInicial,
            LCA_DataFinal: pesquisaDataFinal,
            CEN_ID: pesquisaCentroCusto,
            PLA_ID: pesquisaPlanoConta,
            limit: limitConsulta,
            offset: 0
        };
        
        // Cálculo total das ofertas e dos dizimos no período     
        $.post(controlador, params,
            function(data) {   
                if(data.sucesso == "true"){
                    $("#spnTotal").html(data.totalLancamentos);
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
                            LCA_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){    
                                    $("#selTipo").val(data.rows[0].LCA_Tipo);    
                                    $('#selTipo').trigger('chosen:updated');
                                    
                                    $("#selCentroCusto").val(data.rows[0].CEN_ID);    
                                    $('#selCentroCusto').trigger('chosen:updated');
                                    
                                    $("#selContaBancaria").val(data.rows[0].LCA_ID);    
                                    $('#selContaBancaria').trigger('chosen:updated');
                                    
                                    if($.trim(data.rows[0].PES_ID) != ""){
                                        $("#rdbPessoa").prop("checked", true);
                                        $("#rdbFornecedor").prop("checked", false);
                                        gerenciarTipoOrigem();
                                        
                                        $("#selOrigemPessoa").val(data.rows[0].PES_ID);    
                                        $('#selOrigemPessoa').trigger('chosen:updated'); 
                                    }else{
                                        if($.trim(data.rows[0].FOR_ID) != ""){
                                            $("#rdbPessoa").prop("checked", false);
                                            $("#rdbFornecedor").prop("checked", true);
                                            gerenciarTipoOrigem();

                                            $("#selOrigemFornecedor").val(data.rows[0].FOR_ID);    
                                            $('#selOrigemFornecedor').trigger('chosen:updated'); 
                                        }
                                    }
                                    
                                    $("#txtData").val(data.rows[0].LCA_DataMovimento); 
                                    
                                    $("#selReferencia").val(data.rows[0].LCA_Referencia); 
                                    $('#selReferencia').trigger('chosen:updated');
                                    
                                    $("#txtValor").val(data.rows[0].LCA_Valor);
                                    
                                    $("#selFormaPagamento").val(data.rows[0].FPG_ID);    
                                    $('#selFormaPagamento').trigger('chosen:updated');   
                                    
                                    $("#selPlanoConta").val(data.rows[0].PLA_ID);    
                                    $('#selPlanoConta').trigger('chosen:updated');                                        
                                    
                                    $("#txtAnotacao").val(data.rows[0].LCA_Observacao);
                                    $("#txtHistorico").val(data.rows[0].LCA_Descricao);
                                                                        
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
            name: 'LCA_ID', title: 'C&oacute;d.', width: 60, align: 'left'
        },{
            name: 'LCA_DataMovimento', title: 'Data', width: 80, align: 'center'                
        },{
            name: 'LCA_Referencia', title: 'Referente a', width: 80, align: 'center'                
        },{
            name: 'LCA_Tipo', title: 'Tipo (E/S)', width: 80, align: 'center'                
        },{        
            name: 'PLA_Descricao', title: 'Opera&ccedil;&atilde;o (Plano de Contas)', width: 180, align: 'left'                
        },{        
            name: 'LCA_Valor', title: 'Valor (R$)', width: 80, align: 'right'                
        },{        
            name: 'LCA_Descricao', title: 'Hist&oacute;rio', width: 300, align: 'left'
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
    
    if($.trim($('#txtHistorico').val()) == ""){                
        $("#hddFocus").val("txtHistorico");
        $("#dialog-atencao").html("Por favor, informe o hist&oacute;rico.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    if($.trim($('#selContaBancaria').val()) == ""){                
        $("#hddFocus").val("selPlanoConta");
        $("#dialog-atencao").html("Por favor, informe a conta banc&aacute;ria.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    if($.trim($('#selCentroCusto').val()) == ""){                
        $("#hddFocus").val("selCentroCusto");
        $("#dialog-atencao").html("Por favor, informe o centro de custo.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    var tipoOrigem = $('input:radio[name=LCA_TipoOrigem]:checked').val();
    
    if(tipoOrigem == "P"){
        if($("#selOrigemPessoa").val() == ""){
            $("#hddFocus").val("selOrigemPessoa");
            
            if($("#selTipo").val() == "E"){
                $("#dialog-atencao").html("Por favor, informe a origem.");
            }else{
                $("#dialog-atencao").html("Por favor, informe o destino.");
            }
            
            $("#dialog-atencao").dialog("open");        
            return;
        }
    }else{
        if($("#selOrigemFornecedor").val() == ""){
            $("#hddFocus").val("selOrigemFornecedor");
            
            if($("#selTipo").val() == "E"){
                $("#dialog-atencao").html("Por favor, informe a origem.");
            }else{
                $("#dialog-atencao").html("Por favor, informe o destino.");
            }
            
            $("#dialog-atencao").dialog("open");        
            return;
        }        
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
    
    $("#selTipo").val("E");    
    $('#selTipo').trigger('chosen:updated');
    
    $("#txtDescricao").val("");
    
    //$('#tabs').tabs('option', 'active', 0);
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

function getFormaPagamentoDinamico(){
    $.ajax({
        type: "POST",
        url: controladorFormaPagamento,
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

function getPlanoContasDinamico(){
    $.ajax({
        type: "POST",
        url: controladorPlanoContas,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", PLA_Status: "A", PLA_Tipo: "A", PLA_Movimentacao: $("#selTipo").val()}
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
    preLoadingOpen("Carregando pessoas, aguarde...");
    
    $.ajax({
        type: "POST",
        url: controladorPessoa,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", PES_Status: "A"}
    })
    .done(function( data ) {   
        $("#selOrigemPessoa").html("<option value=''></option>");
        $("#selPesquisaPessoa").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].PES_ID + '">' + data.rows[i].PES_Nome + '</option>';
            }
            
            $("#selOrigemPessoa").append(html);
            $("#selOrigemPessoa").trigger('chosen:updated');
            
            $("#selPesquisaPessoa").append(html);
            $("#selPesquisaPessoa").trigger('chosen:updated');
        }
        
        preLoadingClose();
    });
}
function getFornecedorDinamico(){
    preLoadingOpen("Carregando fornecedores, aguarde...");
    
    $.ajax({
        type: "POST",
        url: controladorFornecedor,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", FOR_Status: "A"}
    })
    .done(function( data ) {        
        $("#selOrigemFornecedor").html("<option value=''></option>");
        $("#selPesquisaFornecedor").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].FOR_ID + '">' + data.rows[i].FOR_NomeFantasia + '</option>';
            }
            
            $("#selOrigemFornecedor").append(html);
            $("#selOrigemFornecedor").trigger('chosen:updated');
            
            $("#selPesquisaFornecedor").append(html);
            $("#selPesquisaFornecedor").trigger('chosen:updated');
        }
        
        preLoadingClose();
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