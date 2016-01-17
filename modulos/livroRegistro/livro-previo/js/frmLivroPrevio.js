// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val();
var controlador  = "../../livroRegistro/livro-previo/controladores/LivroPrevioControlador.php";
var dg           = $('#grid');

// inicialização
function init(){
    // cria as tabs
    $('#tabs').tabs();    
    $("#txtPesquisaDataCadastro").mask("99/99/9999"); 
    $("#txtPesquisaDataCadastro").datepicker();
    
    $("#txtNumeroLivro").numeric();
    
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
        var txtPesquisaNumero = $("#txtPesquisaNumero").val();    
        var txtPesquisaDataCadastro    = $("#txtPesquisaDataCadastro").val();    
           

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            LIP_NumeroLivro: txtPesquisaNumero,
            LIP_DataHoraCadastro: txtPesquisaDataCadastro,
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
                            LIP_ID: $("#hddID").val()
                        },
                            function(data){                                
                                
                                if(data.sucesso == "true"){
                                    $("#hddID").val(data.rows[0].LIP_ID);
                                    $("#txtDescricao").val(data.rows[0].LIP_Descricao);
                                    //$("#selTipo").val(data.rows[0].LIP_Tipo);

                                    if(data.rows[0].TIL_Status == "I") {
                                        $("#ckbStatus").prop("checked", true);
                                    }

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
            name: 'LIP_ID', title: 'Cód.', width: 60, align: 'center'
        },{
            name: 'LIP_NumeroLivro', title: 'Numero do livro', width: 550, align: 'left'                            
        },{
            name: 'totalFolhas', title: 'Quantidade de Folhas', width: 150, align: 'left'                            
        },{            
            name: 'LIP_DataHoraCadastro', title: 'Data Cadastro', width: 100, align: 'left'        
        }/*,
        
            
            {
            name: 'TIL_Tipo', title: 'Ativo', width: 80, align: 'center', render: function(d) {
                var tipo = 'RECEITA';
                if(d == "D"){
                    tipo = "DESPESA";
                }
                return tipo;
            }
        },{
            name: 'TIP_Status', title: 'Ativo', width: 60, align: 'center', render: function(d) {
                var status = 'SIM';
                if(d == "I"){
                    status = "NÃO";
                }
                return status;
            }
        }*/]
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
    
    if($.trim($('#txtNumeroLivro').val()) == ""){        
        $("#hddFocus").val("txtNumeroLivro");
        $("#dialog-atencao").html("Por favor, informe o número do livro.");
        $("#dialog-atencao").dialog("open");
        return;
    } 
    
    numero = $('#txtNumeroLivro').val().substring(0,1);
    if(numero < 1){
        $("#hddFocus").val("txtNumeroLivro");
        $("#dialog-atencao").html("Por favor, informe um número inteiro, sem zero, maior que o último cadastrado.");
        $("#dialog-atencao").dialog("open");
        return false;
    }
    
    /*
    if($.trim($('#selTipo').val()) == ""){        
        $("#hddFocus").val("selTipo");
        $("#dialog-atencao").html("Por favor, informe o tipo.");        
        $("#dialog-atencao").dialog("open");
        return;
    }*/
    
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
    $('#tabs').tabs('option', 'active', 0); // retorna para a primeira aba
    $("#hddID").val("");  
    $("#hddFocus").val("");    
    $("#txtNumeroLivro").val("");
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
    var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;

    $.post(controlador, {
        ACO_Descricao: "Excluir",
        LIP_ID: id
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
/*var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, não encontrado!'},
    '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}*/
//para o autocomplete

/*function preencheTipoLinha(){
    var TIL_Tipo = $('input[name=TipoTipoLinha]:checked').val();
    $("#selTipoLinha").html("<option value=''>CARREGANDO...</option>");
    $("#selTipoLinha").trigger('chosen:updated');
    
    $.post(controladorTipoLinha, {
        ACO_Descricao: "Consultar",
        TIL_Tipo: TIL_Tipo,
        TIL_Status: "A"
    },
        function(data) {            
            if(data.sucesso == "true"){                            
                var html = '<option value=""></option>';
                for(var i=0; i<data.rows.length; i++){ 
                    html += '<option value="' + data.rows[i].TIL_ID + '">' + data.rows[i].TIL_Descricao+ '</option>';
                }
                $("#selTipoLinha").html(html);
                
                if(TIL_Tipo == "R"){
                    $("#selTipoLinha").attr("data-placeholder", "SELECIONE A RECEITA" );                    
                }else{
                    $("#selTipoLinha").attr("data-placeholder", "SELECIONE A DESPESA" );
                }                
                $("#selTipoLinha").trigger('chosen:updated');
                
                
            }
        }, "json"
    );
    
}*/