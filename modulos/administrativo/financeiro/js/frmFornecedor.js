// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/financeiro/controladores/FornecedorControlador.php";
var dg           = $('#grid');

// inicialização
function init(){
    // tabs
    $('#tabs').tabs();     
    $('#tabs-dados').tabs();
     
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
    
    $("#txtTelefone").mask("(99)9999.9999");    
    $("#txtDataFundacao").mask("99/99/9999");  
    $("#txtDataFundacao").datepicker();
    $("#txtCNPJ").mask("99.999.999/9999-99");    
    $('#txtEnderecoCEP').mask("99999-999");
    
    $('#txtFone').mask("(99) 9999.9999");
    $('#txtFoneEdicao').mask("(99) 9999.9999");
    $('#txtEmail').alphanumeric({allow:"._-@"});
    $('#txtEmailEdicao').alphanumeric({allow:"._-@"});
    
   
    $("#selPesquisaFiltro").change(function() {
        if($("#selPesquisaFiltro").val()== "CNPJ"){            
            $("#txtPesquisaDescricao").mask("99.999.999/9999-99");
        }
        
        if($("#selPesquisaFiltro").val()== "CPF"){
            $("#txtPesquisaDescricao").mask("999.999.999-99");
        }
        
        if($("#selPesquisaFiltro").val()== ""){
            $("#txtPesquisaDescricao").unmask();
        }
    });
    
    
    
    $("#dialog-editar-fone").dialog({
        autoOpen: false,
        width:450,
        buttons: {
            "Atualizar": function() {                         
                executarEditarFone();
            }
        }
    });
    
    $("#dialog-editar-email").dialog({
        autoOpen: false,        
        buttons: {
            "Atualizar": function() {                         
                executarEditarEmail();
            }
        }
    });
    
    // carrega o grid
    initGRID();
    consultar();
    getMembroDinamico();
    exibirMembro();
    
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
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();    
        var pesquisaStatus    = $("#selPesquisaStatus").val();  
        var pesquisaFiltro    = $("#selPesquisaFiltro").val();    
        
        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        } 
        
        var params = {
            ACO_Descricao: "Consultar", 
            FOR_PesquisaDescricao: pesquisaDescricao,
            FOR_Status: pesquisaStatus,
            FOR_PesquisaFiltro: pesquisaFiltro,
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
                            FOR_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){ 
                                    
                                    preencherDadosFornecedorTelefoneEmail(data.rows[0].FOR_ID);
                                    
                                    if(data.rows[0].PES_ID > 0){ 
                                        var txt = "<option value="+data.rows[0].PES_ID+">"+data.rows[0].FOR_NomeFantasia+"</option>";                                        
                                        $("#selMembro").append(txt);
                                        $("#selMembro").val(data.rows[0].PES_ID);
                                        $("#selMembro").trigger('chosen:updated');
                                        $("#ckbMembro").prop("checked", true);
                                        preencheDadosMembro("alteracao");                                        
                                        exibirMembro();
                                        
                                    }else{
                                        if(data.rows[0].FOR_Tipo == "PF"){ 
                                            $("#ckbTipo").prop("checked", true);                                        
                                            $("#ckbTipo").trigger("onclick");
                                        }  
                                    }
                                    
                                    
                                    
                                    $("#hddID").val(data.rows[0].FOR_ID);
                                    $("#txtNomeFantasia").val(data.rows[0].FOR_NomeFantasia);                                        
                                    $("#txtRazaoSocial").val(data.rows[0].FOR_RazaoSocial);                                        
                                    $("#txtInscricaoEstadual").val(data.rows[0].FOR_InscricaoEstadual);                                    
                                    $("#txtCNPJ").val(data.rows[0].FOR_CNPJ);                                        
                                    $("#txtDataFundacao").val(data.rows[0].FOR_DataFundacao);                                    
                                    $("#txtRamoAtividade").val(data.rows[0].FOR_RamoAtividade);                                    
                                    $("#selBanco").val(data.rows[0].BAN_ID); 
                                    $("#selBanco").trigger('chosen:updated');
                                    $("#txtAgencia").val(data.rows[0].FOR_Agencia);                                    
                                    $("#txtConta").val(data.rows[0].FOR_Conta);                                    
                                    $("#txtEnderecoCEP").val(data.rows[0].FOR_EnderecoCep);
                                    $("#txtSite").val(data.rows[0].FOR_Site);
                                    $("#txtObservacao").val(data.rows[0].FOR_Observacao);
                                    $("#txtEmail").val(data.rows[0].FOR_Email);                                    
                                    $("#txtTelefone").val(data.rows[0].FOR_Telefone);                                    
                                    $("#txtEnderecoLogradouro").val(data.rows[0].FOR_EnderecoLogradouro);
                                    $("#txtEnderecoNumero").val(data.rows[0].FOR_EnderecoNumero);
                                    $("#txtEnderecoComplemento").val(data.rows[0].FOR_EnderecoComplemento);
                                    $("#txtEnderecoBairro").val(data.rows[0].FOR_EnderecoBairro);
                                    $("#txtEnderecoCidade").val(data.rows[0].FOR_EnderecoCidade);                                  
                                    $("#selEnderecoUF").val(data.rows[0].FOR_EnderecoUf);                                    
                                    $("#txtEnderecoPontoReferencia").val(data.rows[0].FOR_EnderecoPontoReferencia);                                    
                                    if(data.rows[0].FOR_Status == "I"){ 
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
            name: 'FOR_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'FOR_NomeFantasia', title: 'Nome/Nome Fantasia', width: 200, align: 'left'
        },{        
            name: 'FOR_CNPJ', title: 'CPF/CNPJ', width: 120, align: 'center'            
        },{
            name: 'FOR_Tipo', title: 'Tipo', width: 40, align: 'center'
        },{
            name: 'FOR_Telefone', title: 'Telefone', width: 80, align: 'left'
        },{
            name: 'FOR_Email', title: 'Email', width: 200, align: 'left'
        },{
            name: 'BAN_Descricao', title: 'Banco', width: 140, align: 'left'
        },{
            name: 'FOR_Agencia', title: 'Ag&ecirc;ncia', width: 60, align: 'left'
        },{
            name: 'FOR_Conta', title: 'Conta', width: 85, align: 'left'
        },{
            name: 'FOR_Status', title: 'Ativo', width: 60, align: 'center', render: function(d) {
                var status = 'SIM';
                
                if(d == "N"){
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
    
    if($.trim($('#txtNomeFantasia').val()) == ""){        
        $("#hddFocus").val("txtNomeFantasia");
        $("#dialog-atencao").html("Por favor, informe o nome.");
        $("#dialog-atencao").dialog("open");
        return;
    }    
    
    if(($.trim($('#txtCNPJ').val()) != "")){
        if($("#ckbTipo").is(":checked")){
            if(!isCPFValido($('#txtCNPJ').val())){
                $("#hddFocus").val("txtCNPJ");
                $("#dialog-atencao").html("Por favor, informe um CPF v&aacute;lido.");        
                $("#dialog-atencao").dialog("open");
                return;
            }
        }else{
            if(!isCNPJValido($('#txtCNPJ').val())){
                $("#hddFocus").val("txtCNPJ");
                $("#dialog-atencao").html("Por favor, informe um CNPJ v&aacute;lido.");        
                $("#dialog-atencao").dialog("open");
                return;
            }    
        }
    }
    
    if($.trim($('#txtEmail').val()) != ""){
        if(!isEmail($('#txtEmail').val())){
            $("#hddFocus").val("txtEmail");
            $("#dialog-atencao").html("Por favor, informe um email v&aacute;lido.");        
            $("#dialog-atencao").dialog("open");
            return;
        }
    }

    reabilitaCamposMembroSalvar();
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
    $("#txtNomeFantasia").val("");    
    $("#txtRazaoSocial").val("");    
    $("#txtInscricaoEstadual").val("");
    $("#txtCNPJ").val("");    
    $("#txtDataFundacao").val("");
    $("#txtRamoAtividade").val("");
    $("#selBanco").val("");
    $("#txtAgencia").val("");
    $("#txtConta").val("");
    $("#txtEnderecoCEP").val("");
    $("#txtEnderecoLogradouro").val("");
    $("#txtEnderecoNumero").val("");
    $("#txtEnderecoComplemento").val("");
    $("#txtEnderecoBairro").val("");
    $("#txtEnderecoCidade").val("");
    $("#txtSite").val("");
    $("#txtObservacao").val("");
    $("#txtEmail").val("");
    $("#txtTelefone").val("");
    $("#txtEnderecoPontoReferencia").val("");
    $("#selEnderecoUF").val("");
    $("#ckbStatus").prop("checked", false);
    $("#ckbTipo").prop("checked", false);
    $("#ckbMembro").prop("checked", false);
    $("#selBanco").val("");
    $('#selBanco').trigger('chosen:updated');
    getMembroDinamico();
    limparDadosMembro();
    exibirMembro();
    $('#tabs-dados').tabs('option', 'active', 0);
    $('#tabs').tabs('option', 'active', 0);
}

function verificaTipoPessoa(){    
    if($('#ckbTipo').is(':checked')) {         
        $("#labNomeFantasiaLabel").html("Nome*");  
        $("#labRazaoSocial").html("");  
        $("#txtRazaoSocial").hide();
        $("#txtRazaoSocial").val("");
        $("#labInscricaoEstadual").html("RG"); 
        $("#fieldsetDataFundacao").hide();
        
        $("#labCNPJ").html("CPF");
        $("#txtCNPJ").unmask();
        $("#txtCNPJ").mask("999.999.999-99");        
    }else{
        $("#labNomeFantasiaLabel").html("Nome Fantasia*");   
        $("#txtRazaoSocial").show();
        $("#labRazaoSocial").html("Raz&atilde;o Social");  
        $("#labInscricaoEstadual").html("Inscri&ccedil;&atilde;o Estadual");  
        $("#fieldsetDataFundacao").show();
        
        $("#labCNPJ").html("CNPJ");
        $("#txtCNPJ").unmask();
        $("#txtCNPJ").mask("99.999.999/9999-99");        
    } 
}

function consultarEndereco(){
    var objEnderecoCampos = {
        campoCep: "txtEnderecoCEP",
        campoLogradouro: "txtEnderecoLogradouro",
        campoBairro: "txtEnderecoBairro",
        campoCidade: {id: "txtEnderecoCidade", isSelect: false},
        campoUf: "selEnderecoUF",
        spanPreLoading: "spnCarregandoCEP"
    };
   consultarCEP(objEnderecoCampos);
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
        FOR_ID: ids
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




function exibirMembro(){ 
    if ($("#ckbMembro").prop("checked")){
        $("#divMembro").show(); 
        $("#ckbTipo").prop("checked", true);
        $("#ckbTipo").trigger("onclick");
        $("#ckbTipo").prop("disabled", true);
    }else{        
        $("#divMembro").hide();        
        $("#ckbTipo").prop("checked", false);
        $("#ckbTipo").trigger("onclick");
        $("#ckbTipo").prop("disabled", false);
        $("#selMembro").val("");
        $('#selMembro').trigger('chosen:updated');
        limparDadosMembro();
    }
}



function preencheDadosMembro(tipo){    
    var idPessoa = $("#selMembro").val();  
        $.post("../../administrativo/cadastro/controladores/MembroControlador.php", {
        ACO_Descricao: "Consultar",        
        PES_ID: idPessoa
    },
        function(data) {            
            if(data.sucesso == "true"){                
                if(!tipo){
                    preencherDadosMembroTelefoneEmail(idPessoa);
                }
                $("#txtNomeFantasia").val(data.rows[0].PES_Nome);    
                $("#txtNomeFantasia").prop("disabled", true); 
                
                $("#txtCNPJ").val(data.rows[0].PES_CPF);
                $("#txtCNPJ").prop("disabled", true);
                
                $("#txtInscricaoEstadual").val(data.rows[0].PES_RG);
                $("#txtInscricaoEstadual").prop("disabled", true);
                
                $("#txtObservacao").val(data.rows[0].PES_Observacao);
                
                
                $("#txtEnderecoCEP").val(data.rows[0].PES_EnderecoCep);
                $("#txtEnderecoCEP").prop("disabled", true);
                $("#btConsultarCep").hide();
                
                $("#txtEnderecoLogradouro").val(data.rows[0].PES_EnderecoLogradouro);
                $("#txtEnderecoLogradouro").prop("disabled", true);
                
                $("#txtEnderecoNumero").val(data.rows[0].PES_EnderecoNumero);
                $("#txtEnderecoNumero").prop("disabled", true);
                
                $("#txtEnderecoComplemento").val(data.rows[0].PES_EnderecoComplemento);
                $("#txtEnderecoComplemento").prop("disabled", true);
                
                $("#txtEnderecoPontoReferencia").val(data.rows[0].PES_EnderecoPontoReferencia);
                $("#txtEnderecoPontoReferencia").prop("disabled", true);
                
                $("#txtEnderecoBairro").val(data.rows[0].PES_EnderecoBairro);
                $("#txtEnderecoBairro").prop("disabled", true);
                
                $("#txtEnderecoCidade").val(data.rows[0].PES_EnderecoCidade);
                $("#txtEnderecoCidade").prop("disabled", true);
                
                $("#selEnderecoUF").val(data.rows[0].PES_EnderecoUf);
                $("#selEnderecoUF").prop("disabled", true);                
                getEmailFoneMembro();
                
            }
        }, "json"
    );
    return;
}

function preencherDadosMembroTelefoneEmail(pessoaID){
    // e-mails
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionEmailsMembro", PES_ID: pessoaID}
    })
    .done(function( data ) {        
        if(data.sucesso == "true"){                    
            listarEmail();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
    // telefones
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionFoneMembro", PES_ID: pessoaID}
    })
    .done(function( data ) {        
        if(data.sucesso == "true"){                    
            listarFone();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
}




function limparDadosMembro(){
    $("#txtNomeFantasia").val("");    
    $("#txtNomeFantasia").prop("disabled", false); 

    $("#txtCNPJ").val("");
    $("#txtCNPJ").prop("disabled", false);

    $("#txtInscricaoEstadual").val("");
    $("#txtInscricaoEstadual").prop("disabled", false);

    $("#txtObservacao").val("");


    $("#txtEnderecoCEP").val("");
    $("#txtEnderecoCEP").prop("disabled", false);
    $("#btConsultarCep").show();

    $("#txtEnderecoLogradouro").val("");
    $("#txtEnderecoLogradouro").prop("disabled", false);

    $("#txtEnderecoNumero").val("");
    $("#txtEnderecoNumero").prop("disabled", false);

    $("#txtEnderecoComplemento").val("");
    $("#txtEnderecoComplemento").prop("disabled", false);

    $("#txtEnderecoPontoReferencia").val("");
    $("#txtEnderecoPontoReferencia").prop("disabled", false);

    $("#txtEnderecoBairro").val("");
    $("#txtEnderecoBairro").prop("disabled", false);

    $("#txtEnderecoCidade").val("");
    $("#txtEnderecoCidade").prop("disabled", false);

    $("#selEnderecoUF").val("");
    $("#selEnderecoUF").prop("disabled", false);
    
    limparEmail();
    limparFone();
    
}

function reabilitaCamposMembroSalvar(){
    $("#ckbTipo").prop("disabled", false);     
    $("#txtNomeFantasia").prop("disabled", false); 
    $("#txtCNPJ").prop("disabled", false);
    $("#txtInscricaoEstadual").prop("disabled", false);
    $("#txtEnderecoCEP").prop("disabled", false);
    $("#txtEnderecoLogradouro").prop("disabled", false);
    $("#txtEnderecoNumero").prop("disabled", false);
    $("#txtEnderecoComplemento").prop("disabled", false);
    $("#txtEnderecoPontoReferencia").prop("disabled", false);
    $("#txtEnderecoBairro").prop("disabled", false);
    $("#txtEnderecoCidade").prop("disabled", false);
    $("#selEnderecoUF").prop("disabled", false);
}

function getMembroDinamico(){      
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/MembroControlador.php",
        dataType: "json",
        async: true,
        data: {ACO_Descricao: "Consultar", PES_Status: "A", MembroNaoFornecedor: true, MES_ID:1}
    })
    .done(function( data ) {       
        $("#selMembro").html("<option value=''></option>");        
        if(data.sucesso == "true"){            
            var html = '';            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].PES_ID + '">' + data.rows[i].PES_Nome + '</option>';
            }
            $("#selMembro").append(html);
            $("#selMembro").trigger('chosen:updated');
        }        
    });
}

function getEmailFoneMembro(){
    var idPessoa = $("#selMembro").val();
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: true,
        data: {ACO_Descricao: "ConsultarEmailFoneMembro", PES_ID: idPessoa }
    })
    .done(function(data) {        
        if(data.sucesso == "true"){            
            $("#txtEmail").val(data.dados.email);
            $("#txtTelefone").val(data.dados.fone);
        }        
    });
}












