// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/patrimonio/controladores/PatrimonioControlador.php";
var dg           = $('#grid');
var selecionarTodos; // flag que controle se o botão "Selecionar Todos" foi clicado ou não
var strBase64FotoUpload = null;
// inicialização
function init(){
    // cria as tabs
    $('#tabs').tabs();
    $('#tabs-formulario').tabs();
    $("#txtDataAquisicao").mask("99/99/9999");
    $("#txtDataExpiracaoGarantia").mask("99/99/9999");
    $("#txtQuantidade").numeric();
    $("#txtDataAquisicao").datepicker();
    $("#txtDataExpiracaoGarantia").datepicker();
    
    $('#txtValorEstimado').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    }); 
    
    // Dialog
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
    
    $("#dialog-add-grupo").dialog({
        autoOpen: false,
        width: 800,
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
    
    $("#fileFoto").change(function(){
        readImage(this);
    });
    
    
    $("#selTipo").change(function(){
        if($("#selTipo").val() > 0){
            $("#btAddItemTipoPatrimonio").show();            
        }else{
            $("#btAddItemTipoPatrimonio").hide();
        }        
    });
    $("#selTipo").trigger("change");
        
        // configura o grid
    initGRID();   
      
    // carrega o grid
    consultar(); 
    
    getItemPatrimonioDinamico();
    getFornecedoresDinamico();

}


function readImage(input) { 
    if ( input.files && input.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {            
            var totalBits = e.target.result.length;            
            var totalKilobits = totalBits/1024;
            var totalMegaBits = totalKilobits/1024;
            if(totalMegaBits < 1.0000){
                //com isso aqui se pode exibir a imagem antes mesmo de ser feito o upload da mesma
                $( "#imgFotoSalvar" ).prop("src", e.target.result);
                strBase64FotoUpload = e.target.result;
                $('#hddFoto').val(e.target.result);
            }else{
                $( "#imgFotoSalvar" ).prop("src", "../../../modulos/sistema/home/img/bloqueio.png");                
                $("#dialog-atencao").html("Atenção, a imagem deverá ser de até 1MB.");
                $('#dialog-atencao').dialog('open');
                $('#hddFoto').val(null);
                strBase64FotoUpload = null;
            }
        };       
        FR.readAsDataURL( input.files[0] );
    }
}

/*
function adicionarNovoGrupo(){
    
    $("#dialog-add-grupo").load("../../administrativo/patrimonio/frmTipoPatrimonio.php");
    $("#dialog-add-grupo").dialog("open");
}
*/
function consultar(){ 
    dg.datagrid('getTbody').empty();
    
    var data = checarPermissao("ChecarPermissao", formularioID, "Consultar");    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");         
    }else{
        // FILTROS
        var limitConsulta     = 20; // limit padrão 
        var pesquisaCondicao  = $("#selPesquisaCondicao").val();
        var pesquisaTipo      = $("#selPesquisaTipo").val();
        var pesquisaItem      = $("#selPesquisaItem").val();
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();   
        

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            PTM_Descricao: pesquisaDescricao,
            PTM_Condicao: pesquisaCondicao,
            TIP_ID: pesquisaTipo,   
            IPT_ID: pesquisaItem,
            limit: limitConsulta,
            GRID: true,
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
                ACO_Descricao: "Consultar",
                GRID: true
            }
        }
        ,ajaxMethod: "POST"
        ,pagination: true
        ,autoLoad: false 
        ,uniqueRow: false
        ,rowNumber: false
        ,onClickRow: function(row) {
            $(this).datagrid('selectRow',row);
        }
        ,toolBarButtons: [
            {
                label: 'Alterar'
                ,icon: 'pencil'
                ,fn: function() {
                    if(dg.datagrid('getSelectedRows').length == 1){
                        preLoadingOpen(null);
                        
                        // armazena o ID do registro para informar
                        // ao controlador qual registro será modificado
                        $("#hddID").val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML); 
                        
                        // verifica se ainda está em aberto
                        // caso esteja em execução a operação não é
                        // permitida 
                        $.post(controlador, {
                            ACO_Descricao: "Consultar",
                            PTM_ID: $("#hddID").val()
                        },
                            function(data) {                                
                                if(data.sucesso == "true"){
                                    $("#hddID").val(data.rows[0].PTM_ID);
                                    
                                    $("#selTipo").val(data.rows[0].TIP_ID);
                                    consultarItensDoGrupo();
                                    
                                    if(data.rows[0].PTM_Foto.length > 0 ){
                                        $( "#imgFotoSalvar" ).prop("src", data.rows[0].PTM_Foto);                                    
                                        $('#hddFoto').val(data.rows[0].PTM_Foto);
                                    }else{
                                        $( "#imgFotoSalvar" ).prop("src", "../../../modulos/sistema/home/img/bloqueio.png");                                    
                                        $('#hddFoto').val(null);
                                    }                                    
                                    $("#selItem").val(data.rows[0].IPT_ID);
                                    $("#selFormaAquisicao").val(data.rows[0].FRA_ID);                                                                        
                                    $("#txtQuantidade").val(data.rows[0].PTM_Quantidade);                                    
                                    $("#txtDescricao").val(data.rows[0].PTM_Descricao);                                    
                                    $("#txtFabricante").val(data.rows[0].PTM_Fabricante);                                    
                                    $("#selFornecedor").val(data.rows[0].FOR_ID);
                                    $("#txtDataAquisicao").val(data.rows[0].PTM_DataAquisicao);
                                    $("#txtDataExpiracaoGarantia").val(data.rows[0].PTM_DataExpiracaoGarantia);
                                    $("#selCondicao").val(data.rows[0].PTM_Condicao);
                                    $("#txtObservacao").val(data.rows[0].PTM_Observacao);
                                    $("#txtValorEstimado").val(data.rows[0].PTM_ValorEstimado);
                                    $("#selSituacao").val(data.rows[0].PTM_Situacao);
                                    $("#selUnidadeCongregacao").val(data.rows[0].UNI_Localizacao_ID);
                                    
                                    $('#tabs').tabs('option', 'active', 1);
                                }else{
                                    $("#dialog-atencao").html(data.mensagem);        
                                    $("#dialog-atencao").dialog("open");
                                }
                                
                                preLoadingClose();
                            }, "json"
                        );
                    }else{
                       
                        if(dg.datagrid('getSelectedRows').length == 0){
                            $("#dialog-atencao").html("Por favor, selecione o registro que deseja alterar.");        
                            $("#dialog-atencao").dialog("open"); 
                        }else{
                            $("#dialog-atencao").html("Para alterar é necessário que selecione apenas um registro.");        
                            $("#dialog-atencao").dialog("open"); 
                        }
                       
                    }
                }
            },{
                label: 'Excluir'
                ,icon: 'closethick'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){                        
                        $("#dialog-excluir").dialog("open"); 
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja excluir.");
                        $("#dialog-atencao").dialog("open");
                    }                    
                }
            },{
                label: 'Gerar Etiquetas'
                ,icon: 'grip-dotted-vertical'
                ,fn: function(){                    
                    if(dg.datagrid('getSelectedRows').length > 0){
                        // monta um array com os selecionados
                        var ids = new Array();

                        for(var i=0; i<dg.datagrid('getSelectedRows').length; i++){
                            ids.push(dg.datagrid('getSelectedRows')[i].cells[0].innerHTML); 
                        }
                        
                        var stringIds = '';
                        var divisao = '';
                        
                        for(var i=0; i<ids.length; i++){
                            stringIds += divisao + ids[i];
                            divisao = ',';
                        }
                        
                        var url = "../../administrativo/patrimonio/impressaoEtiqueta.php?PTM_ID_IN=" + stringIds;
                        novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
                    }else{
                        $("#dialog-atencao").html("Por favor, marque o(s) registro(s) que deseja gerar as etiquetas.");        
                        $("#dialog-atencao").dialog("open");      
                    }
                }
            },
            
            {
                label: 'Impressão Individual'
                ,icon: 'print'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length == 1){
                        imprimir();
                    }else{
                        if(dg.datagrid('getSelectedRows').length == 0){
                            $("#dialog-atencao").html("Por favor, selecione o registro que deseja imprimir.");        
                            $("#dialog-atencao").dialog("open"); 
                        }else{
                            $("#dialog-atencao").html("É necessário selecionar apenas um registro.");        
                            $("#dialog-atencao").dialog("open"); 
                        }
                    }
                }
            },
            {
                label: 'Imprimir Resultado'
                ,icon: 'print'
                ,fn: function(){
                    imprimirConsulta();
                }
            }
        ]
        ,mapper:[{
            name: 'PTM_ID', title: 'ID', width: 40, align: 'left'
        },{
            name: 'PTM_NumeroTombamento', title: 'Nº. Tombamento', width:110, align: 'center'
        },{
            name: 'TIP_Descricao', title: 'Grupo', width: 150, align: 'left'
        },{
            name: 'IPT_Descricao', title: 'Subgrupo', width: 120, align: 'left'
        },{        
            name: 'PTM_Descricao', title: 'Descrição do patrimônio', width: 330, align: 'left'
        },{
            name: 'PTM_ValorEstimado', title: 'Valor(R$)', width:120, align: 'right'
        },{
            name: 'FRA_Descricao', title: 'Aquisi&ccedil;&atilde;o', width:90, align: 'center'
        },{
            name: 'PTM_Condicao', title: 'Condição', width:90, align: 'center'
        }]
    });
}

