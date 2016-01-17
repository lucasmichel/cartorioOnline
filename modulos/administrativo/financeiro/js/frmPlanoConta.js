// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/financeiro/controladores/PlanoContaControlador.php";
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
    
    // carrega o grid
    initGRID();
    consultar(); 
    
    gerenciarTipo();
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
    
    if($('#txtDescricao').val() == ""){        
        $("#hddFocus").val("txtDescricao");
        $("#dialog-atencao").html("Por favor, informe a descrição.");        
        $("#dialog-atencao").dialog("open");
        return;
    }

    if($.trim($("#txtCodigoContabil").val()) == ""){
        $("#hddFocus").val("txtCodigoContabil");
        $("#dialog-atencao").html("Por favor, informe o código contábil.");        
        $("#dialog-atencao").dialog("open");
        return;
    }

    if(acaoExecutada == "Salvar"){
        if(!consultarCodigoContabil($('#txtCodigoContabil').val())){                        
            $("#hddFocus").val("txtCodigoContabil");
            $("#dialog-atencao").html("Código contábil já cadastrado.");        
            $("#dialog-atencao").dialog("open");                
            return;
        }
    }else{
        if(!consultarCodigoContabilEdicao($('#txtCodigoContabil').val(), $('#hddID').val())){                                        
            $("#hddFocus").val("txtCodigoContabil");
            $("#dialog-atencao").html("Código contábil já cadastrado.");        
            $("#dialog-atencao").dialog("open");                
            return;
        }
    }
   
    var tipo = $('input:radio[name=PLA_Tipo]:checked').val();
    
    if(tipo == "A"){
        if($.trim($("#selContaPai").val()) == ""){
            $("#hddFocus").val("selContaPai");
            $("#dialog-atencao").html("Por favor, informe a conta pai.");        
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
   
    preLoadingOpen("Gravando, aguarde...");
   
    // bind form using ajaxForm 
    $('#frmCadastro').ajaxForm({
        // dataType identifies the expected content type of the server response 
        dataType:  'json', // Comentar essa linha para debugar
        // success identifies the function to invoke when the server response 
        // has been received 
        success: function(data) {            
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
    var pesquisaMovimentacao = $("#selPesquisaMovimentacao").val();  
    var pesquisaTipo = $("#selPesquisaTipo").val();  
    var pesquisaStatus    = $("#selPesquisaStatus").val();    
        
    if($("#numlines").size() > 0){
        limitConsulta = parseInt($("#numlines").val());
    }  
        
        var params = {
            ACO_Descricao: "Consultar", 
            PLA_Descricao: pesquisaDescricao,
            PLA_Movimentacao: pesquisaMovimentacao,
            PLA_Tipo: pesquisaTipo,
            PLA_Status: pesquisaStatus,
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
        CCA_Descricao: pesquisaDescricao,
        CCA_Status: pesquisaStatus,
        limit: limitConsulta,        
        offset: 0
    },
        function(data) {                            
            alert(data);            
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
        ,title: ''
        ,rowNumber: false
        ,onClickRow: function(row) {
            $(this).datagrid('selectRow',row);
        }
        ,toolBarButtons:[
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
                            PLA_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                    
                                    $("#txtDescricao").val(data.rows[0].PLA_Descricao);
                                    $("#txtCodigoContabil").val(data.rows[0].PLA_CodigoContabil);                                   
                                     
                                    if(data.rows[0].PLA_Movimentacao == "S"){
                                        $("#rdbTipoMovimentoE").prop("checked", false);
                                        $("#rdbTipoMovimentoS").prop("checked", true);
                                    }else{
                                        $("#rdbTipoMovimentoE").prop("checked", true);
                                        $("#rdbTipoMovimentoS").prop("checked", false);
                                    }
                                    
                                    if(data.rows[0].PLA_Tipo == "S"){
                                        $("#rdbTipoA").prop("checked", false);
                                        $("#rdbTipoS").prop("checked", true);
                                    }else{
                                        $("#rdbTipoA").prop("checked", true);
                                        $("#rdbTipoS").prop("checked", false);
                                    }
                                    
                                    if(data.rows[0].PLA_Status == "I"){ 
                                        $("#ckbStatus").prop("checked", true);
                                    }
                                    
                                    gerenciarTipo();
                                    $("#selContaPai").val(data.rows[0].PLA_CodigoContabilPai);
                                    $("#selContaPai").trigger('chosen:updated');
                                    
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
            },{
                label: 'Imprimir Plano de Contas'
                ,icon: 'print'
                ,fn: function(){
                    var pesquisaMovimentacao = $("#selPesquisaMovimentacao").val();  
                    var pesquisaTipo         = $("#selPesquisaTipo").val();  
                    var pesquisaStatus       = $("#selPesquisaStatus").val();    
                    
                    var url = "../../administrativo/financeiro/documentos/PlanoDeContas.php?PLA_Movimentacao=" + pesquisaMovimentacao + "&PLA_Tipo="+pesquisaTipo+"&PLA_Status="+pesquisaStatus;
                    novaJanelaFullscreen(url);
                }            
            }
        ]
        ,mapper:[{
            name: 'PLA_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'PLA_CodigoContabil', title: 'Código Cont&aacute;bil', width: 120, align: 'left'
        },{
            name: 'PLA_Descricao', title: 'Descri&ccedil;&atilde;o', width: 540, align: 'left'
        },{
            name: 'PLA_Movimentacao', title: 'Movimenta&ccedil;&atilde;o', width: 130, align: 'center', render: function(d) {
                var movimento = "ENTRADA";
                
                if(d == "S"){
                    movimento = "SA&Iacute;DA";
                }
                
                return movimento;
            }
        },{
            name: 'PLA_Tipo', title: 'Tipo', width: 160, align: 'center', render: function(d) {
                var tipo = "SINT&Eacute;TICO";
                
                if(d == "A"){
                    tipo = "ANAL&Iacute;TICO";
                }
                
                return tipo;
            }
        },{
            name: 'CCA_Status', title: 'Ativo', width: 40, align: 'center', render: function(d) {
                var ativo = "SIM";
                
                if(d == "I"){
                    ativo = "N&Atilde;O";
                }
                
                return ativo;
            }
        }]
    });
}

function cancelar(){
    $('#tabs').tabs('option', 'active', 0); // retorna para a primeira aba
    
    $("#hddID").val("");  
    $("#hddFocus").val("");
    
    $("#txtDescricao").val("");
    $("#txtCodigoContabil").val("");
    
    $("#ckbStatus").prop("checked", false);  
    $("#rdbTipoMovimentoS").prop("checked", false); 
    $("#rdbTipoMovimentoE").prop("checked", true); 
    
    $("#rdbTipoS").prop("checked", true); 
    $("#rdbTipoA").prop("checked", false); 
    
    gerenciarTipo();
}

function consultarCodigoContabil(codigoContabil){    
    var retorno = false;
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: 'json',
        cache: false,
        async:false,    
        data: {PLA_CodigoContabil: codigoContabil, ACO_Descricao: "ConsultarCodigoContabil"}
    }).done(function( data ) {  
        if(data.sucesso == "true"){                                       
            retorno = true;                
        }else{            
            retorno = false;
        }
    });
    
    return retorno; 
}

