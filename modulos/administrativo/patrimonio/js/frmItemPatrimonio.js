// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/patrimonio/controladores/ItemPatrimonioControlador.php";
var dg           = $('#grid');

// inicialização
function init(){
    // cria as tabs
    $('#tabs').tabs();
    $('#txtDepreciacao').numeric();
    
    // Dialog
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
    
    //preenche os itens do select de tipo de patrimonio
    getItemPatrimonioDinamico();
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
            IPT_Descricao: pesquisaDescricao,
            IPT_Status: pesquisaStatus,
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
                            IPT_ID: $("#hddID").val()
                        },
                            function(data){                                
                                
                                //alert(data); return;
                                if(data.sucesso == "true"){
                                    $("#hddID").val(data.rows[0].IPT_ID);
                                    $("#txtDescricao").val(data.rows[0].IPT_Descricao);                                    
                                    $("#txtDepreciacao").val(data.rows[0].IPT_PercentualDepreciacao);                                    
                                    $("#selTipo").val(data.rows[0].TIP_ID);
                                    $('#selTipo').trigger('chosen:updated'); 

                                    if(data.rows[0].IPT_Status == "I") $("#ckbStatus").prop("checked", true);                                    

                                    $('#tabs').tabs('option', 'active', 1);
                                }else{
                                    $("#dialog-atencao").html(data.mensagem);        
                                    $("#dialog-atencao").dialog("open");
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
            name: 'IPT_ID', title: 'Cód.', width: 60, align: 'center'
        },{
            name: 'IPT_Descricao', title: 'Descrição', width: 800, align: 'left'        
        },{
            name: 'IPT_PercentualDepreciacao', title: 'Depreciação', width: 80, align: 'left', render: function(val) {
                
                return val+"%";
            }
        },{
            name: 'IPT_Status', title: 'Ativo', width: 60, align: 'center', render: function(d) {
                var status = 'SIM';
                if(d == "I"){
                    status = "NÃO";
                }
                return status;
            }
        }]
    });
}

function getItemPatrimonioDinamico(){      
    $.ajax({
        type: "POST",
        url: "../../administrativo/patrimonio/controladores/TipoPatrimonioControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", ITP_Status: "A"}
    })
    .done(function( data ) {       
        $("#selTipo").html("<option value=''></option>");        
        if(data.sucesso == "true"){            
            var html = '';            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].TIP_ID + '">' + data.rows[i].TIP_Descricao + '</option>';
            }
            $("#selTipo").append(html);
            $("#selTipo").trigger('chosen:updated');
        }        
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
    
    if($.trim($('#selTipo').val()) == ""){        
        $("#hddFocus").val("selTipo");
        $("#dialog-atencao").html("Por favor, informe o tipo do patrimônio.");        
        $("#dialog-atencao").dialog("open");
        return;
    } 
    
    if($.trim($('#txtDescricao').val()) == ""){        
        $("#hddFocus").val("txtDescricao");
        $("#dialog-atencao").html("Por favor, informe a descrição.");        
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

function cancelar(){
    $('#tabs').tabs('option', 'active', 0);
    
    $("#hddID").val("");  
    $("#hddFocus").val(""); 
    $("#selTipo").val("");
    $('#selTipo').trigger('chosen:updated');   
    $("#txtDescricao").val("");         
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
        IPT_ID: ids
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