function adicionarFone(){
    var TEL_Operadora   = $("#selOperadora").val();    
    var TEL_Numero      = $("#txtFone").val();
    var TEL_NomeContato = $("#txtResponsavel").val();    
    
    if($.trim(TEL_Numero) == ""){        
        $("#hddFocus").val("txtFone");
        $("#dialog-atencao").html("Por favor, informe o telefone do contato.");
        $("#dialog-atencao").dialog("open");
        return;
    }     
    if($.trim(TEL_Operadora) == ""){
        $("#hddFocus").val("selOperadora");
        $("#dialog-atencao").html("Por favor, informe a operadora do contato.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    preLoadingOpen("Adicionando telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "AdicionarFone", 
        TEL_Operadora:  TEL_Operadora,
        TEL_Numero: TEL_Numero,
        TEL_NomeContato: TEL_NomeContato
        
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            } 
            
            if(data.sucesso == "true"){                 
                listarFone(); 
                // limpa campos
                $("#selOperadora").val("");
                $("#txtFone").val("");                
                $("#txtResponsavel").val("");                
                $("#selOperadora").focus();
            }
            preLoadingClose();
        },"json"
    );
}

function listarFone(){
    $.post(controlador, {
            ACO_Descricao: "ListarFone"
        },
        function(data){
            console.log(data);
            var html = '';
            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="97%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="22%">Telefone</td>';
                        html += '<td width="18%">Operadora</td>';                                                
                        html += '<td width="45%">Contato</td>';                        
                        html += '<td align="center" width="15%">Ações</td>'; 
                    html += '</tr>';
                var classDif = '';  
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].TEL_Numero + '</td>';                        
                        html += '<td>' + data.rows[i].TEL_Operadora + '</td>';                        
                        html += '<td>' + data.rows[i].TEL_NomeContato + '</td>';                        
                        html += '<td align="center">';                                    
                            html += "<a href='javascript:void(0);' title='Editar'><img onclick='editarFone(" + data.rows[i].ID + ");' class='btnEditarFone' alt='editar' src='../../../modulos/sistema/home/img/botao-editar.png' border='0' width='11px' height='11px' /></a> &nbsp;&nbsp;&nbsp; ";
                            html += "<a href='javascript:void(0);' title='Remover'><img onclick='removerFone(" + data.rows[i].ID + ");' class='btnExcluirFone' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>  ";                            
                        html += '</td>';
                    html += '</tr>';
                }                        
                html += '</table>';
            }else{
                html += 'Nenhum telefone adicionado.';                
            }
            $("#div-fones").html(html);

        }, "json"
    );
    
}