function consultarCodigoContabilEdicao(codigoContabil, idConta ){ 
    var retorno = false;
    
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: 'json',
        cache: false,
        async:false,    
        data: {PLA_CodigoContabil_EDICAO: codigoContabil, PLA_ID_EDICAO: idConta,  ACO_Descricao: "ConsultarCodigoContabil"}
    }).done(function( data ) {        
        if(data.sucesso == "true"){                           
            retorno = true;                
        }else{            
            retorno = false;
        }
    });    
    return retorno; 
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
        PLA_ID: ids
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

function gerenciarTipo(){
    var tipo = $('input:radio[name=PLA_Tipo]:checked').val();
    
    if(tipo == "A"){
        $("#fieldsetContaPai").show();
        getContasPai();
    }else{
        $("#fieldsetContaPai").hide();
    }
}

function getContasPai(){     
    var movimentacao = $('input:radio[name=PLA_Movimentacao]:checked').val();
    
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", PLA_Status: "A", PLA_Tipo: "S", PLA_Movimentacao: movimentacao}
    })
    .done(function( data ) {       
        $("#selContaPai").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].PLA_CodigoContabil + '">' + data.rows[i].PLA_CodigoContabil + " - " + data.rows[i].PLA_Descricao + '</option>';
            }
            
            $("#selContaPai").append(html);
            $("#selContaPai").trigger('chosen:updated');
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