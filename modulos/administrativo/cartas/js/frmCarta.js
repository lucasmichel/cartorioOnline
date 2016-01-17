// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID    = $("#hddFormularioID").val(); 
var controlador     = "../../administrativo/cartas/controladores/CartaControlador.php";
var dg              = $('#grid');
var txtCartaEdicao  = null;

// inicialização
function init(){
    // tabs
    $('#tabs').tabs();
     
    $("#selPessoa").attr("disabled", true);
    $('#selPessoa').trigger('chosen:updated');
     
    $("#txtPesquisaDataInicial").mask("99/99/9999");
    $("#txtPesquisaDataInicial").datepicker();
    
    $("#txtPesquisaDataFinal").mask("99/99/9999");
    $("#txtPesquisaDataFinal").datepicker();
     
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

    tinymce.remove("textarea");
    
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        language : 'pt_BR',
        remove_script_host : false,
        convert_urls : false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern moxiemanager"

        ],
        toolbar1: "insertfile undo redo | styleselect | sizeselect | bold italic | fontselect | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ]
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
        var tipoCarta    = $("#selTipoCartaPesquisa").val();    
        var pessoaCarta    = $("#selPessoaCartaPesquisa").val();    
        var pesquisaDataInicial = $("#txtPesquisaDataInicial").val();
        var pesquisaDataFinal   = $("#txtPesquisaDataFinal").val();
        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            PES_ID: pessoaCarta,
            TCA_ID: tipoCarta,
            CAR_DataInicial: pesquisaDataInicial,
            CAR_DataFinal: pesquisaDataFinal,
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
        ,uniqueRow: true
        ,autoLoad: false        
        ,rowNumber: false
        ,onClickRow: function(row) {
            $(this).datagrid('selectRow',row);
        }
        ,toolBarButtons: [
            /*{
                label: 'Alterar'
                ,icon: 'pencil'
                ,fn: function() {
                    var totalSelecionado = dg.datagrid('getSelectedRows').length;
                    
                    if(totalSelecionado == 1){
                        preLoadingOpen(null);
                        // armazena o ID do registro para informar
                        // ao controlador qual registro será modificado
                        $("#hddID").val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML);                                              
                        $.post(controlador, {
                            ACO_Descricao: "Consultar",
                            CAR_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                      
                                    $("#hddID").val(data.rows[0].CAR_ID);                                      
                                    
                                    $("#selTipoCarta").val(data.rows[0].TCA_ID);    
                                    $('#selTipoCarta').trigger('chosen:updated');
                                    
                                    $("#selPessoa").val(data.rows[0].PES_ID);    
                                    $('#selPessoa').trigger('chosen:updated');
                                    
                                    txtCartaEdicao = data.rows[0].CAR_Texto;                                    
                                    tinymce.get("txtConteudo").setContent(txtCartaEdicao);
                                    
                                    $('#tabs').tabs('option', 'active', 1);
                                }
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
            },*/{
                label: 'Excluir'
                ,icon: 'closethick'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){ 
                        $("#dialog-excluir-msg").html("Tem certeza que deseja remover as cartas selecionadas?");
                        $("#dialog-excluir").dialog("open"); 
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja excluir.");
                        $("#dialog-atencao").dialog("open");
                    }                    
                }
            },{
                label: 'Imprimir Carta'
                ,icon: 'print'
                ,fn: function(){
                    
                     var totalSelecionado = dg.datagrid('getSelectedRows').length;
                    
                    if(totalSelecionado == 1){
                    
                        // pega o id do registro
                        var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML; 
                        
                        var url = "../../administrativo/cartas/documentos/ModeloCarta.php?CAR_ID=" + id;
                        novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
                    }else{
                        if(totalSelecionado == 0){
                            $("#dialog-atencao").html("Por favor, selecione o registro que deseja imprimir.");        
                            $("#dialog-atencao").dialog("open"); 
                        }else{
                            $("#dialog-atencao").html("Para imprimir é necessário que selecione apenas um registro.");        
                            $("#dialog-atencao").dialog("open"); 
                        }
                    }
                }
                
            }
        ]
        ,mapper:[{
            name: 'CAR_ID', title: 'Cód.', width: 60, align: 'center'
        },{
            name: 'TCA_Descricao', title: 'Modelo da Carta', width: 400, align: 'left'                        
        },{
            name: 'PES_Nome', title: 'Membro', width: 400, align: 'left'                
        },{
            name: 'CAR_DataHoraCadastro', title: 'Data/Hora Cadastro', width: 150, align: 'center'        
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
    
    if($.trim($('#selTipoCarta').val()) == ""){        
        $("#hddFocus").val("selTipoCarta");
        $("#dialog-atencao").html("Por favor, informe o nome do tipo de carta.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selPessoa').val()) == ""){        
        $("#hddFocus").val("selPessoa");
        $("#dialog-atencao").html("Por favor, informe o nome membro da carta.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim(tinyMCE.activeEditor.getContent()) == ""){        
        $("#hddFocus").val("txtConteudo");
        $("#dialog-atencao").html("Por favor, informe o texto da carta.");        
        $("#dialog-atencao").dialog("open");
        return;
    } 
    
    // guarda o texto no hidden
    // para poder ser enviado pelo ajaxForm
    $("#hddTexto").val($.trim(tinyMCE.activeEditor.getContent()));
    
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
        CAR_ID: ids
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

function cancelar(){
    // campos obrigatórios
    $("#hddID").val("");
    $("#hddFocus").val("");
    
    $("#selTipoCarta").val("");    
    $('#selTipoCarta').trigger('chosen:updated');         
    
    $("#txtTexto").val(""); 
    tinymce.get("txtConteudo").setContent('');
    txtCartaEdicao = null;
       
    $('#tabs').tabs('option', 'active', 0);
    $("#selPessoa").attr("disabled", true);
    $('#selPessoa').trigger('chosen:updated');
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

function selecionarTodos(){
    if($("#ckbSelecionarTodos").is(":checked")){
        dg.datagrid('clearAllRows');
        dg.datagrid('selectAllRows');
    }else{
        dg.datagrid('clearAllRows');
    }
}

function preencherTextoComTipoDeCarta(){
    
    var id = $("#selTipoCarta").val();
    
    if(id>0){
        
        $.post("../../administrativo/cartas/controladores/TipoCartaControlador.php", {
        ACO_Descricao: "Consultar",        
        TCA_ID: id
        },
            function(data) {
                if(data.sucesso == "true"){                
                    tinymce.get("txtConteudo").setContent(data.rows[0].TCA_Texto);
                    txtCartaEdicao = data.rows[0].TCA_Texto;
                    $("#selPessoa").val("");
                    $("#selPessoa").attr("disabled", false);
                    $('#selPessoa').trigger('chosen:updated');
                }
            }, "json"
        );
    }else{
        txtCartaEdicao = null;
        tinymce.get("txtConteudo").setContent();        
        $("#selPessoa").val("");
        $("#selPessoa").attr("disabled", true);
        $('#selPessoa').trigger('chosen:updated');
    }
    
    
    return;
    
}

function preencherTextoComNomePessoa(){    
    var texto = $("#selPessoa :selected").text();    
    if(texto == ""){
        tinymce.get("txtConteudo").setContent(txtCartaEdicao);                
    }else{
        var str = txtCartaEdicao;
        var resultado = str.replace(/#nomedomembro/g, texto);
        tinymce.get("txtConteudo").setContent(resultado);
    }
    return;    
}