function consultarItensDoGrupo(){     
    preLoadingOpen("Carregando subgrupos, aguarde...");    
    
    if($("#selTipo").val()> 0){
        $.ajax({
            type: "POST",
            url: "../../administrativo/patrimonio/controladores/ItemPatrimonioControlador.php",
            dataType: "json",
            async: false,
            data: {ACO_Descricao: "Consultar", TIP_ID: $("#selTipo").val()}
        })
        .done(function( data ) {            
            $("#selItem").html("");
             if(data.sucesso == "true"){
                for(var i=0; i<data.rows.length; i++){
                    $("#selItem").append('<option value="' + data.rows[i].IPT_ID + '">' + data.rows[i].IPT_Descricao + '</option>');
                }
                $("#selItem").prop("disabled", false);
            }else{                
                $("#selItem").prop("disabled", true); 
            }
        });
    }else{
        $("#selItem").html("");
        $("#selItem").prop("disabled", true); 
    }
    
    preLoadingClose();
}

function selecionarTodos(){
    if($("#ckbSelecionarTodos").is(":checked")){
        dg.datagrid('clearAllRows');
        dg.datagrid('selectAllRows');
    }else{
        dg.datagrid('clearAllRows');
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
        PTM_ID: ids
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

function salvar(){
    var acaoExecutada = "Salvar"; 
    
    // caso o elemento hddID venha com algum valor preenchido
    // o sistema entenderá que a ação que será executada 
    // é o ALTERAR
    if($.trim($("#hddCodigo").val()) != ""){
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
        $("#dialog-atencao").html("Por favor, selecione o grupo do patrimônio.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selItem').val()) == ""){        
        $("#hddFocus").val("selItem");
        $("#dialog-atencao").html("Por favor, selecione o subgrupo do patrimônio.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selFornecedor').val()) == ""){        
        $("#hddFocus").val("selFornecedor");
        $("#dialog-atencao").html("Por favor, informe um fornecedor.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selFormaAquisicao').val()) == ""){        
        $("#hddFocus").val("selFormaAquisicao");
        $("#dialog-atencao").html("Por favor, selecione a forma de aquisição.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    var valor = $.trim($('#txtValorEstimado').val());
    if((valor == "") || (valor == "0,00")){        
        $("#hddFocus").val("selCondicao");
        $("#dialog-atencao").html("Por favor, informe o valor estimado.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selCondicao').val()) == ""){        
        $("#hddFocus").val("selCondicao");
        $("#dialog-atencao").html("Por favor, selecione a condição.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    
    
    //preLoadingOpen("Gravando, aguarde...");
    
    // bind form using ajaxForm 
    $('#frmFormulario').ajaxForm({
        // dataType identifies the expected content type of the server response 
        dataType:  'json', // Comentar essa linha para debugar
        // success identifies the function to invoke when the server response 
        // has been received
        success: function(data){
            //preLoadingClose();
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
    $("#hddFoto").val("");    
    $( "#imgFotoSalvar" ).prop("src", "../../../modulos/sistema/home/img/bloqueio.png");                                    
    
    $("#selItem").val("");
    $("#selFormaAquisicao").val("");

    $("#txtQuantidade").val("");                                    
    $("#txtDescricao").val("");                                    
    $("#txtFabricante").val("");                                    
    $("#selFornecedor").val(""); 
    
    $("#selTipo").val("");
    $("#selItem").val("");
    $("#selFormaAquisicao").val("");    
    $("#txtDataAquisicao").val("");
    $("#txtDataExpiracaoGarantia").val("");
    $("#selCondicao").val("");
    $("#txtObservacao").val("");
    $("#txtValorEstimado").val("0,00"); 
    $("#selUnidadeCongregacao").val("0,00"); 
    $("#selSituacao").val("");
    $("#selTipo").trigger("change");
}

function imprimir(){
    var txtArrayIds="";
    for(var i=0; i<dg.datagrid('getSelectedRows').length; i++){
        txtArrayIds += dg.datagrid('getSelectedRows')[i].cells[0].innerHTML;        
        if(i<(dg.datagrid('getSelectedRows').length - 1) ){
            txtArrayIds += "|";
        }
    }
    var url = "../../administrativo/patrimonio/documentos/FichaPatrimonio.php?ID=" + txtArrayIds;
    novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
}

function imprimirConsulta(){     
    var pesquisaCondicao  = $("#selPesquisaCondicao").val();
    var pesquisaTipo      = $("#selPesquisaTipo").val();
    var pesquisaItem      = $("#selPesquisaItem").val();
    

    var url = "../../administrativo/patrimonio/documentos/ListaPatrimonio.php?PTM_Condicao="+pesquisaCondicao+"&TIP_ID="+pesquisaTipo+"&IPT_ID="+pesquisaItem;
    novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
}

function getItemTipoPatrimonioDinamico(){      
    if($("#selTipo").val() > 0){
            $.ajax({
                type: "POST",
                url: "../../administrativo/patrimonio/controladores/TipoPatrimonioControlador.php",
                dataType: "json",
                async: false,
                data: {ACO_Descricao: "Consultar", IPT_Status: "A", TIP_ID: $("#selTipo").val() }
            })
            .done(function( data ) {       
                $("#selItem").html("<option value=''></option>");        
                if(data.sucesso == "true"){            
                    var html = '';            
                    for(var i=0; i<data.rows.length; i++){ 
                        html += '<option value="' + data.rows[i].IPT_ID + '">' + data.rows[i].IPT_Descricao + '</option>';
                    }
                    $("#selTipo").append(html);
                    $("#selTipo").trigger('chosen:updated');
                }        
            });
    }
    
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

function getFornecedoresDinamico(){      
    $.ajax({
        type: "POST",
        url: "../../administrativo/financeiro/controladores/FornecedorControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", FOR_Status: "A"}
    })
    .done(function( data ) {       
        $("#selFornecedor").html("<option value=''></option>");        
        if(data.sucesso == "true"){            
            var html = '';            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].FOR_ID + '">' + data.rows[i].FOR_NomeFantasia + '</option>';
            }
            $("#selFornecedor").append(html);
            $("#selFornecedor").trigger('chosen:updated');
        }        
    });
}