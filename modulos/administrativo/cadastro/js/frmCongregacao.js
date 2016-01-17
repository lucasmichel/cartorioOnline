// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/cadastro/controladores/CongregacaoControlador.php";
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
    
    $('#txtTelefone').mask("(99) 9999.9999");
    $('#txtFax').mask("(99) 9999.9999");
    $('#txtEnderecoCEP').mask("99999-999");

    // configura o grid
    initGRID();   
      
    // carrega o grid
    consultar();      
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
        UNI_ID: ids
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
            UNI_Descricao: pesquisaDescricao,
            UNI_Status: pesquisaStatus,
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
                            UNI_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                      
                                    $("#hddID").val(data.rows[0].UNI_ID);                                      
                                    $("#txtDescricao").val(data.rows[0].UNI_Descricao);
                                    $("#txtTelefone").val(data.rows[0].UNI_Telefone);
                                    $("#txtFax").val(data.rows[0].UNI_Fax);
                                    $("#txtEnderecoCEP").val(data.rows[0].UNI_EnderecoCep);    
                                    $("#txtEnderecoLogradouro").val(data.rows[0].UNI_EnderecoLogradouro);    
                                    $("#txtEnderecoNumero").val(data.rows[0].UNI_EnderecoNumero);    
                                    $("#txtEnderecoComplemento").val(data.rows[0].UNI_EnderecoComplemento);    
                                    $("#txtEnderecoPontoReferencia").val(data.rows[0].UNI_EnderecoPontoReferencia);    
                                    $("#txtEnderecoBairro").val(data.rows[0].UNI_EnderecoBairro);    
                                    $("#txtEnderecoCidade").val(data.rows[0].UNI_EnderecoCidade);    
                                    $("#selEnderecoUF").val(data.rows[0].UNI_EnderecoUf);                                        
                                    $("#txtObservacao").val(data.rows[0].UNI_Observacao); 
                                    $("#txtResponsavel").val(data.rows[0].UNI_Responsavel); 
                                    if(data.rows[0].UNI_Status == "A"){
                                        $("#ckbStatus").prop("checked", false);
                                    }else{
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
            name: 'UNI_ID', title: 'Cód.', width: 60, align: 'center'
        },{
            name: 'UNI_Descricao', title: 'Descrição', width: 480, align: 'left'        
        },{
            name: 'UNI_Responsavel', title: 'Responsável', width: 200, align: 'left'        
        },{
            name: 'UNI_Telefone', title: 'Telefone', width: 100, align: 'left'        
        },{
            name: 'UNI_EnderecoCidade', title: 'Cidade', width: 100, align: 'left'        
        },{
            name: 'UNI_Status', title: 'Ativo', width: 60, align: 'center', render: function(d) {
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
        $("#dialog-atencao").html("Por favor, informe a descrição.");
        $("#dialog-atencao").dialog("open");
        return;
    }
     
    
    // guarda o texto no hidden
    // para poder ser enviado pelo ajaxForm    
    
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
    $("#txtTelefone").val("");
    $("#txtFax").val("");
    $("#txtEnderecoCEP").val("");    
    $("#txtEnderecoLogradouro").val("");    
    $("#txtEnderecoNumero").val("");    
    $("#txtEnderecoComplemento").val("");    
    $("#txtEnderecoPontoReferencia").val("");    
    $("#txtEnderecoBairro").val("");    
    $("#txtEnderecoCidade").val("");    
    $("#selEnderecoUF").val("");        
    $("#txtObservacao").val("");
    $("#txtResponsavel").val("");
       
    $("#ckbStatus").prop("checked", false);        
    $('#tabs').tabs('option', 'active', 0);
}