function editarFone(idFone){
    $.post(controlador, {
        ACO_Descricao: "BuscarFone",
        ID: idFone
    },
        function(data){                                 
                if(data.sucesso == "true"){                    
                    $("#hddIDFone").val(data.rows.ID);
                    $("#txtFoneEdicao").val(data.rows.TEL_Numero);
                    $("#selOperadoraEdicao").val(data.rows.TEL_Operadora);
                    $("#txtResponsavelEdicao").val(data.rows.TEL_NomeContato);                    
                    $("#dialog-editar-fone").dialog("open");
                    
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}
function executarEditarFone(){
    var ID   = $("#hddIDFone").val();    
    var TEL_Operadora   = $("#selOperadoraEdicao").val();    
    var TEL_Numero      = $("#txtFoneEdicao").val();
    var TEL_NomeContato = $("#txtResponsavelEdicao").val();    
    
    if($.trim(TEL_Numero) == ""){        
        $("#hddFocus").val("txtFoneEdicao");
        $("#dialog-atencao").html("Por favor, informe o telefone do contato.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim(TEL_Operadora) == ""){
        $("#hddFocus").val("selOperadoraEdicao");
        $("#dialog-atencao").html("Por favor, informe a operadora do contato.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    preLoadingOpen("Adicionando telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "SalvarEditarFone", 
        TEL_Operadora:  TEL_Operadora,
        TEL_Numero: TEL_Numero,
        TEL_NomeContato: TEL_NomeContato,
        ID: ID
        
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            if(data.sucesso == "true"){                
                // limpa campos
                $("#selOperadoraEdicao").val("");
                $("#txtFoneEdicao").val("");                
                $("#txtResponsavelEdicao").val("");                
                $("#selOperadoraEdicao").focus();
                $("#dialog-editar-fone").dialog("close");
                listarFone();
            }
            preLoadingClose();
        },"json"
    );
}

function limparFone(){
    $.post(controlador, {
        ACO_Descricao: "LimparFone"
    },
        function(data){                     
            var html = '';
                if(data.sucesso == "true"){
                    $("#selOperadora").val("");
                    $("#txtFone").val(""); 
                    $("#txtResponsavel").val(""); 
                    html = '<b>';
                        html += 'Nenhum telefone adicionado.';
                    html += '</b>';                    
                    $("#div-fones").html(html);
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}
    
function removerFone(ID){ 
    preLoadingOpen("Removendo telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "ExcluirFone", 
        ID: ID
    },
        function(data){            
            if(data.sucesso == "true"){                
                listarFone();                
            }   
            
            preLoadingClose();
        },"json"
    );
}
























function adicionarEmail(){    
    var EMA_Email  = $("#txtEmail").val();
    
    if($.trim(EMA_Email) == ""){        
        $("#txtEmail").focus();
        $("#dialog-atencao").html("Por favor, informe o e-mail.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(!isEmail($('#txtEmail').val())){
        $("#txtEmail").focus();
        $("#dialog-atencao").html("Por favor, informe um e-mail válido.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    $.post(controlador, {
        ACO_Descricao: "AdicionarEmail", 
        EMA_Email:  EMA_Email        
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }               
            if(data.sucesso == "true"){                 
                listarEmail();                
                $("#txtEmail").val("");                
                $("#txtEmail").focus();
            }
        },"json"
    );
}

function listarEmail(){    
    $.post(controlador, {
            ACO_Descricao: "ListarEmails"
        },
        function(data){                     
            var html = '';
            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="85%">E-mail</td>';                        
                        html += '<td align="center" width="15%">Ações</td>'; 
                    html += '</tr>';
                var classDif = '';  
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].EMA_Email + '</td>';                        
                        html += '<td align="center">';                               
                            html += "<a href='javascript:void(0);' title='Editar'><img onclick='editarEmail(" + data.rows[i].ID + ");' class='btnEditarEmail' alt='editar' src='../../../modulos/sistema/home/img/botao-editar.png' border='0' width='11px' height='11px' /></a> &nbsp;&nbsp;&nbsp; ";
                            html += "<a href='javascript:void(0);' title='Remover'><img onclick='removerEmail(" + data.rows[i].ID + ");' class='btnExcluirEmail' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>  ";                                                    
                        html += '</td>';
                    html += '</tr>';
                }                        
                html += '</table>';

            }else{
                
                    html += 'Nenhum e-mail adicionado.';
            }
            $("#div-emails").html(html);

        }, "json"
    );    
}


function editarEmail(idEmail){
    $.post(controlador, {
        ACO_Descricao: "BuscarEmail",
        ID: idEmail
    },
        function(data){                                 
                if(data.sucesso == "true"){                    
                    $("#hddIDEmail").val(data.rows.ID);
                    $("#txtEmailEdicao").val(data.rows.EMA_Email);                    
                    $("#dialog-editar-email").dialog("open");
                    
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}
function executarEditarEmail(){
    var ID   = $("#hddIDEmail").val();           
    var EMA_Email      = $("#txtEmailEdicao").val();
    
    
    if($.trim(EMA_Email) == ""){        
        $("#txtEmailEdicao").focus();
        $("#dialog-atencao").html("Por favor, informe o e-mail.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(!isEmail(EMA_Email)){
        $("#txtEmailEdicao").focus();
        $("#dialog-atencao").html("Por favor, informe um e-mail válido.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    preLoadingOpen("Adicionando telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "SalvarEditarEmail", 
        EMA_Email:  EMA_Email,        
        ID: ID
        
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            if(data.sucesso == "true"){                
                // limpa campos
                $("#hddIDEmail").val("");
                $("#txtEmailEdicao").val("");              
                
                $("#dialog-editar-email").dialog("close");
                listarEmail();
            }
            preLoadingClose();
        },"json"
    );
}

function limparEmail(){
    $.post(controlador, {
        ACO_Descricao: "LimparEmail"
    },
        function(data){                     
            var html = '';
                if(data.sucesso == "true"){
                    $("#txtEmail").val("");                    
                    html = '<b>';
                        html += 'Nenhum e-mail adicionado.';
                    html += '</b>';                    
                    $("#div-emails").html(html);
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );    
}
    
function removerEmail(ID){    
    $.post(controlador, {
        ACO_Descricao: "ExcluirEmail", 
        ID: ID
    },
        function(data){            
            if(data.sucesso == "true"){                
                listarEmail();                
            }            
        },"json"
    );
}







function preencherDadosFornecedorTelefoneEmail(fornecedorID){
    // e-mails
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionEmails", FOR_ID: fornecedorID}
    })
    .done(function( data ) {        
        if(data.sucesso == "true"){                    
            listarEmail();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
    // telefones
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionFone", FOR_ID: fornecedorID}
    })
    .done(function( data ) {        
        if(data.sucesso == "true"){                    
            listarFone();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
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
