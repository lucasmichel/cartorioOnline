// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../livroRegistro/livro-previo/controladores/FolhaPrevioControlador.php";
var livroControlador  = "../../livroRegistro/livro-previo/controladores/LivroPrevioControlador.php";
var dg           = $('#grid');

// inicialização
function init(){
    // cria as tabs
    $('#tabs').tabs();    
    
    $("#txtPesquisaData").mask("99/99/9999"); 
    $("#txtPesquisaData").datepicker();    
    
    $("#txtData").mask("99/99/9999"); 
    $("#txtData").datepicker();    
    
    $("#txtNumeroFolha").numeric();
    
    /*$("#txtQuantidade").numeric();    
    $('#txtValor').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    $('#txtCPF').mask("999.999.999-99");*/
    
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
        
        var selPesquisaLivro = $("#selPesquisaLivro").val();    
        var txtPesquisaNumeroFolha = $("#txtPesquisaNumeroFolha").val();    
        var txtPesquisaData = $("#txtPesquisaData").val();    
        
        

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar",
            
            LIP_ID: selPesquisaLivro,
            FPR_NumeroFolha: txtPesquisaNumeroFolha,
            FPR_DataFolha: txtPesquisaData,
            
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
                            FPR_ID: $("#hddID").val()
                        },
                            function(data){                                
                                
                                if(data.sucesso == "true"){
                                    $("#hddID").val(data.rows[0].FPR_ID);

                                    $("#selLivro").val(data.rows[0].LIP_ID);
                                    $("#selLivro").trigger('chosen:updated');

                                    $("#txtNumeroFolha").val(data.rows[0].FPR_NumeroFolha);         
                                    $("#txtData").val(data.rows[0].FPR_DataFolha);         
                                    

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
            name: 'FPR_ID', title: 'Cód.', width: 60, align: 'center'        
        },{
            name: 'LIP_NumeroLivro', title: 'Livro', width: 100, align: 'left'                        
        },{
            name: 'FPR_NumeroFolha', title: 'Numero Folha', width: 300, align: 'left'                
        },{
            name: 'totalLinhas', title: 'Quantidade de Linhas', width: 150, align: 'left'                            
        },{
            name: 'FPR_DataFolha', title: 'Data', width: 80, align: 'left'                
        },{
            name: 'Usuario_Cadastro', title: 'Usuario Cadastro', width: 80, align: 'left'        
        }
        
        /*
            ,{
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
        }*/
        
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
    
    if($.trim($('#selLivro').val()) == ""){        
        $("#hddFocus").val("selLivro");
        $("#dialog-atencao").html("Por favor, informe o livro da folha.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(!consultarPermissaoSalvarLivro($('#selLivro').val()) ){
        $("#hddFocus").val("selLivro");
        $("#dialog-atencao").html("Livro com o total de folhas já preenchido, por favor, escolha outro .");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    
    if($.trim($('#txtNumeroFolha').val()) == ""){        
        $("#hddFocus").val("txtNumeroFolha");
        $("#dialog-atencao").html("Por favor, informe o numero da folha.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    numero = $('#txtNumeroFolha').val().substring(0,1);
    if(numero < 1){
        $("#hddFocus").val("txtNumeroFolha");
        $("#dialog-atencao").html("Por favor, informe um número inteiro, sem zero, maior que o último cadastrado.");
        $("#dialog-atencao").dialog("open");
        return false;
    }
    
    if($.trim($('#txtData').val()) == ""){        
        $("#hddFocus").val("txtData");
        $("#dialog-atencao").html("Por favor, informe a data da folha.");        
        $("#dialog-atencao").dialog("open");
        return;
    } 
    
    if(!isDataValida($('#txtData').val())){        
        $("#hddFocus").val("txtData");
        $("#dialog-atencao").html("Por favor, informe uma data válida.");        
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
    $('#tabs').tabs('option', 'active', 0); // retorna para a primeira aba
    $("#hddID").val("");  
    $("#hddFocus").val("");  
    
    $("#selLivro").val("");
    $("#selLivro").trigger('chosen:updated');
    
    $("#txtNumeroFolha").val("");         
    $("#txtData").val("");    
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
    var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;
    $.post(controlador, {
        ACO_Descricao: "Excluir",
        FPR_ID: id
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

function preencheTipoLinha(){
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
    
}

//ver pra consultar o livro pode receber a folha no cadastro e na edição
function consultarPermissaoSalvarLivro(idLivro){    
    var retorno = false;
    $.ajax({
        type: "POST",
        url: livroControlador,
        dataType: 'json',
        cache: false,
        async:false,    
        data: {LIP_ID: idLivro, ACO_Descricao: "GetPermissaoAddFolhaLivro"}
    }).done(function( data ) {  
        if(data.sucesso == "true"){                                       
            retorno = true;                
        }else{            
            retorno = false;
        }
    });
    return retorno; 
}