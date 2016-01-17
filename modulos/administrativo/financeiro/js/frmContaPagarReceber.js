// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID            = $("#hddFormularioID").val(); 
var controlador             = "../../administrativo/financeiro/controladores/ContaPagarReceberControlador.php";
var controladorFormaPgto    = "../../administrativo/financeiro/controladores/FormaPagamentoControlador.php";
var dg                      = $('#grid');
var caminhoAbrirAnexo;
    
// inicialização
function init(){
    // tabs
    $('#tabs').tabs();
         
    $("#txtPesquisaDataInicial").mask("99/99/9999"); 
    $("#txtPesquisaDataInicial").datepicker();
    
    $("#txtPesquisaDataFinal").mask("99/99/9999"); 
    $("#txtPesquisaDataFinal").datepicker();
    
    $("#txtDataVencimento").mask("99/99/9999"); 
    $("#txtDataVencimento").datepicker();
    
    $(".campoDataParcela").mask("99/99/9999"); 
    $(".campoDataParcela").datepicker();
    
    $("#txtQuantidadeParcelas").numeric();
    $("#txtNumeroInicialDocumentoParcela").numeric();
        
    $('#txtValor').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
    $('.campoValor').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
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
    
    $('#dialog-sucesso-pagamento').dialog({
        autoOpen: false,
        buttons: {
            "Ok": function() {   
                if(dg.datagrid('getSelectedRows').length > 0){
                    var idConta = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;
                    abrirParcelas(idConta);
                    $(this).dialog("close"); 
                }
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
    
    $('#dialog-imegem-conta').dialog({
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
    
    $("#dialog-parcelas").dialog({
        autoOpen: false,
        buttons: {
            "Ok": function() {                         
                gerarParcelas();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    
    $("#dialog-baixa").dialog({
        autoOpen: false,
        closeOnEscape: false,
        width: 600,
        buttons: {            
            "Cancelar": function() {  
                consultar();
                $(this).dialog("close"); 
            }
        },
        open: function(event, ui){ 
            $(".ui-dialog-titlebar-close").hide();
        }
    });
    
    $("#dialog-pagamento").dialog({
        autoOpen: false,
        width: 700,
        height: 650,
        buttons: {
            "Pagar": function() {                         
                efetuarPagamento();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    
    // fotos
    $("#dialogFoto1").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        width:776,
        height:510,        
        modal: true,
        buttons: {
            "Cancelar": function() {                              
                $(this).dialog( "close" );
            }
        },
        open: function() 
        {  
            $('#dialogFoto1Camera').photobooth().on("image", function( event, dataUrl ){
                $("#imgFoto1").prop("src", dataUrl);
                $("#hddFoto1").val(dataUrl);
                $("#dialogFoto1").dialog("close");
                
                $("#lightboxFoto1").prop("href", dataUrl);
            }).forceHSB = true;
        }, close: function(){            
            $('#dialogFoto1Camera').data("photobooth").destroy();
        }
    });
    
    // fotos
    $("#dialogFotoParcela").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        width:776,
        height:510,        
        modal: true,
        buttons: {
            "Cancelar": function() {                              
                $(this).dialog( "close" );
            }
        },
        open: function() 
        {  
            $('#dialogFotoParcelaCamera').photobooth().on("image", function( event, dataUrl ){
                $("#imgFotoParcela").prop("src", dataUrl);
                $("#hddFotoparcela").val(dataUrl);
                $("#dialogFotoParcela").dialog("close");
                
                $("#lightboxFotoParcela").prop("href", dataUrl);
            }).forceHSB = true;
        }, close: function(){            
            $('#dialogFotoParcelaCamera').data("photobooth").destroy();
        }
    });
    
    initGRID();
    consultar();
    
    gerenciarTipo();
    gerenciarTipoOrigemPesquisa();
    
    // dinâmico
    //getCentroCustoDinamico();
    //getPlanoContasDinamico();
    //getFornecedorDinamico();
    
    $("input:radio[name=tipoAnexo]").click(function() {        
        var value = $(this).val();        
        if(value=="arquivo"){
            $("#linhaFoto").hide();
            $("#linhaArquivo").show();
        }else{            
            $("#linhaArquivo").hide();
            $("#linhaFoto").show();
        }
    });
    $("#linhaArquivo").hide();
    $("#arquivoExistente").hide();
    $("#linhaFoto").show();
    
    
    $("input:radio[name=tipoAnexoParcela]").click(function() {        
        var value = $(this).val();        
        if(value=="arquivo"){
            $("#colunaFoto").hide();
            $("#colunaArquivo").show();
        }else{            
            $("#colunaArquivo").hide();
            $("#colunaFoto").show();
        }
    });
    $("#colunaArquivo").hide();    
    $("#colunaFoto").show();
    
    
    
}

function janelaFoto1(){
    $("#dialogFoto1").dialog("open");
}
function janelaFotoParcela(){
    $("#dialogFotoParcela").dialog("open");
}


function removerFoto1(){
    $("#imgFoto1").prop("src", "../../../modulos/sistema/home/img/contas.png");
    $("#hddFoto1").val("");
}

function removerFotoParcela(){
    $("#imgFotoParcela").prop("src", "../../../modulos/sistema/home/img/contas.png");
    $("#hddFotoparcela").val("");
}

function gerenciarTipoOrigemPesquisa(){
    var tipo = $('input:radio[name=CON_OrigemPesquisa]:checked').val();
    
    if(tipo == "F"){
        $("#colunaPesquisaPessoa").hide();
        $("#colunaPesquisaFornecedor").show();
        $("#selPesquisaFornecedor").val("");
        $("#selPesquisaFornecedor").trigger('chosen:updated');
        
        getFornecedorDinamico();
    }else{
        $("#colunaPesquisaFornecedor").hide();
        $("#colunaPesquisaPessoa").show();        
        $("#selPesquisaPessoa").val("");
        $("#selPesquisaPessoa").trigger('chosen:updated');
        
        getPessoaDinamico();
    }
}

function gerenciarTipo(){
    var tipo = $('#selTipo').val();
    
    if(tipo == "P"){
        $("#colunaAReceber").hide();
        $("#colunaAPagar").show();
        $("#selFornecedor").val("");
        $("#selFornecedor").trigger('chosen:updated');
    }else{
        $("#colunaAPagar").hide();
        $("#colunaAReceber").show();
        
        gerenciarTipoOrigemContaAReceber();
    }
}

function gerenciarTipoOrigemContaAReceber(){
    var tipo = $('input:radio[name=CON_TipoOrigem]:checked').val();
    
    if(tipo == "F"){
        $("#colunaOrigemPessoa").hide();
        $("#colunaOrigemFornecedor").show();
        $("#selOrigemFornecedor").val("");
        $("#selOrigemFornecedor").trigger('chosen:updated');
        
        getFornecedorDinamico();
    }else{
        $("#colunaOrigemFornecedor").hide();
        $("#colunaOrigemPessoa").show();        
        $("#selOrigemPessoa").val("");
        $("#selOrigemPessoa").trigger('chosen:updated');
        
        getPessoaDinamico();
    }
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
    if($('#txtValor').val() == "" || $('#txtValor').val() == "0,00"){
        $("#hddFocus").val("txtValor");
        $("#dialog-atencao").html("Por favor, informe o valor da conta.");        
        $("#dialog-atencao").dialog("open");
        return;
    }    
    
    if($.trim($('#txtDescricao').val()) == ""){        
        $("#hddFocus").val("txtDescricao");
        $("#dialog-atencao").html("Por favor, informe o hist&oacute;rico.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selPlanoConta').val()) == ""){        
        $("#hddFocus").val("selPlanoConta");
        $("#dialog-atencao").html("Por favor, informe o plano de contas.");        
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    if($.trim($('#selCentroCusto').val()) == ""){        
        $("#hddFocus").val("selCentroCusto");
        $("#dialog-atencao").html("Por favor, informe o centro de custo.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    /*if($.trim($('#selFornecedor').val()) == ""){        
        $("#hddFocus").val("selFornecedor");
        $("#dialog-atencao").html("Por favor, informe o fornecedor.");        
        $("#dialog-atencao").dialog("open");
        return;
    }*/
    if($("#selTipo").val() == "R"){
        var tipoOrigem = $('input:radio[name=CON_TipoOrigem]:checked').val();

        if(tipoOrigem == "P"){
            if($("#selOrigemPessoa").val() == ""){
                $("#hddFocus").val("selOrigemPessoa");
                $("#dialog-atencao").html("Por favor, informe o membro/funcion&aacute;rio.");
                $("#dialog-atencao").dialog("open");        
                return;
            }
        }else{
            if($("#selOrigemFornecedor").val() == ""){
                $("#hddFocus").val("selOrigemFornecedor");
                $("#dialog-atencao").html("Por favor, informe o fornecedor.");
                $("#dialog-atencao").dialog("open");        
                return;
            }        
        }
    }else{
        if($.trim($('#selFornecedor').val()) == ""){        
            $("#hddFocus").val("selFornecedor");
            $("#dialog-atencao").html("Por favor, informe o fornecedor.");        
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    if($.trim($('#lista-pacelas').html()) == ""){        
        $("#dialog-atencao").html("Por favor, gere as parcelas.");        
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
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }else{
                if(data.parcelasCorretasComTotal == "false"){
                    $("#dialog-atencao").html(data.mensagem);
                    $("#dialog-atencao").dialog("open");
                    return;
                }else{                    
                    if(data.parcelasDiferentes == "true"){                        
                        $("#dialog-atencao").html(data.mensagem);
                        $("#dialog-atencao").dialog("open");
                        return;
                    }else{
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
            } 
        } 
    }).submit();                
}

function consultar(){    
    // limpa o grid
    // desmarca as linhas
    dg.datagrid('getTbody').empty();    
        
    var data = checarPermissao("ChecarPermissao", formularioID, "Consultar");
    
    if(data.sucesso == "false"){
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");         
    }else{    
        var pesquisaEntidade    = "";
        var dataInicial   = $("#txtPesquisaDataInicial").val();
        var dataFinal     = $("#txtPesquisaDataFinal").val();
        var tipo      = $("#selPesquisaTipo").val();
        var centroCusto      = $("#selPesquisaCentroCusto").val();
        var planoConta      = $("#selPesquisaPlanoConta").val();
        var status = $("#selPesquisaStatus").val();
        var limitConsulta = 20; // limit padrÃ£o

        var pesquisaTipoEntidade = $('input:radio[name=CON_OrigemPesquisa]:checked').val();

        if(pesquisaTipoEntidade == "P"){
            pesquisaEntidade = $("#selPesquisaPessoa").val();
        }else{
            pesquisaEntidade = $("#selPesquisaFornecedor").val();
        }

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }   
        
        var params = {
            ACO_Descricao: "Consultar",
            CON_TipoEntidade: pesquisaTipoEntidade, 
            CON_EntidadeID: pesquisaEntidade,    
            CON_DataInicial: dataInicial,
            CON_DataFinal: dataFinal,
            CON_Tipo: tipo,   
            CEN_ID: centroCusto,
            PLA_ID: planoConta,
            CON_Status: status,
            limit: limitConsulta,
            offset: 0
        };
        
        // Cálculo total das ofertas e dos dizimos no período     
        $.post(controlador, params,
            function(data) {   
                console.log(data);
                if(data.sucesso == "true"){
                    $("#spnTotal").html(data.totalLancamentos);
                }else{
                    $("#spnTotal").html("0,00");
                }
            }, "json"
        );
        
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
        ,uniqueRow: true
        ,title: ''
        ,rowNumber: false
        ,onClickRow: function(row) {
            $(this).datagrid('selectRow',row);
        }
        ,toolBarButtons:[
            {
                label: 'Alterar'
                ,icon: 'pencil'
                ,fn: function(){
                    var totalSelecionado = dg.datagrid('getSelectedRows').length;
                    
                    if(totalSelecionado == 1){
                        preLoadingOpen(null);
                        
                        // armazena o ID do registro para informar
                        // ao controlador qual registro será modificado
                        $("#hddID").val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML);
                        
                        $.post(controlador, {
                            ACO_Descricao: "Consultar",
                            CON_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                     
                                    $("#txtDescricao").val(data.rows[0].CON_Descricao);                                   
                                    $("#txtNumero").val(data.rows[0].CON_Numero);
                                      
                                    $("#selTipo").val(data.rows[0].CON_Tipo);
                                    $("#selTipo").trigger('chosen:updated');
                                    
                                    getPlanoContasDinamico();
                                    
                                    /*$("#selFornecedor").val(data.rows[0].FOR_ID);
                                    $("#selFornecedor").trigger('chosen:updated');*/
                                    
                                    $("#selPlanoConta").val(data.rows[0].PLA_ID);
                                    $("#selPlanoConta").trigger('chosen:updated');
                                    
                                    $("#selCentroCusto").val(data.rows[0].CEN_ID);
                                    $("#selCentroCusto").trigger('chosen:updated');
                                    
                                    $("#txtValor").val(data.rows[0].CON_ValorTotal);
                                    $("#txtObservacao").val(data.rows[0].CON_Observacao);
                                    
                                    $("#txtQuantidadeParcelas").val(data.rows[0].CON_NumeroParcelas);
                                    
                                    gerarParcelasAlt();
                                    
                                    if(data.rows[0].CON_Tipo == "R"){
                                        gerenciarTipo();
                                        
                                        if($.trim(data.rows[0].PES_ID) != ""){
                                            $("#rdbOrigemPessoa").prop("checked", true);
                                            $("#rdbOrigemFornecedor").prop("checked", false);
                                            gerenciarTipoOrigemContaAReceber();

                                            $("#selOrigemPessoa").val(data.rows[0].PES_ID);    
                                            $('#selOrigemPessoa').trigger('chosen:updated'); 
                                        }else{
                                            if($.trim(data.rows[0].FOR_ID) != ""){
                                                $("#rdbOrigemPessoa").prop("checked", false);
                                                $("#rdbOrigemFornecedor").prop("checked", true);
                                                gerenciarTipoOrigemContaAReceber();

                                                $("#selOrigemFornecedor").val(data.rows[0].FOR_ID);    
                                                $('#selOrigemFornecedor').trigger('chosen:updated'); 
                                            }
                                        }
                                    }else{
                                        $("#selFornecedor").val(data.rows[0].FOR_ID);
                                        $("#selFornecedor").trigger('chosen:updated');
                                    }
                                    
                                    exibeFotoArquivo(data.rows[0].CON_Foto1);
                                    
                                    
                                    
                                    
                                    // verifica se a conta possui alguma parcela paga
                                    // caso possua, o usuário não poderá aletar mais esta conta
                                    if(verificarExistenciaParcelaPaga($("#hddID").val())){
                                        $("#btnSalvar").hide(); // oculta o botão Salvar, assim ele só poderá cancelar
                                    }
                                }
                                
                                $('#tabs').tabs('option', 'active', 1);
                                
                                preLoadingClose();
                            }, "json"
                        );
                    }else{
                        if(totalSelecionado == 0){
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
                        $("#dialogMensagemExcluir").html("Tem certeza que deseja remover a conta selecionada?");
                        $("#dialog-excluir").dialog("open");                 
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja excluir.");        
                        $("#dialog-atencao").dialog("open");      
                    }
                }
            },{
                label: 'Baixa de Parcelas'
                ,icon: 'check'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){
                        var idConta = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;
                        abrirParcelas(idConta);
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja realizar a baixa de parcelas.");        
                        $("#dialog-atencao").dialog("open");                           
                    }
                }
            },{
                label: 'Recibo'
                ,icon: 'print'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){
                        var idConta = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;
                        
                        $.post(controlador, {
                            ACO_Descricao: "Consultar",
                            CON_ID: idConta
                        },
                            function(data){                                
                                if(data.sucesso == "true"){
                                    if(data.rows[0].CON_Tipo == "P"){
                                        novaJanelaFullscreen("../../administrativo/financeiro/documentos/Recibo.php?cod=" + idConta);
                                    }else{
                                        $("#dialog-atencao").html("S&oacute; &eacute; permitido imprimir recibos de contas a pagar.");        
                                        $("#dialog-atencao").dialog("open");                           
                                    }
                                }
                            }, "json"
                        );                        
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja emitir o recibo.");        
                        $("#dialog-atencao").dialog("open");                           
                    }
                }
            }
        ]
        ,mapper:[{
            name: 'CON_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'CON_ProximoVencimento', title: 'Pr&oacute;ximo Venc.', width: 100, align: 'center'
        },{
            name: 'CON_DataHoraCadastro', title: 'Cadastrado em', width: 120, align: 'center'
        },{
            name: 'CON_NumeroParcelas', title: 'N&ordm; de Parcelas', width: 100, align: 'center'
        },{
            name: 'CON_ValorTotal', title: 'Valor Total (R$)', width: 100, align: 'right'
        },{
            name: 'CON_Numero', title: 'N&ordm; do Doc.', width: 80, align: 'left'
        },{
            name: 'PLA_Descricao', title: 'Plano de Contas', width: 150, align: 'left'
        },{
            name: 'CON_Descricao', title: 'Hist&oacute;rico', width: 150, align: 'left'
        },{
            name: 'CEN_Descricao', title: 'Centro de Custo', width: 100, align: 'center'
        },{
            name: 'CON_Foto_Acoes', title: 'Ações', width: 80, align: 'center', render: function(d) {                
                var imagem="<table height=35>";
                
                imagem+='<tr>';                
                    //identifica o que ta vindo no d "CON_Foto1"
                    imagem+='<td>';
                        if(d){
                            var string = d;
                            var retorno = string.split("|");
                            var idConta = retorno[1];
                            //var str = "Hello world!";
                            var str = retorno[0];
                            var res = str.substring(0, 4);
                            //console.log(res);


                            if(retorno[0]!=""){                    
                                if(res==="data"){
                                    //é uma imagem
                                    imagem+='<a href="javascript:void(0);" onclick="abrirImagemConta(\''+retorno[0]+'\');"><img src="../../sistema/home/img/contaPequeno.png " title="Visualizar anexo conta" width="25" height="25"/></a>';
                                }else{
                                    //é um arquivo
                                    imagem+='<a href="javascript:void(0);" onclick="abrirArquivo(\''+retorno[0]+'\');" target="_blank"><img src="../../sistema/home/img/contaPequeno.png " title="Visualizar anexo conta" width="25" height="25"/></a>';                    
                                }
                            }
                            imagem+='</td>';

                        }
                    imagem+='</td>';
                    imagem+='<td>';                    
                        imagem+='<a href="javascript:void(0);" onclick="abrirParcelas( '+idConta+' );"><img src="../../sistema/home/img/pagamento.png " title="Visualizar parcelas" width="25" height="25"/></a>';
                    imagem+='</td>';
                imagem+='</tr>';
                
                imagem+='</table>';                                    
                return imagem;
            }
        }]
    });
}

function exibeFotoArquivo(CON_Foto1){
    $("#hddFoto1").val("");                                    
    $("#imgFoto1").prop("src", "../../../modulos/sistema/home/img/contas.png");
    $("#lightboxFoto1").prop("href", "../../../modulos/sistema/home/img/contas.png");
    
    $("#arquivoExistente").hide();
    $("#hddAnexoConta").val("");
    $("#caminhoArquivo").prop("href", "");
    $("#caminhoArquivo").prop("href", "");
    
    
    if(CON_Foto1 != ""){
        //identifica se vem um arquivo ou uma imagem
        var str = CON_Foto1;
        var res = str.substring(0, 4);    
        if(res=="data"){
            //é uma imagem                
            $("#hddFoto1").val(CON_Foto1);
            $("#imgFoto1").prop("src", CON_Foto1);
            $("#lightboxFoto1").prop("href", CON_Foto1);

            $("#rbTipAnexoFoto").prop("checked", true);

            $("#linhaArquivo").hide();
            $("#linhaFoto").show();

        }else{
            //é um arquivo        
            $("#arquivoExistente").show();
            $("#hddAnexoConta").val(CON_Foto1);
            $("#caminhoArquivo").prop("href", CON_Foto1); 

            $("#rbTipAnexoAquivo").prop("checked", true);        
            $("#linhaFoto").hide();
            $("#linhaArquivo").show();
        }
    }
    
    
    
    return;    
}

function abrirImagemConta(d){    
    $("#imgConta").prop("src", d);    
    $("#dialog-imegem-conta").dialog("open");
}
function abrirArquivo(d){
    if(!d){
        d = $("#caminhoArquivo").prop("href");
    }
    
    
    //document.location = d;
    var url = "../../administrativo/financeiro/downloadArquivo.php?arquivo="+d;
    window.open(url,'_blank');    
}

function excluirAnexo(){
    var d = $("#caminhoArquivo").prop("href");    
    $.post(controlador, {
        ACO_Descricao: "ExcluirAnexo",
        arquivo: d,
        CON_ID: dg.datagrid('getSelectedRows')[0].cells[0].innerHTML
    },
        function(data) {  

            if(data.sucesso == "true"){                
                $("#dialog-sucesso").html(data.mensagem);        
                $("#dialog-sucesso").dialog("open");
                
                $("#arquivoExistente").hide();
                $("#hddAnexoConta").val("");
                $("#caminhoArquivo").prop("src", "");
                
            }
        }, "json"
    );
}

function abrirParcelas(idConta){
    if(!idConta){
        idConta = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;
    }    
    $.post(controlador, {
        ACO_Descricao: "ConsultarParcelas",
        CON_ID: idConta
    },
        function(data) {  

            if(data.sucesso == "true"){                                    
                $("#dialog-baixa").dialog("open");

                var html = '<table class="dadosTabela" cellpadding="5" cellspacing="5" align="center">';

                html += '<tr class="cabecalhoTabela">';
                    html += '<td align="center" style="width: 120px;">Data de Vencimento</td>';
                    html += '<td align="right" style="width: 80px;">Valor (R$)</td>';
                    html += '<td style="width: 160px;">N&ordm; do Doc.</td>';
                    html += '<td style="width: 120px;" align="center">Data da Baixa</td>';
                    html += '<td align="center">Ação</td>';
                html += '</tr>';

                var classe;

                // carrega as parcelas da conta a pagar/receber
                for(var i=0; i<data.rows.length; i++){
                    classe = "linhaNormal";

                    if(i%2 == 0){
                        classe = "linhaCor";
                    }


                    html += '<tr class="' + classe + '">';
                        html += '<td align="center">' + data.rows[i].PCL_DataVencimento + '</td>';
                        html += '<td align="right">' + data.rows[i].PCL_Valor + '</td>';
                        html += '<td>' + data.rows[i].PCL_Numero + '</td>';

                        if(data.rows[i].PCL_DataBaixa != null){
                            html += '<td align="center">' + data.rows[i].PCL_DataBaixa + '</td>';
                        }else{
                            html += '<td></td>';
                        }
                        
                        html += '<td align="center">';
                        if(data.rows[i].PCL_DataBaixa != null){
                            html += '';
                        }else{
                            html += '<a href="javascript:void(0);" onclick="abrirPagamento(' + data.rows[i].PCL_ID + ');"><img border="0" src="../../sistema/home/img/pagamento.png"/></a>';
                        }
                        
                        if(data.rows[i].PCL_Arquivo){
                            var str = data.rows[i].PCL_Arquivo;
                            var res = str.substring(0, 4);
                            if(res=="data"){
                                //é uma imagem
                                html +='<a href="javascript:void(0);" onclick="abrirImagemConta(\''+data.rows[i].PCL_Arquivo+'\');"><img src="../../sistema/home/img/contaPequeno.png " title="Visualizar anexo parcela" width="25" height="25"/></a>';
                            }else{
                                //é um arquivo
                                html +='<a href="javascript:void(0);" onclick="abrirArquivo(\''+data.rows[i].PCL_Arquivo+'\');" target="_blank"><img src="../../sistema/home/img/contaPequeno.png " title="Visualizar anexo parcela" width="25" height="25"/></a>';
                            }
                        }
                        html += '</td>';

                        
                    html += '</tr>';
                }

                html += '</table>';

                $("#dialog-baixa").html(html);
            }
        }, "json"
    );
}

function excluir(){
    var acaoExecutada = "Excluir"; 
 
    // ### PERMISSAO ###
    var data = checarPermissao("ChecarPermissao", formularioID, acaoExecutada);
        
    if(data.sucesso == "false"){
        $("#dialog-excluir").dialog("close");
        $("#dialog-atencao").html(data.mensagem);        
        $("#dialog-atencao").dialog("open");
        return;
    }      
    // monta um array com os selecionados
    var ids = new Array();

    for(var i=0; i<dg.datagrid('getSelectedRows').length; i++){
        ids.push(dg.datagrid('getSelectedRows')[i].cells[0].innerHTML); 
    }
    
    // verificar se o lançamento já está cancelado
    $.post(controlador, {
        ACO_Descricao: "Excluir",
        CON_ID: ids
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

function efetuarPagamento(){
    if($.trim($("#selFormaPagamentoParcela").val()) == ""){
        $("#hddFocus").val("selFormaPagamentoParcela");
        $("#dialog-atencao").html("Por favor, informe a forma de pagamento da parcela.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($("#txtDataPagamentoParcela").val()) == ""){
        $("#hddFocus").val("txtDataPagamentoParcela");
        $("#dialog-atencao").html("Por favor, informe a data do pagamento.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(!isDataValida($("#txtDataPagamentoParcela").val())){
        $("#hddFocus").val("txtDataPagamentoParcela");
        $("#dialog-atencao").html("Por favor, informe uma data de pagamento válida.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($("#selContaBancaria").val()) == ""){
        $("#hddFocus").val("selContaBancaria");
        $("#dialog-atencao").html("Por favor, informe a conta.");        
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    var formaPagamentoNumeroDocumento = "";
    
    if(gerenciarExigeNumeroFormaPagamento(true)){
        formaPagamentoNumeroDocumento = $("#txtFormaPagamentoNumero").val();
    }
        
    // verificar se o lançamento já está cancelado
    
    /*$('#formPagamentoParcela').ajaxForm(function(data, status, jqXHR) {
        console.log(data);
      });*/
    
    // bind form using ajaxForm 
    $('#formPagamentoParcela').ajaxForm({
        // dataType identifies the expected content type of the server response 
        dataType:  'json', // Comentar essa linha para debugar

        data: { 
            ACO_Descricao: "EfetuarPagamento",
            PCL_ID: $("#hddParcelaID").val(),
            PCL_Juros: $("#txtJurosParcela").val(),
            PCL_Mora: $("#txtMoraParcela").val(),
            PCL_Multa: $("#txtMultaParcela").val(),
            PCL_Desconto: $("#txtDescontoParcela").val(),
            PCL_ValorPago: $("#txtTotalPagoParcela").val(),
            PCL_Referencia: $("#selReferenciaParcela").val(),
            PCL_DataBaixa: $("#txtDataPagamentoParcela").val(),
            FPG_ID: $("#selFormaPagamentoParcela").val(),
            PCL_FormaPagamentoNumero: formaPagamentoNumeroDocumento,
            COB_ID: $("#selContaBancaria").val(),
            PCL_Arquivo:$("#hddFotoparcela").val() 
        },
        // success identifies the function to invoke when the server response 
        // has been received 
        success: function(data) {
            //preLoadingClose();
            
            var dialog = "dialog-sucesso";
            if(data.sucesso == "true"){
                $("#dialog-pagamento").dialog("close");
                $("#dialog-baixa").dialog("close");     

                $("#dialog-sucesso-pagamento").html("Pagamento realizado com sucesso.");        
                $("#dialog-sucesso-pagamento").dialog("open");
                return;
            }else if(data.excecao == "true"){
                dialog = "dialog-excecao"; 
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            } 
        } 
    }).submit(); 
    
    /*$.ajax({
        type: "POST",
        url: controlador,
        dataType: 'json',
        enctype: 'multipart/form-data',
        cache: false,
        async: true,    
        data: {
            ACO_Descricao: "EfetuarPagamento",
            PCL_ID: $("#hddParcelaID").val(),
            PCL_Juros: $("#txtJurosParcela").val(),
            PCL_Mora: $("#txtMoraParcela").val(),
            PCL_Multa: $("#txtMultaParcela").val(),
            PCL_Desconto: $("#txtDescontoParcela").val(),
            PCL_ValorPago: $("#txtTotalPagoParcela").val(),
            PCL_Referencia: $("#selReferenciaParcela").val(),
            PCL_DataBaixa: $("#txtDataPagamentoParcela").val(),
            FPG_ID: $("#selFormaPagamentoParcela").val(),
            PCL_FormaPagamentoNumero: formaPagamentoNumeroDocumento,
            COB_ID: $("#selContaBancaria").val(),
            PCL_Arquivo:$("#hddFotoparcela").val()
        }
    }).done(function( data ) {  
        if(data.sucesso == "true"){                                       
            $("#dialog-pagamento").dialog("close");
            $("#dialog-baixa").dialog("close");     

            $("#dialog-sucesso-pagamento").html("Pagamento realizado com sucesso.");        
            $("#dialog-sucesso-pagamento").dialog("open");  
        }
    });*/
    /*
    $.post(controlador, {
        ACO_Descricao: "EfetuarPagamento",
        PCL_ID: $("#hddParcelaID").val(),
        PCL_Juros: $("#txtJurosParcela").val(),
        PCL_Mora: $("#txtMoraParcela").val(),
        PCL_Multa: $("#txtMultaParcela").val(),
        PCL_Desconto: $("#txtDescontoParcela").val(),
        PCL_ValorPago: $("#txtTotalPagoParcela").val(),
        PCL_Referencia: $("#selReferenciaParcela").val(),
        PCL_DataBaixa: $("#txtDataPagamentoParcela").val(),
        FPG_ID: $("#selFormaPagamentoParcela").val(),
        PCL_FormaPagamentoNumero: formaPagamentoNumeroDocumento,
        COB_ID: $("#selContaBancaria").val(),
        PCL_Arquivo:$("#hddFotoparcela").val()
    },
        function(data) {             
            if(data.sucesso == "true"){
                $("#dialog-pagamento").dialog("close");
                $("#dialog-baixa").dialog("close");     
                
                $("#dialog-sucesso-pagamento").html("Pagamento realizado com sucesso.");        
                $("#dialog-sucesso-pagamento").dialog("open");  
            }
        }, "json"
    ); */
}

function cancelar(){
    $("#hddID").val("");  
    $("#hddFocus").val("");
    
    $("#txtDescricao").val("");
    $("#txtValor").val("0,00");
    $("#txtNumero").val("");
    $("#txtObservacao").val("");
    
    $("#selFornecedor").val("");
    $("#selFornecedor").trigger('chosen:updated');
    
    $("#selPlanoConta").val("");
    $("#selPlanoConta").trigger('chosen:updated');

    $("#selCentroCusto").val("");
    $("#selCentroCusto").trigger('chosen:updated');
    
    $("#txtQuantidadeParcelas").val("1");
    $("#lista-pacelas").html("");

    $("#hddFoto1").val("");    
    $("#imgFoto1").prop("src", "../../../modulos/sistema/home/img/contas.png");    
    $("#lightboxFoto1").prop("href", "../../../modulos/sistema/home/img/contas.png");
    
    $("#arquivoExistente").hide();
    $("#hddAnexoConta").val("");
    $("#anexoConta").val("");
    $("#caminhoArquivo").prop("src", "");
    
    $("#btnSalvar").show();
    $("#selTipo").val("P");
    gerenciarTipo();
    
    $('#tabs').tabs('option', 'active', 0); // retorna para a primeira aba
}

function abrirGeracaoParcelas(){
    if(($.trim($("#txtValor").val()) == "") || ($.trim($("#txtValor").val()) == "0,00")){
        $("#hddFocus").val("txtValor");
        $("#dialog-atencao").html("Por favor, informe o valor.");        
        $("#dialog-atencao").dialog("open"); 
        return;
    }
    
    if(($.trim($("#txtQuantidadeParcelas").val()) == "") || ($.trim($("#txtQuantidadeParcelas").val()) == "0")){
        $("#hddFocus").val("txtQuantidadeParcelas");
        $("#dialog-atencao").html("Por favor, informe o n&uacute;mero de parcelas.");        
        $("#dialog-atencao").dialog("open"); 
        return;
    }
    
    $("#dialog-parcelas").dialog("open");
    
    // coloca a máscara
    $("#txtDataInicioParcela").mask("99/99/9999");
    
    //limpa toda vez o campo Número Inicial
    $("#txtDataInicioParcela").val("");
    $("#txtNumeroInicialDocumentoParcela").val("");
    
    // pega a data atual no PHP
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "DataAtual"}
    })
    .done(function( data ) {
         $("#txtDataInicioParcela").val(data.dataAtual);
    });
}

function abrirPagamento(idParcela){
    $("#lightboxFotoParcela").prop("href", "../../../modulos/sistema/home/img/contas.png");
    $("#imgFotoParcela").prop("src", "../../../modulos/sistema/home/img/contas.png");
    
    $("#dialog-pagamento").dialog("open");
    
    
    // oculta o campo Número do Documento
    // pois só aparece quando a flag da FPG_ExigeData em Forma de Pagamento é S
    $("#fieldsetNumeroDocumento").hide();
    
    $.post(controlador, {
        ACO_Descricao: "ConsultarParcelas",
        PCL_ID: idParcela 
    },
        function(data) {            
            if(data.sucesso == "true"){
                $("#hddParcelaID").val(idParcela);
                $("#spnValorParcela").html(data.rows[0].PCL_Valor);
                $("#hddValorParcela").val(data.rows[0].PCL_Valor);
                $("#txtTotalPagoParcela").val(data.rows[0].PCL_Valor);
                $("#txtDataVencimentoParcela").val(data.rows[0].PCL_DataVencimento);
                
                // deixa os valores default para o restando dos campos
                $("#txtJurosParcela").val("0,00");
                $("#txtMoraParcela").val("0,00");
                $("#txtMultaParcela").val("0,00");
                $("#txtDescontoParcela").val("0,00");
                $("#selFormaPagamentoParcela").val("");
                $("#selFormaPagamentoParcela").trigger('chosen:updated');
                
                $("#txtDataPagamentoParcela").val("");
                
                $("#selContaBancaria").val("");
                $("#selContaBancaria").trigger('chosen:updated');
                
                // identifica qual o termo a ser utilizado
                // no momento do pagamento referente a conta
                // CREDITAR OU DEBITAR
                $.post(controlador, {
                    ACO_Descricao: "Consultar",
                    CON_ID: data.rows[0].CON_ID
                },
                    function(data1) {            
                        if(data1.sucesso == "true"){
                            if(data1.rows[0].CON_Tipo == "P"){
                                $("#labDescricaoContaBancaria").html("Conta a Debitar*");
                                $("#spnDataPagamento").html("Pagamento");
                                $("#spnFormaPagamento").html("Pagamento");
                                $("#spnTotalPago").html("Pago");
                            }else{
                                $("#labDescricaoContaBancaria").html("Conta a Creditar*");
                                $("#spnDataPagamento").html("Recebimento");
                                $("#spnFormaPagamento").html("Recebimento");
                                $("#spnTotalPago").html("Recebido");
                            } 
                        }
                    }, "json"
                ); 
            }
        }, "json"
    ); 
}

function gerarParcelas(){    
    var valorParcelas = $("#txtValor").val();
    var numeroParcelas = $("#txtQuantidadeParcelas").val();
    var dataInicioParcela = $("#txtDataInicioParcela").val();
    var numeroInicialParcela = $("#txtNumeroInicialDocumentoParcela").val();
    
    if(!isDataValida(dataInicioParcela)){
        $("#hddFocus").val("txtDataInicioParcela");
        $("#dialog-atencao").html("Por favor, informe uma data de início de parcela válida.");        
        $("#dialog-atencao").dialog("open"); 
        return;
    }
    
    $.post(controlador, {
        ACO_Descricao: "GerarParcelas",
        CON_ValorParcelas: valorParcelas,
        CON_NumeroParcelas: numeroParcelas,
        CON_DataInicioParcela: dataInicioParcela,
        CON_NumeroInicialParcela: numeroInicialParcela
    },
        function(data) {            
            if(data.sucesso == "true"){
                $("#dialog-parcelas").dialog("close");  
                $("#lista-pacelas").html(data.html); 
            }
        }, "json"
    ); 
}

function gerarParcelasAlt(){
    var id = $("#hddID").val();
    
    $.post(controlador, {
        ACO_Descricao: "GerarParcelasAlt",
        CON_ID: id
    },
        function(data) {            
            if(data.sucesso == "true"){
                $("#dialog-parcelas").dialog("close");  
                $("#lista-pacelas").html(data.html); 
            }
        }, "json"
    ); 
}

function removerParcela(linhaParcela){
    // sempre deixa uma parcela
    // caso o usuário remove as demais
    if(parseInt($("#txtQuantidadeParcelas").val()) > 1){
        $("#linhaParcela" + linhaParcela).remove();

        // diminui uma parcela
        $("#txtQuantidadeParcelas").val(parseInt($("#txtQuantidadeParcelas").val()) - 1);
    }else{        
        $("#dialog-atencao").html("&Eacute; necess&aacute;rio que tenha no m&iacute;nimo uma parcela. Opera&ccedil;&atilde;o n&atilde;o permitida.");        
        $("#dialog-atencao").dialog("open"); 
    }
}

function calcularValorPago(){
    var juros = $("#txtJurosParcela").val();
    var mora = $("#txtMoraParcela").val();
    var multa = $("#txtMultaParcela").val();
    var desconto = $("#txtDescontoParcela").val();
    var valorParcela = $("#hddValorParcela").val();
    
    $.post(controlador, {
        ACO_Descricao: "CalulcarValorPago",
        PCL_Juros: juros,
        PCL_Mora: mora,
        PCL_Multa: multa,
        PCL_Desconto: desconto,
        PCL_ValorParcela: valorParcela
    },
        function(data) {            
            if(data.sucesso == "true"){
                $("#txtTotalPagoParcela").val(data.valorPago);
            }
        }, "json"
    );
}

function verificarExistenciaParcelaPaga(idConta){
    var existeParcelaPaga = false;
    
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "ConsultarParcelas", CON_ID: idConta, PCL_ParcelaPaga: true}
    })
    .done(function( data ) {  
        
         if(data.sucesso == "true"){
             existeParcelaPaga = true;
         }
    });
    
    return existeParcelaPaga;
}

// adicionar
function getPlanoContasDinamico(){  
    var movimentacao = "S";
    
    if($("#selTipo").val() == "R"){
        movimentacao = "E";
    }
    
    $.ajax({
        type: "POST",
        url: controladorPlanoContas,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", PLA_Status: "A", PLA_Tipo: "A", PLA_Movimentacao: movimentacao}
    })
    .done(function( data ) {       
        $("#selPlanoConta").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].PLA_ID + '">' + data.rows[i].PLA_CodigoContabil + " - " + data.rows[i].PLA_Descricao + '</option>';
            }
            
            $("#selPlanoConta").append(html);
            $("#selPlanoConta").trigger('chosen:updated');
        }
        
        getPlanoContasPesquisar();        
    });
}
function getPlanoContasPesquisar(){
    $.ajax({
        type: "POST",
        url: controladorPlanoContas,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", PLA_Status: "A", PLA_Tipo: "A"}
    })
    .done(function( data ) {
        $("#selPesquisaPlanoConta").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].PLA_ID + '">' + data.rows[i].PLA_CodigoContabil + " - " + data.rows[i].PLA_Descricao + '</option>';
            }
            
            $("#selPesquisaPlanoConta").append(html);
            $("#selPesquisaPlanoConta").trigger('chosen:updated');
        }
    });
}

function getPessoaDinamico(){
    preLoadingOpen(null);
    
    $.ajax({
        type: "POST",
        url: controladorPessoa,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", PES_Status: "A"}
    })
    .done(function( data ) {
        $("#selOrigemPessoa").html("<option value=''></option>");
        $("#selPesquisaPessoa").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].PES_ID + '">' + data.rows[i].PES_Nome + '</option>';
            }
            
            $("#selOrigemPessoa").append(html);
            $("#selOrigemPessoa").trigger('chosen:updated');
            
            $("#selPesquisaPessoa").append(html);
            $("#selPesquisaPessoa").trigger('chosen:updated');
        }
        
        preLoadingClose();
    });
}
function getFornecedorDinamico(){
    preLoadingOpen(null);
    
    $.ajax({
        type: "POST",
        url: controladorFornecedor,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", FOR_Status: "A"}
    })
    .done(function( data ) {        
        $("#selFornecedor").html("<option value=''></option>");
        $("#selPesquisaFornecedor").html("<option value=''></option>");
        $("#selOrigemFornecedor").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].FOR_ID + '">' + data.rows[i].FOR_NomeFantasia + '</option>';
            }
            
            $("#selFornecedor").append(html);
            $("#selFornecedor").trigger('chosen:updated');
            
            $("#selPesquisaFornecedor").append(html);
            $("#selPesquisaFornecedor").trigger('chosen:updated');
            
            $("#selOrigemFornecedor").append(html);
            $("#selOrigemFornecedor").trigger('chosen:updated');
        }
        
        preLoadingClose();
    });
}

