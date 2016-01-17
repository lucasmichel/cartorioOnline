// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/cadastro/controladores/FuncionarioControlador.php";
var dg           = $('#grid');
var strBase64ImagemUpload = null;

    

// inicialização
function init(){    
    // tabs
    $('#tabs').tabs();
    $('#tabs-dados').tabs();    
    $('#tabs-foto').tabs();
     
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
      
    $('#txtCPF').mask("999.999.999-99");    
    $('#txtDataNascimento').mask("99/99/9999");
    $('#txtDataNascimento').datepicker();    
    $('#txtDataFalecimento').mask("99/99/9999");
    $('#txtDataFalecimento').datepicker();    
    $('#txtEmailPrimario').alphanumeric({allow:"._-@"});
    $('#txtEmailSecundario').alphanumeric({allow:"._-@"});    
    $('#txtEnderecoCEP').mask("99999-999");
    $('#txtEnderecoCEPEmpresa').mask("99999-999");    
    $('#txtTelefone').mask("(99) 9999.9999");
    $('#txtCelular').mask("(99) 9999.9999");    
    $('#txtEmpresaTelefone').mask("(99) 9999.9999");
    $('#txtEmpresaFax').mask("(99) 9999.9999");    
    
    $('#txtDataAdmissao').mask("99/99/9999");
    $('#txtDataAdmissao').datepicker();    
    
    $('#txtDataSaida').mask("99/99/9999");
    $('#txtDataSaida').datepicker();    
    
    $('#txtSalario').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    
    $("#txtCargaHoraria").numeric();    
    $('#txtHorarioEntrada').timeEntry({spinnerImage: '', show24Hours: true});    
    $('#txtHorarioSaida').timeEntry({spinnerImage: '', show24Hours: true});
    
    exibirDataFalecimento();  
    exibirMembro();
          
    
    //gerencia foto
    $( "#dialog-gerencia-foto").dialog({
      resizable: false,
      draggable: false,
      autoOpen: false,
      height:620,
      width:900,
      modal: true,
      buttons: {
        "Adicionar": function() {                              
            if(strBase64ImagemUpload == null){                      
                //$('#tabs-dados').tabs().tabs('select', 0);//retorna pra 1 aba                    
                $("#dialog-atencao").html("Por favor, selecione uma imagem ou tire uma foto para poder adicionar.");                            
                $('#dialog-atencao').dialog('open');                    
                return;
            }else{
                $('#imgFotoSalvar').prop("src", strBase64ImagemUpload);
                $('#hddFotoMembro').val(strBase64ImagemUpload);                
                $( this ).dialog( "close" );                
            }
            $('#tabs-foto').tabs('option', 'active', 0);
        }
      },
      open: function() 
      {     
            
            $( '#div-camera' ).photobooth().on( "image", function( event, dataUrl ){                
                $( "#fotoTirada" ).html( "<center><img width='400' height='350' class='fotoTirada'  src='"+dataUrl+"' ></center>");
                $( "#div-foto-nova" ).html( "<center><img width='400' height='350' class='fotoTirada'  src='"+dataUrl+"' ></center>" );
                strBase64ImagemUpload = dataUrl;
                $("#fileImagem").val(null);
                $("#fileImagem").trigger("change");                
                
            }).forceHSB = true;
            
            $("#fileImagem").change(function(){
                readImage(this);
            });
            
            
            
       }, close: function(){
           $('#tabs-foto').tabs('option', 'active', 0);
           $( '#div-camera' ).data( "photobooth" ).destroy();
       }
    });
    
    
    // configura o grid
    initGRID();   
      
    // carrega o grid
    consultar();  
}

