// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controladorTipoLinha  = "../../livroRegistro/tipo-linha-livro/controladores/TipoLinhaLivroControlador.php";
var controladorFolha  = "../../livroRegistro/livro-previo/controladores/FolhaPrevioControlador.php";
var controlador  = "../../livroRegistro/livro-previo/controladores/LinhaPrevioControlador.php";
var controladorFolhaAuxiliar  = "../../livroRegistro/livro-auxiliar/controladores/FolhaAuxiliarControlador.php";
var dg           = $('#grid');

var permissaoPREVIO_COMPLETO = "";


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
    $('#txtCPF').mask("999.999.999-99");
    
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
    
    
    $("#dialog-alterar-stastus").dialog({
        height:400,
        width:700,
        autoOpen: false,
        buttons: {
            "Sim, eu tenho": function() {                         
                alterarStatusConclusao();
            },
            "Não": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    
    //VALIDAR EXECUCAO PELO TIPO DE USUARIO
    var acaoExecutadaTestar = "PREVIO_COMPLETO"; 
    
    // ### PERMISSAO ###
    var dataRetornoPermissaoAdm = checarPermissao("ChecarPermissao", formularioID, acaoExecutadaTestar);
    
    permissaoPREVIO_COMPLETO = dataRetornoPermissaoAdm.sucesso;
    
    if(permissaoPREVIO_COMPLETO == "false"){
        //desabilita os inputs livro e folha
        $("#fildSelectLivro").hide();
        $("#fildSelectFolha").hide();
    }else{
        $("#fildSelectLivro").show();
        $("#fildSelectFolha").show();
    }
    
    
   // configura o grid
    initGRID();   
      
    // carrega o grid
    consultar();     
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


function consultar(){ 
    dg.datagrid('getTbody').empty();
    
    var data = checarPermissao("ChecarPermissao", formularioID, "Consultar");    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");         
    }else{
        // FILTROS
        var limitConsulta     = 20; // limit padrão 
        var idLivro = $("#selLivroPesquisa").val();    
        var idFolha = $("#selFolhaPesquisa").val();    
        
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();    
        var pesquisaStatus    = $("#selPesquisaStatus").val();    
        var pesquisaTipo    = $("#selTipoPesquisa").val();    
        var pesquisaGuia    = $("#txtPesquisaGuia").val();    
        var pesquisaProto    = $("#txtPesquisaProto").val();    

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            LPR_Descricao: pesquisaDescricao,
            LIP_ID: idLivro,
            FPR_ID: idFolha,
            LPR_Guia: pesquisaGuia,
            LPR_ProtocoloRecepcao:pesquisaProto,
            
            /*LPR_Tipo: pesquisaTipo,
            LPR_Status: pesquisaStatus,*/
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
                            LPR_ID: $("#hddID").val()
                        },
                            function(data){                                
                                
                                if(data.sucesso == "true"){
                                    
                                    $("#hddID").val(data.rows[0].LPR_ID);
                                    
                                    //é usuario restrito... esconde o livro e a linha
                                    if(permissaoPREVIO_COMPLETO == "false"){
                                        $("#hddFolhaEditar").val(data.rows[0].FPR_ID);
                                        $("#fildSelectLivro").hide();
                                        $("#fildSelectFolha").hide();
                                    }else{                                        
                                        $("#hddFolhaEditar").val(data.rows[0].FPR_ID);
                                        console.log(data.rows[0].LIP_ID);
                                        $("#selLivro").val(data.rows[0].LIP_ID);
                                        $("#selLivro").trigger('chosen:updated');
                                        preencheFolha();
                                        
                                        $("#selFolha").val(data.rows[0].FPR_ID);
                                        console.log(data.rows[0].FPR_ID);
                                        $("#selFolha").trigger('chosen:updated');
                                        
                                        $("#fildSelectLivro").show();
                                        $("#fildSelectFolha").show();
                                    }
                                    
                                    
                                    
                                    
                                    $("#selTipoLinha").val(data.rows[0].TIL_ID);
                                    $("#selTipoLinha").trigger('chosen:updated');
                                    
                                    $("#txtDescricao").val(data.rows[0].LPR_Descricao);
                                    $("#txtGuia").val(data.rows[0].LPR_Guia);
                                    $("#txtProtocolo").val(data.rows[0].LPR_ProtocoloRecepcao);
                                    $("#txtQuantidade").val(data.rows[0].LPR_Quantidade);
                                    $("#txtCPF").val(data.rows[0].LPR_Cpf);
                                    $("#txtNome").val(data.rows[0].LPR_Nome);
                                    $("#txtData").val(data.rows[0].LPR_Data);
                                    $("#txtValor").val(data.rows[0].LPR_Valor);
                                    
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
            },{
                label: 'Alterar status'
                ,icon: 'closethick'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows')[0].cells[8].innerHTML == "SIM"){
                        
                        $("#dialog-atencao").html("Por favor, só é possivel alterar o status de conclusão se o status atual estiver como NÃO!");
                        $("#dialog-atencao").dialog("open");
                    }else{
                        if(dg.datagrid('getSelectedRows').length > 0){
                            $("#selTipoLinha").html("<option value=''></option>");
                            $("#selTipoLinha").trigger('chosen:updated');                        
                            $("#selTipoLinha").attr("data-placeholder", "SELECIONE O TIPO DE LINHA" );

                            $("#ckbTipoReceita").prop("checked", false);
                            $("#ckbTipoDespesa").prop("checked", false);

                            $("#dialogMensagemAlterarStatus").html("Escolha o tipo de linha auxiliar que ira ser gerada:");
                            $("#dialog-alterar-stastus").dialog("open");
                        }else{
                            $("#dialog-atencao").html("Por favor, selecione o registro que deseja alterar o status.");
                            $("#dialog-atencao").dialog("open");
                        }
                    }
                }
            }
        ]
        ,mapper:[{
            name: 'LPR_ID', title: 'Cód.', width: 60, align: 'center'
        },{
            name: 'Livro', title: 'Livro', width: 60, align: 'center'        
        },{
            name: 'Folha', title: 'Folha', width: 60, align: 'center'
        },{
            name: 'LPR_Nome', title: 'Nome', width: 200, align: 'left'                
        },{
            name: 'LPR_Cpf', title: 'CPF', width: 100, align: 'left'                
        },{
            name: 'LPR_Descricao', title: 'Descrição', width: 200, align: 'left'        
        },{
            name: 'LPR_Guia', title: 'Guia', width: 120, align: 'left'        
        },{
            name: 'LPR_Data', title: 'Data', width: 80, align: 'left'
        },{
            name: 'LPR_StatusConclusao', title: 'Status Conclusão', width: 70, align: 'center', render: function(d) {
                var tipo = 'SIM';
                if(d == "N"){
                    tipo = "NÃO";
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
    
    
    
    
    if(permissaoPREVIO_COMPLETO == "true"){
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
    
    /*
    if($.trim($('#selTipoLinha').val()) == ""){        
        $("#hddFocus").val("selTipoLinha");
        $("#dialog-atencao").html("Por favor, informe o tipo.");        
        $("#dialog-atencao").dialog("open");
        return;
    } */
    
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
    
    if(permissaoPREVIO_COMPLETO == "false"){        
        $("#fildSelectLivro").hide();
        $("#fildSelectFolha").hide();
    }else{
        $("#fildSelectLivro").show();
        $("#fildSelectFolha").show();
    }
    
    $("#txtDescricao").val("");
    $("#txtNome").val("");
    $("#txtGuia").val("");
    $("#txtProtocolo").val("");
    $("#txtQuantidade").val("");
    $("#txtCPF").val("");
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
        LPR_ID: id
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

function alterarStatusConclusao(){
    var TIL_ID = $("#selTipoLinha").val();    
    
    var FAU_ID = $("#selFolhaAuxiliar").val();
    
    var acaoExecutada = "StatusConclusaoLinhaPrevio"; 
    
    // ### PERMISSAO ###
    var data = checarPermissao("ChecarPermissao", formularioID, acaoExecutada);
    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim(FAU_ID) == ""){        
        $("#hddFocus").val("selFolhaAuxiliar");
        $("#dialog-atencao").html("Por favor, informe a folha da linha a ser criada.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(!consultarPermissaoSalvarFolhaAlterarStatus(FAU_ID) ){
        $("#hddFocus").val("selFolha");
        $("#dialog-atencao").html("Folha com o total de linhas já preenchido, por favor, escolha outra.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    
    
    if($.trim(TIL_ID) == ""){        
        $("#hddFocus").val("selTipoLinha");
        $("#dialog-atencao").html("Por favor, informe o tipo da linha a ser criada.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // monta um array com os selecionados
    var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;

    $.post(controlador, {
        ACO_Descricao: "AlterarStatusConclusao",
        LPR_ID: id,
        TIL_ID: TIL_ID,
        FAU_ID: FAU_ID
    },
        function(data) {
            var dialog = "dialog-sucesso";

            if(data.excecao == "true"){
                dialog = "dialog-excecao";                 
            }   

            $("#dialog-alterar-stastus").dialog("close");

            $("#" + dialog).html(data.mensagem);
            $("#" + dialog).dialog("open");
        }, "json"
    );
}










function preencheFolha(){
    var LIP_ID = $('#selLivro').val();
    if(LIP_ID> 0){        
        $("#selFolha").html("<option value=''>CARREGANDO...</option>");
        $("#selFolha").trigger('chosen:updated');

        $.ajax({
            type: "POST",
            url: controladorFolha,
            dataType: "json",
            async: false,
            data: {
                ACO_Descricao: "Consultar", 
                LIP_ID: LIP_ID
            }
        })
        .done(function( data ) {        
            if(data.sucesso == "true"){                

                var html = '<option value=""></option>';
                for(var i=0; i<data.rows.length; i++){ 
                    html += '<option value="' + data.rows[i].FPR_ID + '">' + data.rows[i].FPR_NumeroFolha+ '</option>';
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
            data: {FPR_ID: idFolha, ACO_Descricao: "GetPermissaoAddLinhaFolha"}
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



//ver pra consultar o livro pode receber a folha no cadastro e na edição
function consultarPermissaoSalvarFolhaAlterarStatus(idFolha){
    var retorno = false;
    $.ajax({
        type: "POST",
        url: controladorFolhaAuxiliar,
        dataType: 'json',
        cache: false,
        async:false,    
        data: {FPR_ID: idFolha, ACO_Descricao: "GetPermissaoAddLinhaFolha"}
    }).done(function( data ) { 
        console.log(data);
        if(data.sucesso == "true"){                                       
            retorno = true;                
        }else{            
            retorno = false;
        }
    });
    return retorno;
}






function preencheFolhaPesquisa(){
    var LIP_ID = $('#selLivroPesquisa').val();
    
    if(LIP_ID > 0){
        $("#selFolhaPesquisa").html("<option value=''>CARREGANDO...</option>");
        $("#selFolhaPesquisa").trigger('chosen:updated');

        $.ajax({
            type: "POST",
            url: controladorFolha,
            dataType: "json",
            async: false,
            data: {
                ACO_Descricao: "Consultar", 
                LIP_ID: LIP_ID
            }
        })
        .done(function( data ) {        
            if(data.sucesso == "true"){                

                var html = '<option value=""></option>';
                for(var i=0; i<data.rows.length; i++){ 
                    html += '<option value="' + data.rows[i].FPR_ID + '">' + data.rows[i].FPR_NumeroFolha+ '</option>';
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
















function preencheFolhaAuxiliar(){
    var LIA_ID = $('#selLivroAuxiliar').val();
    if(LIA_ID> 0){        
        $("#selFolhaAuxiliar").html("<option value=''>CARREGANDO...</option>");
        $("#selFolhaAuxiliar").trigger('chosen:updated');

        $.ajax({
            type: "POST",
            url: controladorFolhaAuxiliar,
            dataType: "json",
            async: false,
            data: {
                ACO_Descricao: "Consultar", 
                LIA_ID: LIA_ID
            }
        })
        .done(function( data ) {    
            console.log(data);
            if(data.sucesso == "true"){                

                var html = '<option value=""></option>';
                for(var i=0; i<data.rows.length; i++){ 
                    html += '<option value="' + data.rows[i].FAU_ID + '">' + data.rows[i].FAU_NumeroFolha+ '</option>';
                }
                $("#selFolhaAuxiliar").html(html);
                $("#selFolhaAuxiliar").trigger('chosen:updated');

            }else{
                //$("#fieldsetDataCasamento").hide();
                $("#selFolhaAuxiliar").html("<option value=''></option>");
                $("#selFolhaAuxiliar").trigger('chosen:updated');
            }
        });
    }else{
        $("#selFolhaAuxiliar").html("<option value=''></option>");
        $("#selFolhaAuxiliar").trigger('chosen:updated');
    }
}