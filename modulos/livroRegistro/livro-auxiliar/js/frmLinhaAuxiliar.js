// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controladorTipoLinha  = "../../livroRegistro/tipo-linha-livro/controladores/TipoLinhaLivroControlador.php";
var controladorFolha  = "../../livroRegistro/livro-auxiliar/controladores/FolhaAuxiliarControlador.php";
var controlador  = "../../livroRegistro/livro-auxiliar/controladores/LinhaAuxiliarControlador.php";
var dg           = $('#grid');

var permissaoAUXILIAR_COMPLETO = "";


// inicialização
function init(){
    // cria as tabs
    $('#tabs').tabs();    
    $("#txtData").mask("99/99/9999"); 
    $("#txtData").datepicker();    
    $("#txtQuantidade").numeric();    
    $('#txtValor').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    mudaEditTipoPessoa();
    
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
    
    //VALIDAR EXECUCAO PELO TIPO DE USUARIO
    var acaoExecutadaTestar = "AUXILIAR_COMPLETO"; 
    
    // ### PERMISSAO ###
    var dataRetornoPermissaoAdm = checarPermissao("ChecarPermissao", formularioID, acaoExecutadaTestar);
    
    permissaoAUXILIAR_COMPLETO = dataRetornoPermissaoAdm.sucesso;
    
    if(permissaoAUXILIAR_COMPLETO == "false"){
        //desabilita os inputs livro e folha
        $("#fildSelectLivro").hide();
        $("#fildSelectLinha").hide();
    }else{
        $("#fildSelectLivro").show();
        $("#fildSelectLinha").show();
    }
    
    
    
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
        
        var pesquisaLivro = $("#selLivroPesquisa").val();              
        var pesquisaFolha = $("#selFolhaPesquisa").val();              
        
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();              
        var pesquisaTipo    = $("#selTipoPesquisa").val(); 
        
        var pesquisaProtcolo    = $("#txtPesquisaProtocolo").val(); 
        var pesquisaGuia    = $("#txtPesquisaGuia").val(); 
        
        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            LIA_ID: pesquisaLivro,
            FAU_ID: pesquisaFolha,
            TIL_Tipo: pesquisaTipo,            
            LAU_Descricao: pesquisaDescricao,
            LAU_ProtocoloRecepcao:pesquisaProtcolo,
            LAU_Guia:pesquisaGuia,            
            limit: limitConsulta,
            offset: 0
        };
        console.log(params);
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
                            LAU_ID: $("#hddID").val()
                        },
                            function(data){                                
                                
                                if(data.sucesso == "true"){
                                    
                                    $("#hddID").val(data.rows[0].LAU_ID);
                                    
                                    //é usuario restrito... esconde o livro e a linha
                                    if(permissaoAUXILIAR_COMPLETO == "false"){
                                        $("#hddFolhaEditar").val(data.rows[0].FAU_ID);
                                        $("#fildSelectLivro").hide();
                                        $("#fildSelectLinha").hide();
                                    }else{                                        
                                        $("#hddFolhaEditar").val(data.rows[0].FAU_ID);
                                        
                                        $("#selLivro").val(data.rows[0].LIA_ID);
                                        $("#selLivro").trigger('chosen:updated');
                                        preencheFolha();
                                        $("#selFolha").val(data.rows[0].FAU_ID);
                                        $("#selFolha").trigger('chosen:updated');
                                        
                                        $("#fildSelectLivro").show();
                                        $("#fildSelectLinha").show();
                                    }
                                    
                                    
                                    if(data.rows[0].TIL_Tipo == "D"){
                                        $("#ckbTipoDespesa").prop("checked", true);
                                        $("#ckbTipoReceita").prop("checked", false);
                                    }else{
                                        $("#ckbTipoDespesa").prop("checked", false);
                                        $("#ckbTipoReceita").prop("checked", true);
                                    }
                                    preencheTipoLinha();
                                    
                                    $("#selTipoLinha").val(data.rows[0].TIL_ID);
                                    $("#selTipoLinha").trigger('chosen:updated');
                                    
                                    $("#txtDescricao").val(data.rows[0].LAU_Descricao);
                                    $("#txtGuia").val(data.rows[0].LAU_Guia);
                                    $("#txtProtocoloRecepcao").val(data.rows[0].LAU_ProtocoloRecepcao);
                                    $("#txtQuantidade").val(data.rows[0].LAU_Quantidade);
                                    
                                    $("#tipoPessoaLinha").val(data.rows[0].LAU_TipoFisicaJuridicaLinha);
                                    $("#tipoPessoaLinha").trigger('chosen:updated');
                                    mudaEditTipoPessoa();
                                    $("#txtCpfCnpj").val(data.rows[0].LAU_Cpf);
                                    
                                    $("#txtData").val(data.rows[0].LAU_Data);
                                    $("#txtValor").val(data.rows[0].LAU_Valor);
                                    
                                    /*if(data.rows[0].LAU_Status == "I") {
                                        $("#ckbStatus").prop("checked", true);
                                    }*/

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
            name: 'LAU_ID', title: 'Cód.', width: 60, align: 'center'
        },{
            name: 'Livro', title: 'Livro', width: 60, align: 'center'        
        },{
            name: 'Folha', title: 'Folha', width: 60, align: 'center'
        },{
            name: 'LAU_Cpf', title: 'CPF/CNPJ', width: 125, align: 'left'        
        },{
            name: 'LAU_Descricao', title: 'Descrição', width: 250, align: 'left'                
        },{
            name: 'LAU_Guia', title: 'Guia', width: 250, align: 'left'        
        },{
            name: 'LAU_Data', title: 'Data', width: 100, align: 'left'        
        },{
            name: 'TIL_Tipo', title: 'Tipo', width: 80, align: 'center', render: function(d) {
                var tipo = 'RECEITA';
                if(d == "D"){
                    tipo = "DESPESA";
                }
                return tipo;
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

    
    if(permissaoAUXILIAR_COMPLETO == "true"){
        if(!consultarPermissaoSalvarFolha($('#selFolha').val()) ){
            $("#hddFocus").val("selFolha");
            $("#dialog-atencao").html("Folha com o total de linhas já preenchido, por favor, escolha outra.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    
    if($.trim($('#txtDescricao').val()) == ""){        
        $("#hddFocus").val("txtDescricao");
        $("#dialog-atencao").html("Por favor, informe a descrição.");        
        $("#dialog-atencao").dialog("open");
        return;
    } 
    
    if($.trim($('#selTipoLinha').val()) == ""){        
        $("#hddFocus").val("selTipoLinha");
        $("#dialog-atencao").html("Por favor, informe o tipo.");        
        $("#dialog-atencao").dialog("open");
        return;
    } 
    
    //preLoadingOpen("Gravando, aguarde...");

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
    
    $("#hddFolhaEditar").val("");
    
    $("#selLivro").val("");
    $("#selLivro").trigger('chosen:updated');

    $("#selFolha").val("");
    $("#selFolha").trigger('chosen:updated');
    
    $("#ckbTipoDespesa").prop("checked", false);
    $("#ckbTipoReceita").prop("checked", false);
    
    $("#selTipoLinha").val("");         
    $("#selTipoLinha").trigger('chosen:updated');
    $("#selTipoLinha").attr("data-placeholder", "SELECIONE O TIPO DE LINHA" );
    
    if(permissaoAUXILIAR_COMPLETO == "false"){        
        $("#fildSelectLivro").hide();
        $("#fildSelectLinha").hide();
    }else{
        $("#fildSelectLivro").show();
        $("#fildSelectLinha").show();
    }
    
    $("#txtDescricao").val("");
    $("#txtGuia").val("");
    $("#txtProtocoloRecepcao").val("");
    $("#txtQuantidade").val("");
    $("#txtCpfCnpj").val("");
    $("#txtData").val("");
    $("#txtValor").val("");
    
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
    var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;

    $.post(controlador, {
        ACO_Descricao: "Excluir",
        LAU_ID: id
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
    
    $.ajax({
        type: "POST",
        url: controladorTipoLinha,
        dataType: "json",
        async: false,
        data: {
            ACO_Descricao: "Consultar",
            TIL_Tipo: TIL_Tipo,
            TIL_Status: "A"
        }
    })
    .done(function( data ) {        
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

    
        }else{
            //$("#fieldsetDataCasamento").hide();
        }
    });
}


function preencheFolha(){
    var LIA_ID = $('#selLivro').val();
    
    if(LIA_ID > 0){
        $("#selFolha").html("<option value=''>CARREGANDO...</option>");
        $("#selFolha").trigger('chosen:updated');

        $.ajax({
            type: "POST",
            url: controladorFolha,
            dataType: "json",
            async: false,
            data: {
                ACO_Descricao: "Consultar", 
                LIA_ID: LIA_ID
            }
        })
        .done(function( data ) {        
            if(data.sucesso == "true"){
                var html = '<option value=""></option>';
                for(var i=0; i<data.rows.length; i++){ 
                    html += '<option value="' + data.rows[i].FAU_ID + '">' + data.rows[i].FAU_NumeroFolha+ '</option>';
                }
                $("#selFolha").html(html);
                $("#selFolha").trigger('chosen:updated');

            }else{
                //$("#fieldsetDataCasamento").hide();
                $("#selFolha").html("<option value=''></option>");
                $("#selFolha").trigger('chosen:updated');
            }
        });
    }else{
        $("#selFolha").html("<option value=''></option>");
        $("#selFolha").trigger('chosen:updated');
    }
}


//ver pra consultar o livro pode receber a folha no cadastro e na edição
function consultarPermissaoSalvarFolha(idFolha){    
    var idEdicaoFolha = $("#hddFolhaEditar").val();
    if(idEdicaoFolha != idFolha){
        var retorno = false;
        $.ajax({
            type: "POST",
            url: controladorFolha,
            dataType: 'json',
            cache: false,
            async:false,    
            data: {FAU_ID: idFolha, ACO_Descricao: "GetPermissaoAddLinhaFolha", FAU_ID_EDICAO: idEdicaoFolha }
        }).done(function( data ) { 
            console.log(data);
            if(data.sucesso == "true"){                                       
                retorno = true;                
            }else{            
                retorno = false;
            }
        });
        return retorno;
    }else{
        return true;
    }
}




function preencheFolhaPesquisa(){
    var LIA_ID = $('#selLivroPesquisa').val();
    if(LIA_ID > 0){
        
        $("#selFolha").html("<option value=''>CARREGANDO...</option>");
        $("#selFolha").trigger('chosen:updated');

        $.ajax({
            type: "POST",
            url: controladorFolha,
            dataType: "json",
            async: false,
            data: {
                ACO_Descricao: "Consultar", 
                LIA_ID: LIA_ID
            }
        })
        .done(function( data ) {        
            if(data.sucesso == "true"){                

                var html = '<option value=""></option>';
                for(var i=0; i<data.rows.length; i++){ 
                    html += '<option value="' + data.rows[i].FAU_ID + '">' + data.rows[i].FAU_NumeroFolha+ '</option>';
                }
                $("#selFolhaPesquisa").html(html);
                $("#selFolhaPesquisa").trigger('chosen:updated');

            }else{
                //$("#fieldsetDataCasamento").hide();
                $("#selFolhaPesquisa").html("<option value=''></option>");
                $("#selFolhaPesquisa").trigger('chosen:updated');
            }
        });        
    }else{
        $("#selFolhaPesquisa").html("<option value=''></option>");
        $("#selFolhaPesquisa").trigger('chosen:updated');
    }
    
}


function mudaEditTipoPessoa (){
    if($("#tipoPessoaLinha").val() == "F"){
        $("#lbCpfCnpj").val("CPF");
        $("#txtCpfCnpj").mask("999.999.999-99");
        $("#txtCpfCnpj").prop("placeholder", "999.999.999-99");
    }else{
        $("#lbCpfCnpj").val("CNPJ");
        $("#txtCpfCnpj").mask("99.999.999/9999-99");
        $("#txtCpfCnpj").prop("placeholder", "99.999.999/9999-99");
    }
}