//seta a pre-visualizacao das imagens e carrega o bse64 da imagem pra variavel pra poder salvar
function readImage(input) { 
    if ( input.files && input.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {            
            var totalBits = e.target.result.length;            
            var totalKilobits = totalBits/1024;
            var totalMegaBits = totalKilobits/1024;
            if(totalMegaBits < 1.0000){
                //com isso aqui se pode exibir a imagem antes mesmo de ser feito o upload da mesma
                $( "#fotoTirada" ).html( "<center><img width='400' height='350' class='fotoTirada'  src='"+e.target.result+"' ></center>");                
                $( "#div-foto-nova"  ).html( "<center><img width='400' height='350' class='fotoTirada'  src='"+e.target.result+"' ></center>");
                strBase64ImagemUpload = e.target.result;
            }else{
                $("#dialog-atencao").html("Atenção, a imagem deverá ser de até 1MB.");
                $('#dialog-atencao').dialog('open');
            }
        };       
        FR.readAsDataURL( input.files[0] );
    }
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
        var pesquiasrCampo = $("#txtPesquisaCampo").val();    
        var pesquisarPor    = $("#selPesquisarPor").val();    
        var PES_Status    = $("#selPesquisaStatus").val();    
        var PES_Sexo    = $("#selSexoPesquisa").val();    
        var NES_ID    = $("#selNivelEscolaridadePesquisa").val();    
        var ECV_ID    = $("#selEstadoCivilPesquisa").val();    

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
            PES_Status: PES_Status,
            pesquiasrCampo: pesquiasrCampo,
            pesquisarPor: pesquisarPor,
            PES_Sexo: PES_Sexo,
            NES_ID: NES_ID,
            ECV_ID: ECV_ID,
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
                            PES_ID: $("#hddID").val()
                        },
                            function(data){
                                if(data.sucesso == "true"){                                    
                                    
                                    
                                      
                                    $("#hddID").val(data.rows[0].PES_ID);
                                    $("#hddMatricula").val(data.rows[0].PES_Matricula);                                    
                                    $("#hddFotoMembro").val(data.rows[0].PES_ArquivoFoto);
                                    if(data.rows[0].PES_ArquivoFoto.length > 0){                                                                                
                                        $('#imgFotoSalvar').prop("src", data.rows[0].PES_ArquivoFoto);
                                        $('#hddFotoMembro').val(data.rows[0].PES_ArquivoFoto); 
                                        
                                        
                                        $( "#fotoTirada" ).html( "<center><img width='330' height='300' class='fotoTirada'  src='"+data.rows[0].PES_ArquivoFoto+"' ></center>");
                                        $( "#div-foto-nova" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
                                        $( "#div-foto-existente" ).html( "<center><img width='330' height='300' class='fotoTirada'  src='"+data.rows[0].PES_ArquivoFoto+"' ></center>");
                                        
                                        strBase64ImagemUpload = data.rows[0].PES_ArquivoFoto;
                                        
                                    }else{
                                        $('#imgFotoSalvar').prop("src", "../../../modulos/sistema/home/img/sem-foto.png");
                                        $('#hddFotoMembro').val(""); 
                                        
                                        $( "#fotoTirada" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
                                        $( "#div-foto-nova" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
                                        $( "#div-foto-existente" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
                                        strBase64ImagemUpload = null;
                                        
                                    }
                                    
                                    if(data.rows[0].PES_DataFalecimento != ""){    
                                        $("#ckbFalecimento").prop("checked", true);                                        
                                        $("#txtDataFalecimento").val(data.rows[0].PES_DataFalecimento); 
                                    }else{
                                        $("#ckbFalecimento").prop("checked", false);
                                        $("#txtDataFalecimento").val("");    
                                    }  
                                    exibirDataFalecimento();  
                                    
                                    $("#txtNome").val(data.rows[0].PES_Nome);    
                                    $("#txtDataNascimento").val(data.rows[0].PES_DataNascimento);    
                                    $("#txtCPF").val(data.rows[0].PES_CPF);    
                                    $("#txtTelefone").val(data.rows[0].PES_TelefoneResidencial);    
                                    $("#txtCelular").val(data.rows[0].PES_TelefoneCelular);    
                                    $("#txtEmailPrimario").val(data.rows[0].PES_EmailPrimario);    
                                    $("#txtEmailSecundario").val(data.rows[0].PES_EmailSecundario);                                        
                                    $("#selSexo").val(data.rows[0].PES_Sexo);                                    
                                    $("#txtMae").val(data.rows[0].PES_MaeNome);                                        
                                    $("#txtPai").val(data.rows[0].PES_PaiNome);
                                    $("#selTipoSanguineo").val(data.rows[0].PES_GrupoSanguineo);                                                                      
                                    $("#selNivelEscolaridade").val(data.rows[0].NES_ID); 
                                    $('#selNivelEscolaridade').trigger('chosen:updated');
                                    $("#selAreaAtuacao").val(data.rows[0].AAT_ID);    
                                    $('#selAreaAtuacao').trigger('chosen:updated');                                    
                                                                     
                                    
                                    
                                    $("#selEstadoCivil").val(data.rows[0].ECV_ID);  
                                    $('#selEstadoCivil').trigger('chosen:updated');                                                                        
                                    $("#txtEnderecoCEP").val(data.rows[0].PES_EnderecoCep);    
                                    $("#txtEnderecoLogradouro").val(data.rows[0].PES_EnderecoLogradouro);    
                                    $("#txtEnderecoNumero").val(data.rows[0].PES_EnderecoNumero);    
                                    $("#txtEnderecoComplemento").val(data.rows[0].PES_EnderecoComplemento);    
                                    $("#txtEnderecoPontoReferencia").val(data.rows[0].PES_EnderecoPontoReferencia);    
                                    $("#txtEnderecoBairro").val(data.rows[0].PES_EnderecoBairro);    
                                    $("#txtEnderecoCidade").val(data.rows[0].PES_EnderecoCidade);    
                                    $("#selEnderecoUF").val(data.rows[0].PES_EnderecoUf);                                        
                                    $("#txtObservacao").val(data.rows[0].PES_Observacao);    
                                    $("#txtFormacao").val(data.rows[0].PES_Formacao); 
                                    
                                    $("#txtDataAdmissao").val(data.rows[0].FUN_DataAdmissao);    
                                    $("#txtDataSaida").val(data.rows[0].FUN_DataSaida);    
                                    $("#txtFuncao").val(data.rows[0].FUN_Funcao);    
                                    $("#txtCarteiraTrabalho").val(data.rows[0].FUN_CarteiraTrabalhoNumero);    
                                    $("#txtSalario").val(data.rows[0].FUN_Salario);
                                    $("#txtCargaHoraria").val(data.rows[0].FUN_CargaHoraria);    
                                    $("#txtHorarioEntrada").val(data.rows[0].FUN_HorarioEntrada);    
                                    $("#txtHorarioSaida").val(data.rows[0].FUN_HorarioSaida); 
                                    $("#txtCNH").val(data.rows[0].FUN_CNHNumero); 
                                    
                                    $("#txtRG").val(data.rows[0].PES_RG);
                                    $("#txtRGOrgaoEmissor").val(data.rows[0].PES_RGOrgaoEmissao);
                                    
                                    $("#txtNaturalidade").val(data.rows[0].PES_Naturalidade);
                                    $("#txtNascionalidade").val(data.rows[0].PES_Nacionalidade);
                                    
                                    if(data.rows[0].PES_Doador == "N"){
                                        $("#ckbDoador").prop("checked", false);
                                    }else{
                                        $("#ckbDoador").prop("checked", true);
                                    }
                                    
                                    if(data.rows[0].PES_Status == "A"){
                                        $("#ckbStatus").prop("checked", false);
                                    }else{
                                        $("#ckbStatus").prop("checked", true);
                                    }             
                                    
                                    if(data.rows[0].PES_Membro_ID > 0){                                            
                                        $("#ckbEmembro").prop("checked", true);
                                        $("#selMembro").val(data.rows[0].PES_Membro_ID);
                                        $('#selMembro').trigger('chosen:updated');
                                        
                                        exibirMembro();
                                        preencheDadosMembro();
                                    }
                                    
                                    $('#tabs').tabs('option', 'active', 1);
                                    $('#tabs-dados').tabs('option', 'active', 0);
                                }
                                preLoadingClose();
                            }, "json"
                        );
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja alterar.");
                        $("#dialog-atencao").dialog("open");
                    }
                }
            }/*,{
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
            }*/,{
                label: 'Ficha Funcionário'
                ,icon: 'print'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){
                        // pega o id do registro
                        var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;
                        var url = "../../administrativo/cadastro/documentos/FichaFuncionario.php?PES_ID=" + id;
                        novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja imprimir.");        
                        $("#dialog-atencao").dialog("open"); 
                    }
                }
                
            }
        ]
        ,mapper:[{
            name: 'PES_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'PES_Nome', title: 'Nome', width: 580, align: 'left'        
        },{
            name: 'PES_CPF', title: 'CPF', width: 110, align: 'left'                
        },{
            name: 'PES_Matricula', title: 'Matrícula', width: 110, align: 'left'        
        },{
            name: 'PES_DataNascimento', title: 'Data Nasc.', width: 120, align: 'center'
        },{
            name: 'PES_Status', title: 'Ativo', width: 60, align: 'center', render: function(d) {
                var status = 'SIM';
                if(d == "I"){
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
    
    if($("#ckbEmembro").prop("checked")){
        if($.trim($('#selMembro').val()) == ""){        
            $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
            $("#hddFocus").val("selMembro");
            $("#dialog-atencao").html("Por favor, informe o membro.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    if($.trim($('#txtNome').val()) == ""){        
        $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
        $("#hddFocus").val("txtNome");
        $("#dialog-atencao").html("Por favor, informe o nome do funcionário.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    if($.trim($('#txtDataNascimento').val()) == ""){        
        $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
        $("#hddFocus").val("txtDataNascimento");
        $("#dialog-atencao").html("Por favor, informe a data de nascimento do funcionário.");
        $("#dialog-atencao").dialog("open");
        return;
    }    
    if(!isDataValida($('#txtDataNascimento').val())){        
        $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
        $("#hddFocus").val("txtDataNascimento");
        $("#dialog-atencao").html("Por favor, informe uma data de nascimento v&aacute;lida.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selSexo').val()) == ""){        
        $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
        $("#hddFocus").val("selSexo");
        $("#dialog-atencao").html("Por favor, informe o sexo do funcionário.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    
    if($.trim($('#txtCPF').val()) != ""){        
        if(!isCPFValido($('#txtCPF').val())){
            $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
            $("#hddFocus").val("txtCPF");
            $("#dialog-atencao").html("Por favor, informe um CPF v&aacute;lido.");        
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    if(acaoExecutada == "Salvar"){          
        if($.trim($('#txtCPF').val()) != ""){
            if(!consultarCPF($('#txtCPF').val())){        
                $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
                $("#hddFocus").val("txtCPF");
                $("#dialog-atencao").html("CPF j&aacute; cadastrado.");        
                $("#dialog-atencao").dialog("open");
                return;
            }
        }        
    }else{                
        if($.trim($('#txtCPF').val()) != ""){        
            if(!consultarCPFEdicao($('#txtCPF').val(), $('#hddID').val())){                        
                $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
                $("#hddFocus").val("txtCPF");
                $("#dialog-atencao").html("CPF j&aacute; cadastrado.");        
                $("#dialog-atencao").dialog("open");
                return;
            }
        }
    }
    
    if($('#txtEmailPrimario').val()!=""){
        if(!isEmail($('#txtEmailPrimario').val())){
            $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
            $("#hddFocus").val("txtEmailPrimario");
            $("#dialog-atencao").html("Email primário inv&aacute;lido");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    if($('#txtEmailSecundario').val()!=""){
        if(!isEmail($('#txtEmailSecundario').val())){
            $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 1 aba
            $("#hddFocus").val("txtEmailSecundario");
            $("#dialog-atencao").html("Email secundário inv&aacute;lido");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    /*TESTAR SE VIER PREENCHODO OS HORARIOS*/
    
    if( ($('#txtHorarioEntrada').val() != "") && ($('#txtHorarioSaida').val() != "") && ($('#txtHorarioSaida').val() != "00:00") && ($('#txtHorarioEntrada').val() != "00:00")   ){
        var horaInicioExpediente = $.trim($('#txtHorarioEntrada').val());
        var horaFimExpediente = $.trim($('#txtHorarioSaida').val());                
        //alert(validarHorario(horaInicioExpediente, horaFimExpediente));
        if(!validarHorario(horaInicioExpediente, horaFimExpediente)){
            $('#tabs-dados').tabs('option', 'active', 1);//retorna pra 2 aba
            $("#hddFocus").val("txtHorarioEntrada");
            $("#dialog-atencao").html("Por favor, o horário de entrada não pode se maior que o de saída.");
            $("#dialog-atencao").dialog("open");
            return;
        }
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
    $("#hddMatricula").val("");                                    
    $("#hddFocus").val("");
    $("#hddFotoMembro").val("");    
    $("#txtNome").val("");    
    $("#txtDataNascimento").val("");    
    $("#txtCPF").val("");    
    $("#txtTelefone").val("");    
    $("#txtCelular").val("");    
    $("#txtEmailPrimario").val("");    
    $("#txtEmailSecundario").val("");         
    $("#txtMae").val("");    
    $("#txtPai").val("");    
    $("#txtObservacao").val("");    
    $("#txtFormacao").val("");    
    $("#selTipoSanguineo").val("");     
    $("#selSexo").val("");        
    $("#txtCarteiraTrabalho").val(""); 
    $("#selAreaAtuacao").val("");    
    $('#selAreaAtuacao').trigger('chosen:updated');    
    
    $("#selPofissao").val("");        
    $('#selPofissao').trigger('chosen:updated');    
    
    $("#selEstadoCivil").val("");  
    $('#selEstadoCivil').trigger('chosen:updated');
    
    $("#selNivelEscolaridade").val("");  
    $('#selNivelEscolaridade').trigger('chosen:updated');
    
    $("#txtEnderecoCEP").val("");    
    $("#txtEnderecoLogradouro").val("");    
    $("#txtEnderecoNumero").val("");    
    $("#txtEnderecoComplemento").val("");    
    $("#txtEnderecoPontoReferencia").val("");    
    $("#txtEnderecoBairro").val("");    
    $("#txtEnderecoCidade").val("");    
    $("#selEnderecoUF").val("");        
    $("#txtDataEstadoCivil").val("");    
    $("#txtObservacaoEstadoCivil").val("");    
    
    $("#txtDataAdmissao").val("");    
    $("#txtDataSaida").val("");    
    $("#txtFuncao").val("");    
    $("#txtSalario").val("");
    $("#txtCargaHoraria").val("");    
    $("#txtHorarioEntrada").val("");    
    $("#txtHorarioSaida").val("");  
    $("#txtCNH").val(""); 
    
    
    $("#txtDataFalecimento").val("");       
    $("#ckbFalecimento").prop("checked", false);
    exibirDataFalecimento();     
    
    $("#txtRG").val("");
    $("#txtRGOrgaoEmissor").val("");
    $("#txtNaturalidade").val("");
    $("#txtNascionalidade").val("");
    $("#ckbDoador").prop("checked", false);
    
    
    
    $('#imgFotoSalvar').prop("src", "../../../modulos/sistema/home/img/sem-foto.png");
    $('#hddFotoMembro').val(""); 
    
    $( "#fotoTirada" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
    $( "#div-foto-nova" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
    $( "#div-foto-existente" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
    strBase64ImagemUpload = null;
    $("#ckbStatus").prop("checked", false);
    
    $('#tabs-dados').tabs('option', 'active', 0);//retorna pra 4 aba
    $('#tabs').tabs('option', 'active', 0);//retorna pra 4 aba    
}

function consultarEndereco(){
    var objEnderecoCampos = {
        campoCep: "txtEnderecoCEP",
        campoLogradouro: "txtEnderecoLogradouro",
        campoBairro: "txtEnderecoBairro",
        campoCidade: {id: "txtEnderecoCidade", isSelect: false},
        campoUf: "selEnderecoUF",
        spanPreLoading: "spnCarregandoCEP"
    };    
   consultarCEP(objEnderecoCampos);
}

function consultarEnderecoEmpresa(){
  var objEnderecoCampos = {
        campoCep: "txtEnderecoCEPEmpresa",
        campoLogradouro: "txtEnderecoLogradouroEmpresa",
        campoBairro: "txtEnderecoBairroEmpresa",
        campoCidade: {id: "txtEnderecoCidadeEmpresa", isSelect: false},
        campoUf: "selEnderecoUFEmpresa",
        spanPreLoading: "spnCarregandoCEPEmpresa"
    };    
   consultarCEP(objEnderecoCampos);   
}

function tirarFoto(){
    $("#dialog-gerencia-foto").dialog("open");
}

function consultarCPF(cpf){  
    if ($("#selMembro").val() == ""){//so consulta se não for um membro
        var retorno = false;
        $.ajax({
        type: "POST",
        url: controlador,
        dataType: 'json',
        cache: false,
        async:false,    
        data: {PES_CPF: cpf, ACO_Descricao: "ConsultarCPFCadastro"}
        }).done(function( data ) {              
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

function consultarCPFEdicao(cpf, idPessoa ){     
    if ($("#selMembro").val() == ""){//so consulta se não for um membro
        var retorno = false;
        $.ajax({
        type: "POST",
        url: controlador,
        dataType: 'json',
        cache: false,
        async:false,    
        data: {PES_CPF_EDICAO: cpf, PES_ID_EDICAO: idPessoa,  ACO_Descricao: "ConsultarCPFCadastro"}
        }).done(function( data ) {        
            if(data.sucesso == "true"){                           
                retorno = true;                
            }else{            
                retorno = false;
            }
        });    
        return retorno; 
    }else{
        return true;; 
    }
}

function formatrCampoPesquisa(){     
    if($("#selPesquisarPor").val() == "cpf"){
        $("#txtPesquisaCampo").mask("999.999.999-99");
    }
    else if($("#selPesquisarPor").val() == "matricula"){
        $("#txtPesquisaCampo").mask("9999.9.999999999");        
    }
    else if($("#selPesquisarPor").val() == "nome"){
        $("#txtPesquisaCampo").unmask();        
    }
    $("#txtPesquisaCampo").val("");    
    $("#txtPesquisaCampo").focus();
}

function exibirDataFalecimento(){
    if ($("#ckbFalecimento").prop("checked")){       
        $("#divDataFalecimento").show();        
    }else{
        $("#divDataFalecimento").hide();
        $("#txtDataFalecimento").val("");
    }
}

function exibirMembro(){ 
    
    if ($("#ckbEmembro").prop("checked")){       
        $("#divEMembro").show(); 
        $("#btnAdicionarFoto").hide();
    }else{
        $("#btnAdicionarFoto").show();
        $("#divEMembro").hide();
        $("#selMembro").val("");
        $('#selMembro').trigger('chosen:updated');
        
        $("#hddFotoMembro").val("");        
        $('#imgFotoSalvar').prop("src", "../../../modulos/sistema/home/img/sem-foto.png");        
        $("#btEditarFoto").prop("disabled", false);  

        $("#ckbFalecimento").prop("checked", false);
        $("#txtDataFalecimento").val("");    
        $("#txtDataFalecimento").prop("disabled", false);          
        exibirDataFalecimento();
        
        $("#txtNome").val("");    
        $("#txtNome").prop("disabled", false);    

        $("#txtDataNascimento").val("");    
        $("#txtDataNascimento").prop("disabled", false);    

        $("#txtCPF").val("");    
        $("#txtCPF").prop("disabled", false);    

        $("#txtTelefone").val("");    
        $("#txtTelefone").prop("disabled", false);    

        $("#txtCelular").val("");    
        $("#txtCelular").prop("disabled", false);    

        $("#txtFormacao").val("");    
        $("#txtFormacao").prop("disabled", false); 

        $("#txtEmailPrimario").val("");    
        $("#txtEmailPrimario").prop("disabled", false);    

        $("#txtEmailSecundario").val("");
        $("#txtEmailSecundario").prop("disabled", false);

        $("#selSexo").val("");
        $("#selSexo").prop("disabled", false);    

        $("#txtMae").val("");
        $("#txtMae").prop("disabled", false);    

        $("#txtPai").val("");
        $("#txtPai").prop("disabled", false);    

        $("#selTipoSanguineo").val("");                                                                      
        $("#selTipoSanguineo").prop("disabled", false);    

        $("#selNivelEscolaridade").val("");        
        $("#selNivelEscolaridade").prop("disabled", false);    
        $("#selNivelEscolaridade").trigger('chosen:updated');

        $("#selEstadoCivil").val("");          
        $("#selEstadoCivil").prop("disabled", false);   
        $("#selEstadoCivil").trigger('chosen:updated');

        $("#txtEnderecoCEP").val("");    
        $("#txtEnderecoCEP").prop("disabled", false);   

        $("#txtEnderecoLogradouro").val("");    
        $("#txtEnderecoLogradouro").prop("disabled", false);   

        $("#txtEnderecoNumero").val("");    
        $("#txtEnderecoNumero").prop("disabled", false);   

        $("#txtEnderecoComplemento").val("");    
        $("#txtEnderecoComplemento").prop("disabled", false);   

        $("#txtEnderecoPontoReferencia").val("");    
        $("#txtEnderecoPontoReferencia").prop("disabled", false);   

        $("#txtEnderecoBairro").val("");    
        $("#txtEnderecoBairro").prop("disabled", false);   

        $("#txtEnderecoCidade").val("");    
        $("#txtEnderecoCidade").prop("disabled", false);   

        $("#selEnderecoUF").val("");                                        
        $("#selEnderecoUF").prop("disabled", false);   

        $("#txtObservacao").val(""); 
        $("#txtObservacao").prop("disabled", false);
        
        $("#txtRG").val("");
        $("#txtRG").prop("disabled", false);
        
        $("#txtRGOrgaoEmissor").val("");
        $("#txtRGOrgaoEmissor").prop("disabled", false);

        $("#txtNaturalidade").val("");
        $("#txtNaturalidade").prop("disabled", false);
        
        $("#txtNascionalidade").val("");
        $("#txtNascionalidade").prop("disabled", false);
        
        $("#ckbDoador").prop("checked", false);
        $("#ckbDoador").prop("disabled", false);
        
    }
}

function preencheDadosMembro(){    
    var idPessoa = $("#selMembro").val();
       
    $.post("../../administrativo/cadastro/controladores/MembroControlador.php", {
        ACO_Descricao: "Consultar",        
        PES_ID: idPessoa
    },
        function(data) {            
            if(data.sucesso == "true"){                
                $("#hddFotoMembro").val(data.rows[0].PES_ArquivoFoto);
                
                if(data.rows[0].PES_ArquivoFoto.length > 0){                                                                                
                    $('#imgFotoSalvar').prop("src", data.rows[0].PES_ArquivoFoto);
                    $('#hddFotoMembro').val(data.rows[0].PES_ArquivoFoto);   
                }else{
                    $('#imgFotoSalvar').prop("src", "../../../modulos/sistema/home/img/sem-foto.png");
                    $('#hddFotoMembro').val(""); 
                } 
                
                if(data.rows[0].PES_DataFalecimento != ""){    
                    $("#ckbFalecimento").prop("checked", true);                                        
                    $("#txtDataFalecimento").val(data.rows[0].PES_DataFalecimento); 
                }else{
                    $("#ckbFalecimento").prop("checked", false);
                    $("#txtDataFalecimento").val("");  
                } 
                exibirDataFalecimento();
                $("#txtDataFalecimento").prop("disabled", true);  
                                
                $("#txtNome").val(data.rows[0].PES_Nome);    
                $("#txtNome").prop("disabled", true);    
                
                $("#txtDataNascimento").val(data.rows[0].PES_DataNascimento);    
                $("#txtDataNascimento").prop("disabled", true);    
                
                $("#txtCPF").val(data.rows[0].PES_CPF);    
                $("#txtCPF").prop("disabled", true);    
                
                $("#txtTelefone").val(data.rows[0].PES_TelefoneResidencial);    
                $("#txtTelefone").prop("disabled", true);    
                
                $("#txtCelular").val(data.rows[0].PES_TelefoneCelular);    
                $("#txtCelular").prop("disabled", true);    
                
                $("#txtEmailPrimario").val(data.rows[0].PES_EmailPrimario);    
                $("#txtEmailPrimario").prop("disabled", true);    
                
                $("#txtEmailSecundario").val(data.rows[0].PES_EmailSecundario);                                        
                $("#txtEmailSecundario").prop("disabled", true);    
                
                $("#selSexo").val(data.rows[0].PES_Sexo);                                    
                $("#selSexo").prop("disabled", true);    
                
                $("#txtMae").val(data.rows[0].PES_MaeNome);                                        
                $("#txtMae").prop("disabled", true);    
                
                $("#txtPai").val(data.rows[0].PES_PaiNome);
                $("#txtPai").prop("disabled", true);    
                
                $("#selTipoSanguineo").val(data.rows[0].PES_GrupoSanguineo);                                                                      
                $("#selTipoSanguineo").prop("disabled", true);    
                
                $("#selNivelEscolaridade").val(data.rows[0].NES_ID);                                 
                $("#selNivelEscolaridade").prop("disabled", true);    
                $("#selNivelEscolaridade").trigger('chosen:updated');
                
                $("#txtFormacao").val(data.rows[0].PES_Formacao);                                        
                $("#txtFormacao").prop("disabled", true);  
                
                $("#selEstadoCivil").val(data.rows[0].ECV_ID);  
                $("#selEstadoCivil").prop("disabled", true);   
                $("#selEstadoCivil").trigger('chosen:updated');
                
                
                $("#txtEnderecoCEP").val(data.rows[0].PES_EnderecoCep);    
                $("#txtEnderecoCEP").prop("disabled", true);   
                
                $("#txtEnderecoLogradouro").val(data.rows[0].PES_EnderecoLogradouro);    
                $("#txtEnderecoLogradouro").prop("disabled", true);   
                
                $("#txtEnderecoNumero").val(data.rows[0].PES_EnderecoNumero);    
                $("#txtEnderecoNumero").prop("disabled", true);   
                
                $("#txtEnderecoComplemento").val(data.rows[0].PES_EnderecoComplemento);    
                $("#txtEnderecoComplemento").prop("disabled", true);   
                
                $("#txtEnderecoPontoReferencia").val(data.rows[0].PES_EnderecoPontoReferencia);    
                $("#txtEnderecoPontoReferencia").prop("disabled", true);   
                
                $("#txtEnderecoBairro").val(data.rows[0].PES_EnderecoBairro);    
                $("#txtEnderecoBairro").prop("disabled", true);   
                
                $("#txtEnderecoCidade").val(data.rows[0].PES_EnderecoCidade);    
                $("#txtEnderecoCidade").prop("disabled", true);   
                
                $("#selEnderecoUF").val(data.rows[0].PES_EnderecoUf);                                        
                $("#selEnderecoUF").prop("disabled", true);   
                
                $("#txtObservacao").val(data.rows[0].PES_Observacao); 
                $("#txtObservacao").prop("disabled", true);
                
                
                $("#txtRG").val(data.rows[0].PES_RG);
                $("#txtRG").prop("disabled", true);
                
                $("#txtRGOrgaoEmissor").val(data.rows[0].PES_RGOrgaoEmissao);
                $("#txtRGOrgaoEmissor").prop("disabled", true);

                $("#txtNaturalidade").val(data.rows[0].PES_Naturalidade);
                $("#txtNaturalidade").prop("disabled", true);
                
                $("#txtNascionalidade").val(data.rows[0].PES_Nacionalidade);
                $("#txtNascionalidade").prop("disabled", true);
                
                if(data.rows[0].PES_Doador == "N"){
                    $("#ckbDoador").prop("checked", false);
                }else{
                    $("#ckbDoador").prop("checked", true);
                }
                $("#ckbDoador").prop("disabled", true);
                
            }
        }, "json"
    );
    return;
    
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
    
    $.post(controlador, {
        ACO_Descricao: "Excluir",
        PES_ID: dg.datagrid('getSelectedRows')[0].cells[0].innerHTML
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

