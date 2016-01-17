// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/cadastro/controladores/MinisterioControlador.php";
var dg           = $('#grid');

// inicialização
function init(){
    // tabs
    $('#tabs').tabs();
    $('#tabsEndereco').tabs();
    
    // mascaras
    $(".horario").mask("99:99");
    $("#txtEnderecoCep").mask("99999-999");
    
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
      
    $('.horario').each(
        function(){
           $(this).prop("disabled", true);
        }
    );  
    
    
    
    $('.horario').timeEntry({spinnerImage: '', show24Hours: true});
      
    // configura o grid
    initGRID();   
      
    // carrega o grid
    consultar();       
}

function habilitarDesabilitarHorarioDia(diaSemanaID){
    if ($("#ckbDiaSemana_" + diaSemanaID).prop("checked")){
        $("#txtHorario_" + diaSemanaID).prop("disabled", false);
        focus("txtHorario_" + diaSemanaID);
    }else{
        $("#txtHorario_" + diaSemanaID).prop("disabled", true);
        $("#txtHorario_" + diaSemanaID).val("00:00");
    }
}

function consultarEndereco(){
    var objEnderecoCampos = {
        campoCep: "txtEnderecoCep",
        campoLogradouro: "txtEnderecoLogradouro",
        campoBairro: "txtEnderecoBairro",
        campoCidade: {id: "txtEnderecoCidade", isSelect: false},
        campoUf: "selEnderecoUf",
        spanPreLoading: "spnCarregandoCep"
    };
    
    consultarCEP(objEnderecoCampos);
}




/*function consultar(){    
    // limpa o grid
    dg.datagrid('getTbody').empty();
    dg.datagrid('clearSelectedRow');
    
    var data = checarPermissao("ChecarPermissao", formularioID, "Consultar");
    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");         
    }else{           
        // inicia o grid
        initGRID();
    }
}*/




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
        var areaMinsiterial    = $("#selPesquisaAreaMinisterial").val();    

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            MIN_Descricao: pesquisaDescricao,
            MIN_Status: pesquisaStatus,
            AMI_ID: areaMinsiterial,
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
                            MIN_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                    
                                    $("#txtDescricao").val(data.rows[0].MIN_Descricao);                                    
                                    if(data.rows[0].DIA_ID != null){
                                        for(var i=0; i<data.rows[0].DIA_ID.length; i++){
                                            $("#ckbDiaSemana_" + data.rows[0].DIA_ID[i]).prop("checked", true);                                            
                                            $("#txtHorario_" + data.rows[0].DIA_ID[i]).val(data.rows[0].MDR_Horario[i]);
                                            $("#txtHorario_" + data.rows[0].DIA_ID[i]).prop("disabled", false); 
                                        }
                                    }                                    
                                    $("#selAreaMinisterial").val(data.rows[0].AMI_ID);                                    
                                    $("#selAreaMinisterial").trigger('chosen:updated');                                    
                                    $("#txtEnderecoCep").val(data.rows[0].MIN_EnderecoCep);
                                    $("#txtEnderecoLogradouro").val(data.rows[0].MIN_EnderecoLogradouro);
                                    $("#txtEnderecoNumero").val(data.rows[0].MIN_EnderecoNumero);
                                    $("#txtEnderecoComplemento").val(data.rows[0].MIN_EnderecoComplemento);
                                    $("#txtEnderecoPontoReferencia").val(data.rows[0].MIN_EnderecoPontoReferencia);
                                    $("#txtEnderecoBairro").val(data.rows[0].MIN_EnderecoBairro);
                                    $("#txtEnderecoCidade").val(data.rows[0].MIN_EnderecoCidade);
                                    $("#selEnderecoUf").val(data.rows[0].MIN_EnderecoUf);
                                    
                                    $("#txtObservacao").val(data.rows[0].MIN_Observacao);                                   
                                    
                                    if(data.rows[0].MIN_Status == "I"){ 
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
            name: 'MIN_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'MIN_Descricao', title: 'Minist&eacute;rio', width: 280, align: 'left'
        },{
            name: 'MIN_DiasReuniao', title: 'Reuni&atilde;o', width: 300, align: 'left'
        },{
            name: 'AMI_Descricao', title: 'Área Ministerial', width: 150, align: 'left'        
        },{
            name: 'MIN_Observacao', title: 'Anota&ccedil;&atilde;o', width: 150, align: 'left'
        },{
            name: 'MIN_Status', title: 'Ativo', width: 60, align: 'center', render: function(d) {
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
    
    if($.trim($('#txtDescricao').val()) == ""){        
        $("#hddFocus").val("txtDescricao");
        $("#dialog-atencao").html("Por favor, informe o nome do ministério.");
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
    
    $('.dia').each(
         function(){
            $(this).prop("checked", false);
         }
    );
    
    $('.horario').each(
         function(){
            $(this).prop("disabled", true);
            $(this).val("00:00");
         }
    );
    
    $("#txtEnderecoCep").val(""); 
    $("#txtEnderecoLogradouro").val(""); 
    $("#txtEnderecoNumero").val(""); 
    $("#txtEnderecoComplemento").val(""); 
    $("#txtEnderecoPontoReferencia").val(""); 
    $("#txtEnderecoBairro").val(""); 
    $("#txtEnderecoCidade").val(""); 
    $("#selEnderecoUf").val("");
    $("#txtObservacao").val("");    
    $("#selAreaMinisterial").val("");
    $('#selAreaMinisterial').trigger('chosen:updated');                                    
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
        MIN_ID: ids
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