// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID    = $("#hddFormularioID").val(); 
var controlador     = "../../administrativo/cadastro/controladores/MalaDiretaControlador.php";
var dg              = $('#grid');
var boolEnviaEmail  = true;
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
    
    $("#dialog-envio-mala-direta").dialog({
        autoOpen: false,
        height:620,
        width:900,
        buttons: {
            "Enviar": function() {                   
                $("#dialog-executa-envio-email").dialog("open");                 
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        },
        open: function() 
        {
            preencherPessoasEnvio();
        }
    });
    
    $("#dialog-executa-envio-email").dialog({
        autoOpen: false,
        height:220,
        width:400,
        buttons: {            
            "Fechar": function() {                         
                $(this).dialog("close"); 
            }
        },
        open: function() 
        {
            enviarEmails();
        },
        close: function() 
        {
            boolEnviaEmail = false;
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

function preencherPessoasEnvio(){
    $("#div-grid-emails-envio").html("Carregando...");
    var filtrarPor = $("#selFilraPessoaPor").val();    
    //var filtro = $("#txtFiltro").val(); CONSULTA JA MONTADA COMO NÃO VAI SER UILIZADO POR ENQUANTO PASSAR NULL
    var filtro = null;
    
    //var caminhoImagem = "../../../modulos/sistema/home/img/carregandoBarra.gif";
    
    $.post(controlador, {
        ACO_Descricao: "ConsultarPessoas",
        filtrarPor: filtrarPor,
        filtro: filtro
    },
        function(data) {                
            var txtHml = "";
            
            if(data.sucesso == "true"){
                
                txtHml += " <table class='dadosTabela' border='1px' cellpadding='5' cellspacing='0' width='100%'>";
                    txtHml += "<tr class='cabecalhoTabela'>";
                        txtHml += "<td width='85%' >Nome</td>";                                                
                        txtHml += '<td align="center" width="15%">Todos <input title="Seleciona todos" class="checkboxTodos" type="checkbox" id="checkSelecionaTodos" onclick="marcarDesmarcarTodos();" /></td>'; 
                    txtHml += "</tr>";
                    var classDif = '';
                    for(var i=0; i<data.rows.length; i++){
                        classDif = 'class="linhaNormal"';
                        if(i%2 == 0){
                            classDif = 'class="linhaCor"';
                        }
                        txtHml += '<tr ' + classDif +'>';
                            txtHml += '<td>' + data.rows[i].PES_Nome + '</td>';                            
                            txtHml += '<td align="center">';                                                                    
                                txtHml += '<input class="checkboxPessoa" id="ckbPessoa_' + data.rows[i].PES_ID + ' " name="PES_ID[]" type="checkbox" value="' + data.rows[i].PES_ID + '"/>';
                            txtHml += '</td>';
                        txtHml += '</tr>';
                    }
                txtHml += "</table>";                
                
            }else{
                txtHml = "<b>Nenhuma pessoa encontrada</b>";
            }            
            $("#div-grid-emails-envio").html(txtHml);
        }, "json"
    );    
}


function marcarDesmarcarTodos(){
    if ($("#checkSelecionaTodos").is(":checked")){
      $('.checkboxPessoa').each(
         function(){
            $(this).prop("checked", true);            
         }
      );
    }else{
      $('.checkboxPessoa').each(
         function(){
            $(this).prop("checked", false);            
         }
      );
    }
}

function enviarEmails(){
    
    $('#idMala').val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML);
    
    $("#spanImagemLoad").html("<img src='../../../modulos/sistema/home/img/carregando1.gif'  />");
    
    var arrayIDS = new Array();
    var intSucesso = 0;
    var intErro = 0;
    
    $('.checkboxPessoa').each(function() {
        if($(this).is(":checked")){
            arrayIDS.push($(this).val());            
        }
    });
    
    $('#totEmail').html(arrayIDS.length);
    $('progress').prop("max", arrayIDS.length);            
    
    $('progress').prop('value',0);
    $('#totEmailEnviado').html(0);
    
    for(var intI=0; intI<arrayIDS.length; intI++){

        
        //com o id da menssagem e o id da pessao envia o email

        //preenche o email enviado            
        //var retorno = false;
        $.ajax({
        type: "POST",
        url: controlador,
        dataType: 'json',
        cache: false,
        async:false,    
        data: {
            ACO_Descricao: "EnviarEmails",
            MAD_ID: dg.datagrid('getSelectedRows')[0].cells[0].innerHTML, 
            PES_ID: arrayIDS[intI]
        }
        }).done(function( data ) {  
            if(data.sucesso == "true"){                                       
                //retorno = true;
                
                intSucesso = intSucesso +1;
            }else{            
                //retorno = false;
                
                intErro = intErro +1;
                
            }
            
            $('#totEmailEnviado').html(intI+1);
            $('progress').prop('value',intI+1);            
        });
        
    }
    $("#spanImagemLoad").html("");
    var txtFim = " Emails enviados com sucesso: "+intSucesso;
    txtFim += " <br>Emails não enviados: "+intErro;
    
    $('#resultadoEnvio').html(txtFim);
   
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
        var tipoCarta    = $("#selTipoCartaPesquisa").val();    

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            MAD_Assunto: pesquisaDescricao,
            //TCA_ID: tipoCarta,
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
        ,uniqueRow: false
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
                    var totalSelecionado = dg.datagrid('getSelectedRows').length;
                    
                    if(totalSelecionado == 1){
                        preLoadingOpen(null);
                        // armazena o ID do registro para informar
                        // ao controlador qual registro será modificado
                        $("#hddID").val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML);                                              
                        $.post(controlador, {
                            ACO_Descricao: "Consultar",
                            MAD_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                      
                                    $("#hddID").val(data.rows[0].MAD_ID);                                      
                                    $("#txtAssunto").val(data.rows[0].MAD_Assunto);
                                    tinymce.get("txtConteudo").setContent(data.rows[0].MAD_Conteudo);                                    
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
            },{
                label: 'Excluir'
                ,icon: 'closethick'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){ 
                        $("#dialog-excluir-msg").html("Ao exlcuir as Malas Direta serão apagados também suas informações quanto ao envio das mesmas, tem certeza?");
                        $("#dialog-excluir").dialog("open"); 
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja excluir.");
                        $("#dialog-atencao").dialog("open");
                    }                    
                }
            },{
                label: 'Enviar Mala'
                ,icon: 'grid'
                ,fn: function(){
                    
                    var totalSelecionado = dg.datagrid('getSelectedRows').length;
                    
                    if(totalSelecionado == 1){
                    
                        $("#dialog-envio-mala-direta").dialog("open");
                    
                        // pega o id do registro
                        /*var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML; 
                        
                        var url = "../../administrativo/cadastro/documentos/ModeloCarta.php?CAR_ID=" + id;
                        novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');*/
                        
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
            name: 'MAD_ID', title: 'Cód.', width: 60, align: 'center'
        },{
            name: 'MAD_Assunto', title: 'Assunto', width: 800, align: 'left'                
        },{
            name: 'MAD_DataHoraCadastro', title: 'Data/Hora Cadastro', width: 140, align: 'center'        
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
    
    if($.trim($('#txtAssunto').val()) == ""){        
        $("#hddFocus").val("txtAssunto");
        $("#dialog-atencao").html("Por favor, informe o assunto.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    var content = tinyMCE.get('txtConteudo').getContent(); // msg = textarea id
    if( content == "" || content == null){            
        $("#hddFocus").val("txtConteudo");
        $("#dialog-atencao").html("Por favor, informe o conteudo.");        
        $("#dialog-atencao").dialog("open");
        return;
    } 
    
    // guarda o texto no hidden
    // para poder ser enviado pelo ajaxForm
    $("#hddTexto").val(tinyMCE.activeEditor.getContent());
    
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
    $("#txtAssunto").val("");    
    $("#txtTexto").val(""); 
    tinymce.get("txtConteudo").setContent('');
    $('#tabs').tabs('option', 'active', 0);
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

/*
function preencherTextoComTipoDeCarta(){    
    var id = $("#selTipoCarta").val();    
    $.post("../../administrativo/cadastro/controladores/TipoCartaControlador.php", {
        ACO_Descricao: "Consultar",        
        TCA_ID: id
    },
        function(data) {
            
            if(data.sucesso == "true"){
                
                editor.editable("setHTML", data.rows[0].TCA_Texto);
                
            }
        }, "json"
    );
    return;
    
}*/