function getCentroCustoDinamico(){
    $.ajax({
        type: "POST",
        url: controladorCentroCusto,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", CEN_Status: "A"}
    })
    .done(function( data ) {        
        $("#selCentroCusto").html("<option value=''></option>");
        $("#selPesquisaCentroCusto").html("<option value=''></option>");
        
        if(data.sucesso == "true"){            
            var html = '';
            
            for(var i=0; i<data.rows.length; i++){ 
                html += '<option value="' + data.rows[i].CEN_ID + '">' + data.rows[i].CEN_Descricao + '</option>';
            }
            
            $("#selCentroCusto").append(html);
            $("#selCentroCusto").trigger('chosen:updated');
            
            $("#selPesquisaCentroCusto").append(html);
            $("#selPesquisaCentroCusto").trigger('chosen:updated');
        }
    });
}

// flag validacao
// indica que o gerenciarExigeNumeroFormaPagamento está sendo utilizado
// em uma validação e por isso deve desconsiderar o $("#txtFormaPagamentoNumero").val("");
// pois senão toda vez vai zerar o valor do número do documento
function gerenciarExigeNumeroFormaPagamento(validacao){
    var exige = false;
    
    $.ajax({
        type: "POST",
        url: controladorFormaPgto,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", FPG_ID: $("#selFormaPagamentoParcela").val()}
    })
    .done(function( data ) {         
        if(data.sucesso == "true"){            
            if(data.rows[0].FPG_ExigeNumero == "S"){
                if(!validacao){
                    $("#txtFormaPagamentoNumero").val("");
                }
                $("#fieldsetNumeroDocumento").show();
                exige = true;
            }else{
                $("#fieldsetNumeroDocumento").hide();
            }
        }else{
            $("#fieldsetNumeroDocumento").hide();
        }
    });
    
    return exige;
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