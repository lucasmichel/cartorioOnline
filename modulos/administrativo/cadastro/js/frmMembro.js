// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/cadastro/controladores/MembroControlador.php";
var controladorEstadoCivil = "../../administrativo/cadastro/controladores/EstadoCivilControlador.php";

var controladorAutoCompleteNaturalidade = "../../administrativo/cadastro/controladores/autoComplete/NaturalidadeControlador.php";
var controladorAutoCompleteNacionalidade = "../../administrativo/cadastro/controladores/autoComplete/NacionalidadeControlador.php";
var controladorAutoCompleteIgrejaNome = "../../administrativo/cadastro/controladores/autoComplete/IgrejaNomeControlador.php";
var controladorAutoCompleteIgrejaPastor = "../../administrativo/cadastro/controladores/autoComplete/IgrejaPastorControlador.php";
var controladorAutoCompleteIgrejaCidade = "../../administrativo/cadastro/controladores/autoComplete/IgrejaCidadeControlador.php";
var dg = $('#grid');

var strBase64ImagemUpload = null;
var dadoEclesiasticoExigeData = false;
var dadoEclesiasticoExigeIgreja = false;

// inicialização
function init(){
    // tabs    
    $('#tabs').tabs();
    $('#tabs-dados').tabs();
    $('#tabs-foto').tabs();   
    
    
    // auto complete
    $("#txtNaturalidade").autocomplete({
        source: controladorAutoCompleteNaturalidade,
        minLength: 2,//search after two characters
        select: function(event,ui){
        //do something
        }
    });
    $("#txtNascionalidade").autocomplete({
        source: controladorAutoCompleteNacionalidade,
        minLength: 2,//search after two characters
        select: function(event,ui){
        //do something
        }
    });
    $("#txtBatismoIgrejaNome").autocomplete({
        source: controladorAutoCompleteIgrejaNome,
        minLength: 2,//search after two characters
        select: function(event,ui){
        //do something
        }
    });
    $("#txtTransferenciaIgrejaNome").autocomplete({
        source: controladorAutoCompleteIgrejaNome,
        minLength: 2,//search after two characters
        select: function(event,ui){
        //do something
        }
    });
    $("#txtBatismoIgrejaPastor").autocomplete({
        source: controladorAutoCompleteIgrejaPastor,
        minLength: 2,//search after two characters
        select: function(event,ui){
        //do something
        }
    });
    $("#txtTransferenciaIgrejaPastor").autocomplete({
        source: controladorAutoCompleteIgrejaPastor,
        minLength: 2,//search after two characters
        select: function(event,ui){
        //do something
        }
    });
    $("#txtBatismoIgrejaCidade").autocomplete({
        source: controladorAutoCompleteIgrejaCidade,
        minLength: 2,//search after two characters
        select: function(event,ui){
        //do something
        }
    });
    $("#txtTransferenciaIgrejaCidade").autocomplete({
        source: controladorAutoCompleteIgrejaCidade,
        minLength: 2,//search after two characters
        select: function(event,ui){
        //do something
        }
    });
    
    
    $('#txtDataAclamacao').datepicker();
    $('#txtDataAclamacao').mask("99/99/9999");
    
    $('#txtBatismoData').datepicker();
    $('#txtBatismoData').mask("99/99/9999");
    
    $('#txtBatismoDataAceito').datepicker();
    $('#txtBatismoDataAceito').mask("99/99/9999");
    
    $('#txtDataReconciliacao').datepicker();
    $('#txtDataReconciliacao').mask("99/99/9999");
    
    $('#txtTransferenciaDataSecao').datepicker();
    $('#txtTransferenciaDataSecao').mask("99/99/9999");
    
    $('#txtBatismoDataAceito').datepicker();
    $('#txtBatismoDataAceito').mask("99/99/9999");
    
    $('#txtTransferenciaDataAceito').datepicker();
    $('#txtTransferenciaDataAceito').mask("99/99/9999");
    
    $('#txtBatismoAno').numeric(); 
    
    
    $('#txtDataAclamacaoEdicao').datepicker();
    $('#txtDataAclamacaoEdicao').mask("99/99/9999");
    
    $('#txtBatismoDataEdicao').datepicker();
    $('#txtBatismoDataEdicao').mask("99/99/9999");
    
    $('#txtBatismoDataAceitoEdicao').datepicker();
    $('#txtBatismoDataAceitoEdicao').mask("99/99/9999");
    
    $('#txtDataReconciliacaoEdicao').datepicker();
    $('#txtDataReconciliacaoEdicao').mask("99/99/9999");
    
    $('#txtTransferenciaDataSecaoEdicao').datepicker();
    $('#txtTransferenciaDataSecaoEdicao').mask("99/99/9999");
    
    $('#txtBatismoDataAceitoEdicao').datepicker();
    $('#txtBatismoDataAceitoEdicao').mask("99/99/9999");
    
    $('#txtTransferenciaDataAceitoEdicao').datepicker();
    $('#txtTransferenciaDataAceitoEdicao').mask("99/99/9999");
    
    $('#txtDataInativacao').datepicker();
    $('#txtDataInativacao').mask("99/99/9999");
    
    $('#txtDataDescricaoInativacao').datepicker();
    $('#txtDataDescricaoInativacao').mask("99/99/9999");
    
    $('#txtBatismoAnoEdicao').numeric(); 
    
    $(".fildDadoEcle").hide();
    
    
    
    
    $('#txtAtividadeDesdeEdicao').datepicker();
    $('#txtAtividadeDesdeEdicao').mask("99/99/9999");
    $('#txtAtividadeAteEdicao').datepicker();
    $('#txtAtividadeAteEdicao').mask("99/99/9999");
    
    $('#txtMinisterioDesdeEdicao').datepicker();
    $('#txtMinisterioDesdeEdicao').mask("99/99/9999");
    $('#txtMinisterioAteEdicao').datepicker();
    $('#txtMinisterioAteEdicao').mask("99/99/9999");

    $('#txtMinisterioDesde').datepicker();
    $('#txtMinisterioDesde').mask("99/99/9999");
    $('#txtMinisterioAte').datepicker();
    $('#txtMinisterioAte').mask("99/99/9999");
    
     
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
    
    $("#dialog-lista-familia").dialog({
        autoOpen: false,
        height:300,
        width:600,
        buttons: {
            "Ok": function() {                         
                $(this).dialog("close"); 
            }
        },
        close: function() 
        {  
            //limpa a session da familia
            limparFamiliar();
        }
    }); 
    
    $("#dialog-contato").dialog({
        autoOpen: false,
        height:350,
        width:600,
        buttons: {
            "Ok": function() {                         
                $(this).dialog("close"); 
            }
        },
        close: function() 
        {  
            //limpa a session fone e email
            limparFone();
            limparEmail();
        }
    });
    
    
    
    // gerencia foto
    $("#dialog-gerencia-foto").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        height:620,
        width:900,
        modal: true,
        buttons: {
            "Adicionar": function() {                              
                if(strBase64ImagemUpload == null){                      
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
            $('#div-camera').photobooth().on( "image", function( event, dataUrl ){                
                $( "#fotoTirada" ).html( "<center><img width='330' height='300' class='fotoTirada'  src='"+dataUrl+"' ></center>");
                $( "#div-foto-nova" ).html( "<center><img width='330' height='300' class='fotoTirada'  src='"+dataUrl+"' ></center>" );
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
    $('#txtCPF').mask("999.999.999-99");
    $('#txtExigeData').datepicker();
    $('#txtExigeData').mask("99/99/9999");    
    
    $('#txtDataDesligamento').datepicker();
    $('#txtDataDesligamento').mask("99/99/9999");    
    $('#txtDataNascimento').datepicker();           
    $('#txtDataNascimento').mask("99/99/9999");    
    $("#txtDataConversao").datepicker();
    $("#txtDataConversao").mask("99/99/9999"); 
    $("#txtDataReconciliacao").datepicker();
    $("#txtDataReconciliacao").mask("99/99/9999");  
    $("#txtDataBatismo").datepicker();
    $("#txtDataBatismo").mask("99/99/9999");    
    $('#txtDataFalecimento').datepicker();    
    $('#txtDataFalecimento').mask("99/99/9999");
    $('#txtDataCasamento').mask("99/99/9999");  
    $('#txtDataCasamento').datepicker();
    $('#txtAtividadeDesde').mask("99/99/9999");  
    $('#txtAtividadeDesde').datepicker();
    $('#txtAtividadeAte').mask("99/99/9999");  
    $('#txtAtividadeAte').datepicker();
    $('#txtEmail').alphanumeric({allow:"._-@"});
    $('#txtEmailEdicao').alphanumeric({allow:"._-@"});
    $('#txtFone').mask("(99) 9999.9999");
    $('#txtFoneEdicao').mask("(99) 9999.9999");
    $('#txtEnderecoCEP').mask("99999-999");
    $('#txtEnderecoCEPEmpresa').mask("99999-999");
    $('#txtEmpresaTelefone').mask("(99) 9999.9999");
    $('#txtEmpresaFax').mask("(99) 9999.9999");  
    $('#txtQuantidadeFilhos').numeric();
    
    gerenciarDataFalecimento(false);   
    gerenciarAtividadeAtual();
    gerenciarEstadoCivil();
    //getMembroSecundario();
    
    gerenciarMinisterioAtual();
    
    
    $("#dialog-add-status").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarADDStatus();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });    
    getStatus();
    
    $("#dialog-add-ministerio").dialog({
        autoOpen: false,
        width:600,
        height: 350,
        buttons: {
            "Salvar": function() {                         
                salvarADDMinisterio();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });    
    getMinisterios();
    
    $("#dialog-add-estadoCivil").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarADDEstadoCivil();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    getEstadoCivil();
    
    
    $("#dialog-add-areaAtuacao").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarADDAreaAtuacao();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    getAreaAtuacao();
    
    
    $("#dialog-add-faixaSalarial").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarADDFaixaSalarial();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    getFaixaSalarial();
    
    
    $("#dialog-add-atividade").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarADDAtividade();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    getAtividade();
    
    
    $("#dialog-add-nivelEscolaridade").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarADDNivelEscolaridade();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    getNivelEscolaridade();
    
    $("#selTipoDadoEclesiastico").trigger("onchange");
    
    
    $("#dialog-add-congregacao").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarADDCongregacao();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    getCongregacao();
    
    $("#selTipoDadoEclesiastico").trigger("onchange");
    
    
    
    $("#dialog-editar-fone").dialog({
        autoOpen: false,
        width:450,
        buttons: {
            "Atualizar": function() {                         
                executarEditarFone();
            }
        }
    });
    
    $("#dialog-editar-email").dialog({
        autoOpen: false,        
        buttons: {
            "Atualizar": function() {                         
                executarEditarEmail();
            }
        }
    });
    
    $("#dialog-editar-dadoEclesiastico").dialog({
        autoOpen: false,
        width:860,
        height:250,
        buttons: {
            "Atualizar": function() {                         
                executarEditarDadoEclesiastico();
            }
        }
    });
    
    
    $("#dialog-editar-atividade").dialog({
        autoOpen: false,
        width:650,
        height:400,
        buttons: {
            "Atualizar": function() {                         
                executarEditarAtividade();
            }
        }
    });
    
    $("#dialog-editar-ministerio").dialog({
        autoOpen: false,
        width:900,
        height:400,
        buttons: {
            "Atualizar": function() {                         
                executarEditarMinisterio();
            }
        }
    });
    
    
    
    // configura o grid
    initGRID();   
    // carrega o grid
    consultar();
    
    //PARA OS RADIO BUTONS DA ABA FAMILIAR
    $("input:radio[name=tipoFamiliar]").click(function() {
        var value = $(this).val();
        if(value == "membro"){
            $("#fildColunaFamiliarNaoMembro").hide();
            $("#fildColunaFamiliarMembro").show();
            $("#selMembroSecundario").focus();
        }else{
            $("#fildColunaFamiliarMembro").hide();
            $("#fildColunaFamiliarNaoMembro").show();
            $("#txtNomeFamiliar").focus();
        }        
    });    
    $("#radioMembro").attr("checked", true);
    $("#radioMembro").trigger("click");
    //PARA OS RADIO BUTONS DA ABA FAMILIAR
}

// FOTO
// visualização da foto
function tirarFoto(){
    $("#dialog-gerencia-foto").dialog("open");
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
        var pesquisaCampo     = $("#txtPesquisaCampo").val(); 
        var pesquisaPor       = $("#selPesquisarPor").val();        
        var pesquisaUnidade   = $("#selPesquisaUnidade").val();
        
        var pesquisaNivelEsc  = $("#selPesquisaNivelEscolaridade").val();   
        var pesquisaStatus    = $("#selPesquisaStatus").val();    
        var pesquisaSexo      = $("#selPesquisaSexo").val(); 
        var pesquisaEstadoCiv = $("#selPesquisaEstadoCivil").val();        
        var pesquisaTipo      = $("#selPesquisaTipo").val();
        
        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar",
            PESQ_Campo: pesquisaCampo,
            PESQ_Por: pesquisaPor,
            UNI_ID: pesquisaUnidade,
            PES_Sexo: pesquisaSexo,
            NES_ID: pesquisaNivelEsc,
            ECV_ID: pesquisaEstadoCiv,
            MES_ID: pesquisaStatus,
            MEM_Tipo: pesquisaTipo,
            GRID: true,
            limit: limitConsulta,
            offset: 0
        };
        /*$.ajax({
            type: "POST",
            url: controlador,
            //dataType: "json",
            async: false,
            data: params
        })
        .done(function( data ) {        
             alert(data);
        });
        return;*/
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
                        $("#hddID").val(dg.datagrid('getSelectedRows')[0].cells[0].innerHTML); 
                        
                        preLoadingOpen(null);
                                                                    
                        $.post(controlador, {
                            ACO_Descricao: "Consultar",
                            PES_ID: $("#hddID").val()
                        },
                            function(data){
                                if(data.sucesso == "true"){
                                    //getMembroSecundario();
                                    carregarTabelasAuxiliares(data.rows[0].PES_ID);                                    
                                    
                                    $("#hddID").val(data.rows[0].PES_ID);
                                    $("#hddStatus").val(data.rows[0].PES_Status);
                                    $("#hddMatricula").val(data.rows[0].PES_Matricula);                                    
                                    $("#hddFotoMembro").val(data.rows[0].PES_ArquivoFoto);
                                    
                                    if(data.rows[0].PES_ArquivoFoto){                                                                                
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
                                    
                                    $('#txtNumeroFicha').val(data.rows[0].MEM_NumeroFicha);
                                    $("#txtNome").val(data.rows[0].PES_Nome); 
                                    
                                    $("#selStatus").val(data.rows[0].MES_ID); 
                                    $('#selStatus').trigger('chosen:updated');
                                    console.log("TIPO :"+data.rows[0].MEM_Tipo);
                                    $("#selTipo").val(data.rows[0].MEM_Tipo); 
                                    $('#selTipo').trigger('chosen:updated');
                                    
                                    $("#txtDataNascimento").val(data.rows[0].PES_DataNascimento);    
                                    $("#txtCPF").val(data.rows[0].PES_CPF);   
                                    $("#txtRG").val(data.rows[0].PES_RG);
                                    $("#txtRGOrgaoEmissor").val(data.rows[0].PES_RGOrgaoEmissao);                                    
                                    $("#txtNaturalidade").val(data.rows[0].PES_Naturalidade);
                                    $("#selUfNascimento").val(data.rows[0].PES_UfNascimento);
                                    $("#txtNascionalidade").val(data.rows[0].PES_Nacionalidade);                                    
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
                                    gerenciarEstadoCivil();                                    
                                    $("#txtDataCasamento").val(data.rows[0].PES_DataCasamento);
                                    
                                    if(data.rows[0].PES_Doador == "N"){
                                        $("#ckbDoador").prop("checked", false);
                                    }else{
                                        $("#ckbDoador").prop("checked", true);
                                    } 
                                    
                                    $("#txtFormacao").val(data.rows[0].PES_Formacao); 
                                    
                                    $("#txtQuantidadeFilhos").val(data.rows[0].PES_QuantidadeFilhos);
                                    
                                    $("#selFaixaSalarial").val(data.rows[0].ARS_ID);    
                                    $('#selFaixaSalarial').trigger('chosen:updated');
                                    
                                    $("#txtEnderecoCEP").val(data.rows[0].PES_EnderecoCep);    
                                    $("#txtEnderecoLogradouro").val(data.rows[0].PES_EnderecoLogradouro);    
                                    $("#txtEnderecoNumero").val(data.rows[0].PES_EnderecoNumero);    
                                    $("#txtEnderecoComplemento").val(data.rows[0].PES_EnderecoComplemento);    
                                    $("#txtEnderecoPontoReferencia").val(data.rows[0].PES_EnderecoPontoReferencia);    
                                    $("#txtEnderecoBairro").val(data.rows[0].PES_EnderecoBairro);    
                                    $("#txtEnderecoCidade").val(data.rows[0].PES_EnderecoCidade);    
                                    $("#selEnderecoUF").val(data.rows[0].PES_EnderecoUf);                                        
                                    $("#txtObservacao").val(data.rows[0].PES_Observacao);    
                                       
                                    $("#txtNomeEmpresa").val(data.rows[0].MEM_EmpresaNome);    
                                    $("#txtEmpresaTelefone").val(data.rows[0].MEM_EmpresaTelefoneComercial);    
                                    $("#txtEmpresaFax").val(data.rows[0].MEM_EmpresaTelefoneFax);    
                                    $("#txtEnderecoCEPEmpresa").val(data.rows[0].MEM_EmpresaEnderecoCep);    
                                    $("#txtEnderecoLogradouroEmpresa").val(data.rows[0].MEM_EmpresaEnderecoLogradouro);    
                                    $("#txtEnderecoNumeroEmpresa").val(data.rows[0].MEM_EmpresaEnderecoNumero);    
                                    $("#txtEnderecoComplementoEmpresa").val(data.rows[0].MEM_EmpresaEnderecoComplemento);    
                                    $("#txtEnderecoPontoReferenciaEmpresa").val(data.rows[0].MEM_EmpresaEnderecoPontoReferencia);    
                                    $("#txtEnderecoBairroEmpresa").val(data.rows[0].MEM_EmpresaEnderecoBairro);    
                                    $("#txtEnderecoCidadeEmpresa").val(data.rows[0].MEM_EmpresaEnderecoCidade);    
                                    $("#selEnderecoUFEmpresa").val(data.rows[0].MEM_EmpresaEnderecoUf);
                                    $("#txtProfissao").val(data.rows[0].MEM_Profissao);
                                    
                                    $("#txtDataConversao").val(data.rows[0].MEM_DataConversao);
                                    $("#txtDescricaoConversao").val(data.rows[0].MEM_DescricaoConversao);
                                    
                                    $("#txtDataReconciliacao").val(data.rows[0].MEM_DataReconciliacao);
                                    $("#txtDescricaoReconciliacao").val(data.rows[0].MEM_DescricaoReconciliacao);
                                    
                                    $("#txtDataBatismo").val(data.rows[0].MEM_DataBatismo);
                                    $("#txtDescricaoBatismo").val(data.rows[0].MEM_DescricaoBatismo);
                                    
                                    if(data.rows[0].PES_DataFalecimento != null){    
                                        $("#ckbFalecimento").prop("checked", true);                                        
                                        $("#txtDataFalecimento").val(data.rows[0].PES_DataFalecimento); 
                                    }else{
                                        $("#ckbFalecimento").prop("checked", false);
                                        $("#txtDataFalecimento").val("");    
                                    } 
                                    
                                    
                                    if(data.rows[0].MEM_TemEmprego == "N"){
                                        $("#ckbTemEmprego").prop("checked", false);
                                    }else{
                                        $("#ckbTemEmprego").prop("checked", true);
                                    }              
                                    
                                    // processo para retirar do selMembroSecundario
                                    // os membros que estão na sessão
                                    /*$("#selMembroSecundario").find('[value="'+data.rows[0].PES_ID+'"]').remove();
                                    $("#selMembroSecundario").val("");
                                    $("#selMembroSecundario").trigger('chosen:updated');*/
                                    
                                    $("#selUnidade").val(data.rows[0].UNI_ID);
                                    $("#selUnidade").trigger('chosen:updated');
                                    
                                    // inativação
                                    if($.trim(data.rows[0].MEM_MotivoInativacao) != ""){
                                        $("#ckbFalecimento").prop("checked", true);
                                        gerenciarDataFalecimento(false);                                        
                                        
                                        $("#txtDataInativacao").val($.trim(data.rows[0].MEM_DataInativacao));
                                        $("#selMotivoInativacao").val($.trim(data.rows[0].MEM_MotivoInativacao));
                                        $("#selMotivoInativacao").trigger('chosen:updated');
                                        
                                        gereciarMotivoInativacao();
                                        
                                        $("#txtDescricaoInativacao").val($.trim(data.rows[0].MEM_DescricaoInativacao));
                                        $("#txtDataDescricaoInativacao").val($.trim(data.rows[0].MEM_DataDescricaoInativacao));
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
            },{
                label: 'Família'
                ,icon: 'home'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){
                        // pega o id do registro
                        var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;                        
                        exibirListaFamilia(id);
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o membro para exibir a familia.");        
                        $("#dialog-atencao").dialog("open"); 
                    }
                }                
            
            },{
                label: 'Ficha Membro'
                ,icon: 'print'
                ,fn: function(){
                    if(dg.datagrid('getSelectedRows').length > 0){
                        // pega o id do registro
                        var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;                        
                        var url = "../../administrativo/cadastro/documentos/FichaMembro.php?PES_ID=" + id;
                        novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja imprimir.");        
                        $("#dialog-atencao").dialog("open"); 
                    }
                }
                
            },{
                label: 'Cer. de Batismo'
                ,icon: 'print'
                ,fn: function(){                    
                    if(dg.datagrid('getSelectedRows').length > 0){
                        // pega o id do registro
                        var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;                        
                        imprimirCertifiadoBatismo(id);
                        
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja imprimir.");        
                        $("#dialog-atencao").dialog("open"); 
                    }
                    
                }            
            },{
                label: 'Carteira'
                ,icon: 'print'
                ,fn: function(){                    
                    if(dg.datagrid('getSelectedRows').length > 0){
                        // pega o id do registro
                        var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;                        
                        imprimirCarteira(id);
                        
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja imprimir.");        
                        $("#dialog-atencao").dialog("open"); 
                    }    
                }                            
            },{
                label: 'Contatos'
                ,icon: 'star'
                ,fn: function(){                    
                    if(dg.datagrid('getSelectedRows').length > 0){
                        // pega o id do registro
                        var id = dg.datagrid('getSelectedRows')[0].cells[0].innerHTML;                        
                        listarContatos(id);
                        
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o registro que deseja exbir seus contatos.");        
                        $("#dialog-atencao").dialog("open"); 
                    }    
                }                
            }
        ]
        ,mapper:[{
            name: 'PES_ID', title: 'Cód.', width: 60, align: 'left'
        }/*,{
            name: 'PES_ArquivoFoto', title: 'Foto', width: 60, align: 'center', render: function(foto) {                
                if(foto.length > 0){                      
                    return '<img  src="'+foto+'"  width="25" height="30" />';                                        
                }else{
                    return '<img src="../../../modulos/sistema/home/img/semFoto.png"  width="25" height="30" />';
                }
            }        
        }*/,{
            name: 'PES_Nome', title: 'Nome', width: 340, align: 'left'                
        },{
            name: 'DAM_Data', title: 'Dt. Batismo', width: 80, align: 'center'        
        },{
            name: 'PES_DataNascimento', title: 'Dt. Nasc.', width: 75, align: 'center'
        },{        
            name: 'PES_Idade', title: 'Idade', width: 80, align: 'center'
        },{
            name: 'PES_CPF', title: 'CPF', width: 100, align: 'center'                
        },{
            name: 'PES_Matricula', title: 'Matrícula', width: 110, align: 'center'        
        },{
            name: 'MEM_Tipo', title: 'Tipo', width: 100, align: 'center'        
        },{
            name: 'MES_Descricao', title: 'Status', width: 100, align: 'center'
        },{
            name: 'PES_StatusAtualizacao', title: 'Atualização', width: 60, align: 'center', render: function(cor){                
                if(cor=="verde"){
                    return '<img src="../../../modulos/sistema/home/img/statusAtualizacaoVerde.png" title="atulizado" width="20" height="20" />';
                }else if(cor=="amarelo"){
                    return '<img src="../../../modulos/sistema/home/img/statusAtualizacaoAmarelo.png" title="desatualizado" width="20" height="20" />';
                }else{
                    return '<img src="../../../modulos/sistema/home/img/statusAtualizacaoVermelho.png" title="nunca atualizado" width="20" height="20" />';
                }
                
                
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
    
    if($.trim($('#txtNome').val()) == ""){                
        $('#tabs-dados').tabs('option', 'active', 0); // permance na aba 1       
        $("#hddFocus").val("txtNome");
        
        $("#dialog-atencao").html("Por favor, informe o nome do membro.");
        $("#dialog-atencao").dialog("open");        
        return;
    }
    
    if($.trim($('#selStatus').val()) == ""){        
        $('#tabs-dados').tabs('option', 'active', 0); // permance na aba 1
        $("#hddFocus").val("selStatus");
        
        $("#dialog-atencao").html("Por favor, informe o status do membro.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#txtCPF').val()) != ""){        
        if(!isCPFValido($('#txtCPF').val())){
            $('#tabs-dados').tabs('option', 'active', 0); // permance na aba 1
            $("#hddFocus").val("txtCPF");
            
            $("#dialog-atencao").html("Por favor, informe um CPF v&aacute;lido.");        
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    // verifica se o CPF já existe na base de dados
    if(acaoExecutada == "Salvar"){          
        if($.trim($('#txtCPF').val()) != ""){
            if(!consultarCPF($('#txtCPF').val())){        
                $('#tabs-dados').tabs('option', 'active', 0); // permance na aba 1
                $("#hddFocus").val("txtCPF");
                
                $("#dialog-atencao").html("O CPF informado j&aacute; est&aacute; cadastrado.");        
                $("#dialog-atencao").dialog("open");
                return;
            }
        }        
    }else{                
        if($.trim($('#txtCPF').val()) != ""){        
            if(!consultarCPFEdicao($('#txtCPF').val(), $('#hddID').val())){                        
                $('#tabs-dados').tabs('option', 'active', 0); // permance na aba 1
                $("#hddFocus").val("txtCPF");
                
                $("#dialog-atencao").html("O CPF informado j&aacute; est&aacute; cadastrado.");        
                $("#dialog-atencao").dialog("open");
                return;
            }
        }
    }
    
    if($.trim($('#txtDataNascimento').val()) == ""){        
        $('#tabs-dados').tabs('option', 'active', 0); // permance na aba 1
        $("#hddFocus").val("txtDataNascimento");
        
        $("#dialog-atencao").html("Por favor, informe a data de nascimento do membro.");
        $("#dialog-atencao").dialog("open");
        return;
    }   
    
    if(!isDataValida($('#txtDataNascimento').val())){        
        $('#tabs-dados').tabs('option', 'active', 0); // permance na aba 1
        $("#hddFocus").val("txtDataNascimento");
        
        $("#dialog-atencao").html("Por favor, informe uma data de nascimento v&aacute;lida.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim($('#selSexo').val()) == ""){        
        $('#tabs-dados').tabs('option', 'active', 0); // permance na aba 1
        $("#hddFocus").val("selSexo");
        
        $("#dialog-atencao").html("Por favor, informe o sexo do membro.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($('#ckbFalecimento').prop("checked")){        
        if($.trim($("#txtDataInativacao").val()) != ""){
            if(!isDataValida($.trim($("#txtDataInativacao").val()))){
                $('#tabs-dados').tabs('option', 'active', 6);
                $("#hddFocus").val("txtDataInativacao");
                $("#dialog-atencao").html("A data de inativação é inválida.");
                $("#dialog-atencao").dialog("open");
                return;
            }
        }else{
            $('#tabs-dados').tabs('option', 'active', 6);
            $("#hddFocus").val("txtDataInativacao");
            $("#dialog-atencao").html("Por favor, informe a data de inativação.");
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
    limparFamiliar();
    limparDadoEclesiastico();
    limparEmail();
    limparFone();
    limparProcessoDesligamento();
    limparAtividade();
    limparMinisterio();
    
    $("#hddID").val("");
    $("#hddMatricula").val("");
    $('#txtNumeroFicha').val("");
    $("#hddFocus").val("");
    $("#hddFotoMembro").val("");    
    $("#txtNome").val("");    
    $("#txtDataNascimento").val("");    
    $("#txtCPF").val("");    
    /*$("#txtTelefone").val("");    
    $("#txtCelular").val("");    
    $("#txtEmailPrimario").val("");    
    $("#txtEmailSecundario").val("");*/         
    $("#txtMae").val("");    
    $("#txtPai").val("");
    $("#txtQuantidadeFilhos").val("0");
    $("#txtObservacao").val("");    
    $("#txtFormacao").val("");  
    $("#txtProfissao").val(""); 
    $("#selTipoSanguineo").val("");     
    $("#selSexo").val("");        
    $("#selAreaAtuacao").val("");    
    $('#selAreaAtuacao').trigger('chosen:updated');       
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
    $("#txtNomeEmpresa").val("");    
    $("#txtEmpresaTelefone").val("");    
    $("#txtEmpresaFax").val("");    
    $("#txtEnderecoCEPEmpresa").val("");    
    $("#txtEnderecoLogradouroEmpresa").val("");    
    $("#txtEnderecoNumeroEmpresa").val("");    
    $("#txtEnderecoComplementoEmpresa").val("");    
    $("#txtEnderecoPontoReferenciaEmpresa").val("");    
    $("#txtEnderecoBairroEmpresa").val("");    
    $("#txtEnderecoCidadeEmpresa").val("");    
    $("#selEnderecoUFEmpresa").val("");       
    $("#txtDataFalecimento").val("");
    $("#txtNaturalidade").val("");
    $("#selUfNascimento").val("");
    $("#txtNascionalidade").val("BRASILEIRA");
    $("#txtRG").val("");
    $("#txtRGOrgaoEmissor").val("");
    $("#ckbDoador").prop("checked", false);    
    $("#selStatus").val("1");  
    $('#selStatus').trigger('chosen:updated');
    $("#selFaixaSalarial").val("");    
    $('#selFaixaSalarial').trigger('chosen:updated');    
    $("#ckbTemEmprego").prop("checked", false);    
    $("#ckbFalecimento").prop("checked", false);
        
    $("#txtDataInativacao").val("");
    $("#selMotivoInativacao").val("TRANSFERENCIA");
    $("#selMotivoInativacao").trigger('chosen:updated');
    $("#txtDescricaoInativacao").val("");
    $("#txtDataDescricaoInativacao").val("");
    
    $('#imgFotoSalvar').prop("src", "../../../modulos/sistema/home/img/sem-foto.png");
    $('#hddFotoMembro').val("");     
    $( "#fotoTirada" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
    $( "#div-foto-nova" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
    $( "#div-foto-existente" ).html( '<center><img src="../../../modulos/sistema/home/img/sem-foto.png" ></center>');
    
    strBase64ImagemUpload = null;    
    
    $("#ckbStatus").prop("checked", false);    
    $('#tabs').tabs('option', 'active', 0);
    $('#tabs-dados').tabs('option', 'active', 0); 
    
    $("#selUnidade").val("");
    $('#selUnidade').trigger('chosen:updated');
    
    gerenciarEstadoCivil();
    gerenciarDataFalecimento(false);
    gerenciarAtividadeAtual();
    //getMembroSecundario();
    
    $("#selTipoDadoEclesiastico").val("BATISMO");
    $("#selTipoDadoEclesiastico").trigger("onchange");
    
    //$(".fildDadoEcle").hide();
}




function fichadoMembro(id){    
    var url = "../../administrativo/cadastro/documentos/FichaMembro.php?PES_ID=" + id;
    novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
}



function exibirListaFamilia(idMembro){    
    $.post(controlador, {
        ACO_Descricao: "ConsultarFamilia",
        PES_ID: idMembro
    },
        function(data){
            if(data.sucesso == "true"){
                
                    html = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                        html += '<tr class="cabecalhoTabela">';                            
                            html += '<td width="300px">Nome</td>';
                            html += '<td width="150px">Relacionamento</td>';                                                            
                        html += '</tr>';
                    var classDif = '';    

                    for(var i=0; i<data.rows.length; i++){
                        classDif = 'class="linhaNormal"';
                        if(i%2 == 0){
                            classDif = 'class="linhaCor"';
                        }
                        
                        html += '<tr ' + classDif +'>';    
                        
                        var link;
                        if(data.rows[i].PES_Secundario_ID){
                            link = "<a href='javascript:void(0);' onclick='fichadoMembro(" + data.rows[i].PES_Secundario_ID + " );' > "+data.rows[i].PES_Nome_Secundario+" </a>  ";
                        }else{
                            link = data.rows[i].FAM_Nome;
                        }
                            
                        
                        html += '<td>' + link + '</td>';
                        html += '<td>' + data.rows[i].FAM_GrauParentesco + '</td>';

                        //html += '<td align="center">';                                    
                            //html += "<a href='javascript:void(0);' title='Remover: " + data.rows[i].PES_Secundario_Nome + "'><img onclick='removerFamiliar(" + data.rows[i].ID + ",     \"" + data.rows[i].PES_Secundario_Nome + "\",   " + data.rows[i].PES_Secundario_ID + "    );' class='btnExcluirFamiliar' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>";
                        //html += '</td>';


                        html += '</tr>';
                    }                        
                    html += '</table>';               
            }else{
                if(data.excecao == "true"){
                    var dialog = "dialog-excecao";                    
                    $("#" + dialog).html(data.mensagem);
                    $("#" + dialog).dialog("open");
                }else{
                    var html = '<p>';
                    
                    html += 'Família não cadastrada.';
                    
                    html += '</p>';
                }
            }
            
            $("#dialog-lista-familia").dialog("open");
            $("#div-lista-familia").html(html);
        }, "json"
    );
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

function consultarCPF(cpf){    
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
}

function consultarCPFEdicao(cpf, idPessoa ){ 
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
}

function gerenciarAtividadeAtual(){    
    if ($("#ckbTarefaAual").prop("checked")){       
        $("#txtAtividadeAte").val("");
        $("#txtAtividadeAte").prop('disabled', true);                
    }else{
        $("#txtAtividadeAte").prop('disabled', false);
    }
}

function gerenciarAtividadeAtualEdicao(){    
    if ($("#ckbTarefaAualEdicao").prop("checked")){       
        $("#txtAtividadeAteEdicao").val("");
        $("#txtAtividadeAteEdicao").prop('disabled', true);                
    }else{
        $("#txtAtividadeAteEdicao").prop('disabled', false);
    }
}

function carregarMembrosFamiliar(){
    $('#selMembroSecundario').html("<option value=''>SELECIONE</option>");                
    $('#selMembroSecundario').trigger('chosen:updated');    
    $('#selGrauParentesco').val("");
    
    $.post(controlador, {
        ACO_Descricao: "Consultar",
        PES_Status: "A"
    },
        function(data) {            
            if(data.sucesso == "true"){
                /*var options = '<option value=""></option>';                
                for (var i = 0; i < data.rows.length; i++) {                    
                    options += '<option value="' + data.rows[i].PES_ID + '">' + data.rows[i].PES_Nome + '</option>';
                }	
                $('#selMembroSecundario').html(options);                
                $('#selMembroSecundario').trigger('chosen:updated'); */                
            }
        }, "json"
    );
}

function addAtividade(){
    var ATV_ID   = $("#selAtividade").val();        
    var ATV_Descricao = $("#selAtividade :selected").text();    
    var ATM_Desde  = $("#txtAtividadeDesde").val();
    var ATM_Ate = $("#txtAtividadeAte").val();    
    if($.trim(ATV_ID) == ""){                        
        $("#hddFocus").val("selAtividade");
        $("#dialog-atencao").html("Por favor, informe a atividade.");
        $("#dialog-atencao").dialog("open");        
        return;
    }  
    if($.trim(ATM_Desde) == ""){                
        $("#hddFocus").val("txtAtividadeDesde");
        $("#dialog-atencao").html("Por favor, informe a data de início da atividade.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    if(!isDataValida(ATM_Desde)){                
        $("#hddFocus").val("txtAtividadeDesde");
        $("#dialog-atencao").html("Por favor, informe uma data de início de atividade válida.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    if(!$("#ckbTarefaAual").prop("checked")){
        if($.trim(ATM_Ate) == ""){                
            $("#hddFocus").val("txtAtividadeAte");
            $("#dialog-atencao").html("Por favor, informe a data de término da atividade.");
            $("#dialog-atencao").dialog("open");
            return;
        }  
        if(!isDataValida(ATM_Ate)){                
            $("#hddFocus").val("txtAtividadeAte");
            $("#dialog-atencao").html("Por favor, informe uma data de término de atividade válida.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    if( (ATM_Desde != "") && (ATM_Ate != "") ){        
        //compararDatas(strDataInicial, strHoraInicial, strDataFinal, strHoraFinal){
        /******** COMPARA DATA NO FORMATO DD/MM/AAAA 00:00 *******/
        //se não quiser informar oo horario, definir as variaves de hora na função como null        
        if(!compararDatas(ATM_Desde, null, ATM_Ate, null)){
            $("#hddFocus").val("txtAtividadeAte");
            $("#dialog-atencao").html("Por favor, a data de término deve ser maior do que a data de início da atividade.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }

    $.post(controlador, {
        ACO_Descricao: "AdicionarAtividade", 
        ATV_ID:  ATV_ID,
        ATM_Desde: ATM_Desde,
        ATM_Ate: ATM_Ate,
        ATV_Descricao: ATV_Descricao
    },
        function(data) {
            //alert(data);
            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }   
            
            if(data.sucesso == "true"){ 
                $("#selAtividade").val("");                
                $("#selAtividade").trigger('chosen:updated');
                
                $("#txtAtividadeDesde").val("");
                $("#txtAtividadeAte").val("");
                
                $("#ckbTarefaAual").prop("checked", false);                
                $("#hddFocus").val("selAtividade");
                focus($("#hddFocus").val());
                
                gerenciarAtividadeAtual();
                listarAtividade();
            }
            
        },"json"
    );    
}

function limparAtividade(){
    $.post(controlador, {
        ACO_Descricao: "LimparAtividade"
    },
        function(data){                     
            var html = '';
            if(data.sucesso == "true"){           
                //carregarMembrosFamiliar();
                html = '<p>';
                    html += 'Nenhuma atividade adicionada.';
                html += '<p>';                    
                $("#div-grid-tarefa").html(html);
            }else{
                if(data.excecao == "true"){
                    var dialog = "dialog-excecao";                    
                    $("#" + dialog).html(data.mensagem);
                    $("#" + dialog).dialog("open");
                }
            }
        }, "json"
    );
}

function listarAtividade(){    
    $.post(controlador, {
        ACO_Descricao: "ListarAtividade"
    },
        function(data){                     
            var html = '';

            if(data.sucesso == "true"){

                html += '<p>HISTÓRICO DE AIVIDADES</p><table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="300px">Atividade</td>';
                        html += '<td width="150px">Desde</td>';                                
                        html += '<td width="150px">Até</td>';                                
                        html += '<td align="center" width="40px">Ações</td>'; 
                    html += '</tr>';

                var classDif = '';    

                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';

                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }

                    //remove o membro primario do select                
                    /*$("#selMembroSecundario").find('[value="'+data.rows[i].PES_Secundario_ID+'"]').remove();
                    $("#selMembroSecundario").val("");
                    $("#selMembroSecundario").trigger('chosen:updated');*/
                    console.log(data.rows[i]);
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].ATV_Descricao + '</td>';
                        html += '<td>' + data.rows[i].ATM_Desde + '</td>';
                        if(data.rows[i].ATM_Ate ==  null ){
                            html += '<td> </td>';
                        }else{
                            html += '<td>' + data.rows[i].ATM_Ate + '</td>';                            
                        }
                        

                        html += '<td align="center">';
                            html += "<a href='javascript:void(0);' title='Editar: " + data.rows[i].ATV_Descricao + " '><img onclick='editarAtividade(" + data.rows[i].ID + " );' class='btnEditarAtividade' alt='editar' src='../../../modulos/sistema/home/img/botao-editar.png' border='0' width='11px' height='11px' /></a> &nbsp;&nbsp;&nbsp; ";
                            html += "<a href='javascript:void(0);' title='Remover: " + data.rows[i].ATV_Descricao + " '><img onclick='removerAtividade(" + data.rows[i].ID + " );' class='btnExcluirAtividade' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>  ";                            
                            
                        html += '</td>';                                
                    html += '</tr>';
                }                        
                html += '</table>';

            }else{
                html = '<p>';
                    html += 'Nenhuma atividade adicionada.';
                html += '<p>';
            }                    
            $("#div-grid-tarefa").html(html);

        }, "json"
    );
}


function getAtividadeEdicao(){
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/AtividadeControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", ATV_Status: "A"}
    })
    .done(function( data ) {
        $("#selAtividadeEdicao").html("<option value=''></option>");        
        if(data.sucesso == "true"){
            var html = '';            
            for(var i=0; i<data.rows.length; i++){                
                
                html += '<option value="' + data.rows[i].ATV_ID + '">' + data.rows[i].ATV_Descricao + '</option>';
            }
            
            $("#selAtividadeEdicao").html(html);
            $("#selAtividadeEdicao").trigger('chosen:updated');
        }
    });
}
function editarAtividade(idAtividade){
    $.post(controlador, {
        ACO_Descricao: "BuscarAtividade",
        ID: idAtividade
    },
        function(data){                                 
                if(data.sucesso == "true"){                    
                    $("#hddIDAtividade").val(data.rows.ID);                    
                    getAtividadeEdicao();
                    $("#selAtividadeEdicao").val(data.rows.ATV_ID);
                    $("#selAtividadeEdicao").trigger('chosen:updated');                    
                    $("#txtAtividadeDesdeEdicao").val(data.rows.ATM_Desde);
                    
                    if(data.rows.ATM_Ate == ""){                        
                        $("#ckbTarefaAualEdicao").prop("checked", true);                        
                        $("#txtAtividadeAteEdicao").val("");
                        $("#txtAtividadeAteEdicao").prop("disabled", true);                        
                        
                    }else{
                        $("#txtAtividadeAteEdicao").val(data.rows.ATM_Ate);                        
                        $("#ckbTarefaAualEdicao").prop("checked", false);
                        $("#txtAtividadeAteEdicao").prop("disabled", false);
                        
                    }     
                    $("#dialog-editar-atividade").dialog("open");
                    
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}

function executarEditarAtividade(){
    var ATV_ID   = $("#selAtividadeEdicao").val();        
    var ATV_Descricao = $("#selAtividadeEdicao :selected").text();    
    var ATM_Desde  = $("#txtAtividadeDesdeEdicao").val();
    var ATM_Ate = $("#txtAtividadeAteEdicao").val();
    var ID   = $("#hddIDAtividade").val();  
    
    
    if($.trim(ATV_ID) == ""){                        
        $("#hddFocus").val("selAtividadeEdicao");
        $("#dialog-atencao").html("Por favor, informe a atividade.");
        $("#dialog-atencao").dialog("open");        
        return;
    }  
    if($.trim(ATM_Desde) == ""){                
        $("#hddFocus").val("txtAtividadeDesdeEdicao");
        $("#dialog-atencao").html("Por favor, informe a data de início da atividade.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    if(!isDataValida(ATM_Desde)){                
        $("#hddFocus").val("txtAtividadeDesdeEdicao");
        $("#dialog-atencao").html("Por favor, informe uma data de início de atividade válida.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    if(!$("#ckbTarefaAualEdicao").prop("checked")){
        if($.trim(ATM_Ate) == ""){                
            $("#hddFocus").val("txtAtividadeAteEdicao");
            $("#dialog-atencao").html("Por favor, informe a data de término da atividade.");
            $("#dialog-atencao").dialog("open");
            return;
        }  
        if(!isDataValida(ATM_Ate)){                
            $("#hddFocus").val("txtAtividadeAteEdicao");
            $("#dialog-atencao").html("Por favor, informe uma data de término de atividade válida.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    if( (ATM_Desde != "") && (ATM_Ate != "") ){        
        //compararDatas(strDataInicial, strHoraInicial, strDataFinal, strHoraFinal){
        /******** COMPARA DATA NO FORMATO DD/MM/AAAA 00:00 *******/
        //se não quiser informar oo horario, definir as variaves de hora na função como null        
        if(!compararDatas(ATM_Desde, null, ATM_Ate, null)){
            $("#hddFocus").val("txtAtividadeAteEdicao");
            $("#dialog-atencao").html("Por favor, a data de término deve ser maior do que a data de início da atividade.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }

    $.post(controlador, {
        ACO_Descricao: "SalvarEditarAtividade", 
        ATV_ID:  ATV_ID,
        ATM_Desde: ATM_Desde,
        ATM_Ate: ATM_Ate,
        ATV_Descricao: ATV_Descricao,
        ID: ID
    },
        function(data) {
            //alert(data);
            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            if(data.sucesso == "true"){                 
                
                
                $("#selAtividadeEdicao").val("");
                $("#selAtividadeEdicao").trigger('chosen:updated');                    
                
                $("#ckbTarefaAualEdicao").prop("checked", false);
                $("#txtAtividadeDesdeEdicao").val("");
                $("#txtAtividadeAteEdicao").val("");
                $("#hddIDAtividade").val("");  
                
                $("#dialog-editar-atividade").dialog("close");
                listarAtividade();                                
                
            }
            
        },"json"
    );     
}

function removerAtividade(ID){    
    $.post(controlador, {
        ACO_Descricao: "ExcluirAividade", 
        ID: ID
    },
        function(data) {    
            
            if(data.sucesso == "true"){                
                listarAtividade();
            }
            
        },"json"
    );
}



function validarRelacionamentoFamiliar(PES_Secundario_ID, FAM_GrauParentesco){
    var retorno = null
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {
            ACO_Descricao: "validarRelacionamentoFamiliar", 
            PES_Secundario_ID: PES_Secundario_ID, 
            FAM_GrauParentesco:FAM_GrauParentesco
        }        
    })
    .done(function( data ) {                
        if(data.sucesso == "true"){
            retorno = true;
        }else{                          
            $("#dialog-excecao").html(data.mensagem);
            $("#dialog-excecao").dialog("open");
            retorno = false;
        }
    });
    return retorno;
}


// FAMILIA
function addFamiliar(){
    var PES_Secundario_ID   = $("#selMembroSecundario").val();    
    var FAM_GrauParentesco  = $("#selGrauParentesco").val();
    var PES_Nome_Secundario = $("#selMembroSecundario :selected").text(); 
    var FAM_Nome = $("#txtNomeFamiliar").val();    
    if(FAM_GrauParentesco == ""){ 
        $("#hddFocus").val("selGrauParentesco");
        $("#dialog-atencao").html("Por favor, informe o relacionamento.");
        $("#dialog-atencao").dialog("open");
        return;
    }    
    //pega o tipo do familiar
    var tipoFamiliar = $('input[name=tipoFamiliar]:checked').val();
    if(tipoFamiliar == "membro"){
        if(PES_Secundario_ID == ""){     
            $("#hddFocus").val("selMembroSecundario");
            $("#dialog-atencao").html("Por favor, informe o membro familiar.");
            $("#dialog-atencao").dialog("open");
            return;
        }
        if(!validarRelacionamentoFamiliar(PES_Secundario_ID, FAM_GrauParentesco)){        
            return;
        }
    }else{
        if(FAM_Nome == ""){        
            $("#hddFocus").val("txtNomeFamiliar");
            $("#dialog-atencao").html("Por favor, informe o nome do familiar.");
            $("#dialog-atencao").dialog("open");
            return;
        }else{
            PES_Nome_Secundario = FAM_Nome;
        }
            
    }
    $.post(controlador, {
        ACO_Descricao: "AdicionarFamiliar", 
        PES_Secundario_ID:  PES_Secundario_ID,
        PES_Nome_Secundario: PES_Nome_Secundario,
        FAM_GrauParentesco: FAM_GrauParentesco
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }   
            
            if(data.sucesso == "true"){ 
                listarFamiliar();
                /*if(PES_Secundario_ID > 0){
                    $("#selMembroSecundario").find('[value="'+PES_Secundario_ID+'"]').remove();
                }*/
                $("#selMembroSecundario").val("");
                $("#selMembroSecundario").trigger('chosen:updated');
                
                $("#txtNomeFamiliar").val("");                
                $('#radioMembro').attr("checked", true);
                $("#selGrauParentesco").val("");
                
            }
        },"json"
    );    
}
function listarFamiliar(){    
    $.post(controlador, {
        ACO_Descricao: "ListarFamiliar"
    },
        function(data){                     
            var html = '';

            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="300px">Nome</td>';
                        html += '<td width="150px">Relacionamento</td>';                                
                        html += '<td align="center" width="40px">Excluir</td>'; 
                    html += '</tr>';

                var classDif = '';    

                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';

                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    
                    if(data.rows[i].PES_Secundario_ID){
                        //remove o membro primario do select
                        $("#selMembroSecundario").find('[value="'+data.rows[i].PES_Secundario_ID+'"]').remove();
                        $("#selMembroSecundario").val("");
                        $("#selMembroSecundario").trigger('chosen:updated');
                    }
                    
                    html += '<tr ' + classDif +'>';                    
                        if(data.rows[i].PES_Nome_Secundario){
                            html += '<td>' + data.rows[i].PES_Nome_Secundario + '</td>';
                        }else{
                            html += '<td>' + data.rows[i].FAM_Nome + '</td>';
                        }                        
                        html += '<td>' + data.rows[i].FAM_GrauParentesco + '</td>';
                        
                        html += '<td align="center">';                                    
                            html += "<a href='javascript:void(0);' title='Remover: " + data.rows[i].PES_Nome_Secundario + "'><img onclick='removerFamiliar(" + data.rows[i].ID + ", \"" + data.rows[i].PES_Nome_Secundario + "\", " + data.rows[i].PES_Secundario_ID + ");' class='btnExcluirFamiliar' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>";
                        html += '</td>';
                        
                        
                    html += '</tr>';
                }                        
                html += '</table>';

            }else{
                html = '<p>';
                    html += 'Nenhum familiar adicionado.';
                html += '<p>';
            }

            $("#div-grid-familia").html(html);
        }, "json"
    );
}

function limparFamiliar(){
    $.post(controlador, {
        ACO_Descricao: "LimparFamiliar"
    },
        function(data){                     
            var html = '';
            if(data.sucesso == "true"){           
                //carregarMembrosFamiliar();
                html = '<p>';
                    html += 'Nenhum familiar adicionado.';
                html += '<p>';                    
                $("#div-grid-familia").html(html);
            }else{
                if(data.excecao == "true"){
                    var dialog = "dialog-excecao";                    
                    $("#" + dialog).html(data.mensagem);
                    $("#" + dialog).dialog("open");
                }
            }
        }, "json"
    );    
}

function removerFamiliar(ID, nomeSecundario, idSecundario){    
    $.post(controlador, {
        ACO_Descricao: "ExcluirFamiliar", 
        ID: ID
    },
        function(data) { 
            if(data.sucesso == "true"){                
                listarFamiliar();
                var txt = '<option value="'+idSecundario+'" >'+nomeSecundario+'</option>';                                
                $('#selMembroSecundario').append(txt);
                $("#selMembroSecundario").val("");
                $("#selMembroSecundario").trigger('chosen:updated');
                $("#selGrauParentesco").val("");                
            }
        },"json"
    );
}








function exibirDadoEclesiasticoEdicao(){
   var tipo = $("#selTipoDadoEclesiasticoEditar").val(); 
   $(".fildDadoEcleEdicao").hide();
   switch (tipo) {
    case "ACLAMAÇÃO":
        $("#fildAclamacaoEdicao").show(); 
        break;
    case "BATISMO":
        $("#fildBatismoEdicao").show(); 
        break;
    case "RECONCILIAÇÃO":
        $("#fildReconciliacaoEdicao").show(); 
        break;
    case "TRANSFERÊNCIA":
        $("#fildTransferenciaEdicao").show(); 
        break;
    
    default:
        $(".fildDadoEcleEdicao").hide();
        break;
    }  
}
function exibirDadoEclesiastico(){
   var tipo = $("#selTipoDadoEclesiastico").val(); 
   $(".fildDadoEcle").hide();
   switch (tipo) {
    case "ACLAMAÇÃO":
        $("#fildAclamacao").show(); 
        break;
    case "BATISMO":
        $("#fildBatismo").show(); 
        break;
    case "RECONCILIAÇÃO":
        $("#fildReconciliacao").show(); 
        break;
    case "TRANSFERÊNCIA":
        $("#fildTransferencia").show(); 
        break;
    
    default:
        $(".fildDadoEcle").hide();
        break;
    }  
}

function addDadosEclesiasticos(){    
    var DAM_Tipo = $("#selTipoDadoEclesiastico").val();
    var DAM_Data = " ";
    var DAM_DataAceito = " "; 
    var DAM_IgrejaNome = " "; 
    var DAM_IgrejaCidade = " "; 
    var DAM_IgrejaUf = " "; 
    var DAM_IgrejaPastor = " "; 
    var DAM_Ano = " "; 
    var DAM_NumeroAta = " "; 
    
    if($.trim(DAM_Tipo) == ""){        
        $("#selTipoDadoEclesiastico").focus();
        $("#dialog-atencao").html("Por favor, informe o tipo de dado eclesiástico.");
        $("#dialog-atencao").dialog("open");
        return;
    }

    switch (DAM_Tipo) {
     case "ACLAMAÇÃO":
         DAM_Data = $("#txtDataAclamacao").val();
         break;
     case "BATISMO":
         DAM_Data = $("#txtBatismoData").val();
         DAM_DataAceito = $("#txtBatismoDataAceito").val();
         DAM_IgrejaNome = $("#txtBatismoIgrejaNome").val();
         DAM_IgrejaPastor = $("#txtBatismoIgrejaPastor").val();
         DAM_IgrejaCidade = $("#txtBatismoIgrejaCidade").val();
         DAM_IgrejaUf = $("#selBatismoIgrejaEstado").val();
         DAM_Ano = $("#txtBatismoAno").val();
         break;
     case "RECONCILIAÇÃO":
         DAM_Data = $("#txtDataReconciliacao").val(); 
         break;
     case "TRANSFERÊNCIA":
         DAM_Data = $("#txtTransferenciaDataSecao").val();
         DAM_DataAceito = $("#txtTransferenciaDataAceito").val();
         DAM_NumeroAta = $("#txtTransferenciaNumeroAta").val();
         DAM_IgrejaNome = $("#txtTransferenciaIgrejaNome").val();
         DAM_IgrejaPastor = $("#txtTransferenciaIgrejaPastor").val();        
         DAM_IgrejaCidade = $("#txtTransferenciaIgrejaCidade").val();
         DAM_IgrejaUf = $("#selTranseferenciaIgrejaEstado").val(); 
         break;

     }
    
    
     $.post(controlador, {
        ACO_Descricao: "AdicionarEclesiastico", 
        DAM_Tipo: DAM_Tipo,
        DAM_Data: DAM_Data,
        DAM_DataAceito: DAM_DataAceito,
        DAM_IgrejaNome: DAM_IgrejaNome,
        DAM_IgrejaCidade: DAM_IgrejaCidade,
        DAM_IgrejaUf: DAM_IgrejaUf,
        DAM_IgrejaPastor: DAM_IgrejaPastor,
        DAM_Ano: DAM_Ano,
        DAM_NumeroAta: DAM_NumeroAta
     },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            if(data.sucesso == "true"){                 
                listarDadoEclesiastico();                                
                
                $("#txtDataAclamacao").val("");
                $("#txtBatismoData").val("");
                $("#txtBatismoDataAceito").val("");
                $("#txtBatismoIgrejaNome").val("");
                $("#txtBatismoIgrejaPastor").val("");
                $("#txtBatismoIgrejaCidade").val("");
                $("#selBatismoIgrejaEstado").val("");
                $("#txtDataReconciliacao").val("");                 
                $("#txtTransferenciaDataSecao").val("");
                $("#txtTransferenciaDataAceito").val("");
                $("#txtTransferenciaNumeroAta").val("");
                $("#txtTransferenciaIgrejaNome").val("");
                $("#txtTransferenciaIgrejaPastor").val("");
                $("#txtTransferenciaIgrejaCidade").val("");
                $("#selTranseferenciaIgrejaEstado").val("");
                $("#txtBatismoAno").val("");
                
                $("#selTipoDadoEclesiastico").val("");
                exibirDadoEclesiastico();
                
                
            }
        },"json"
    );   
}

function limparDadoEclesiastico(){
    $.post(controlador, {
        ACO_Descricao: "LimparEclesiastico"
    },
        function(data){                     
            var html = '';
            //carregarDadosEclesiasticos();
            if(data.sucesso == "true"){                    
                html = '<p>';
                    html += 'Nenhum dado eclesiástico adicionado.';
                html += '<p>';                    
                $("#div-grid-dados-eclesiasticos").html(html);
            }else{
                if(data.excecao == "true"){
                    var dialog = "dialog-excecao";                    
                    $("#" + dialog).html(data.mensagem);
                    $("#" + dialog).dialog("open");
                }
            }

        }, "json"
    );
}

function listarDadoEclesiastico(){    
    $.post(controlador, {
        ACO_Descricao: "ListarEclesiastico"
    },
        function(data){                     
            var html = '';
            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="200px">Dado Eclesiástico</td>';
                        html += '<td width="80px">Data</td>';                                
                        html += '<td width="80px">Ano</td>';                                
                        html += '<td width="80px">Data Aceito</td>';                                
                        html += '<td width="200px">Igreja</td>';                                
                        html += '<td width="200px">Cidade</td>';                                
                        html += '<td width="50px">Uf</td>';                                
                        html += '<td width="200px">Pastor</td>';                                
                        html += '<td width="100px">Nº Ata</td>';
                        html += '<td align="center" width="60px">Ações</td>';
                    html += '</tr>';
                var classDif = '';  
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    //remove o o dado eclesiastico do select                
                    /*$("#selTipoDadoEclesiastico").find('[value="'+data.rows[i].DAM_Tipo+'"]').remove();
                    $("#selTipoDadoEclesiastico").val("");*/
                    

                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].DAM_Tipo + '</td>';                        
                        if(data.rows[i].DAM_Data){
                            html += '<td>' + data.rows[i].DAM_Data + '</td>';                            
                        }else{
                            html += '<td> </td>';
                        }
                        if(data.rows[i].DAM_Ano){
                            html += '<td>' + data.rows[i].DAM_Ano + '</td>';                            
                        }else{
                            html += '<td> </td>';
                        }
                        if(data.rows[i].DAM_DataAceito){
                            html += '<td>' + data.rows[i].DAM_DataAceito + '</td>';                            
                        }else{
                            html += '<td> </td>';
                        }                        
                        if(data.rows[i].DAM_IgrejaNome){
                            html += '<td>' + data.rows[i].DAM_IgrejaNome + '</td>';
                        }else{
                            html += '<td> </td>';                            
                        }                        
                        if(data.rows[i].DAM_IgrejaCidade){
                            html += '<td>' + data.rows[i].DAM_IgrejaCidade + '</td>';
                        }else{
                            html += '<td> </td>';                            
                        }                        
                        if(data.rows[i].DAM_IgrejaUf){
                            html += '<td>' + data.rows[i].DAM_IgrejaUf + '</td>';
                        }else{
                            html += '<td> </td>';                            
                        }
                        if(data.rows[i].DAM_IgrejaPastor){
                            html += '<td>' + data.rows[i].DAM_IgrejaPastor + '</td>';
                        }else{
                            html += '<td> </td>';
                        }
                        if(data.rows[i].DAM_NumeroAta){
                            html += '<td>' + data.rows[i].DAM_NumeroAta + '</td>';
                        }else{
                            html += '<td> </td>';
                        }
                        html += '<td align="center">';                        
                            html += "<a href='javascript:void(0);' title='Editar: " + data.rows[i].DAM_Tipo + " '><img onclick='editarDadoEclesiastico(" + data.rows[i].ID + " );' class='btnEditarDadoEclesiastico' alt='editar' src='../../../modulos/sistema/home/img/botao-editar.png' border='0' width='11px' height='11px' /></a>&nbsp;&nbsp;&nbsp;";
                            html += "<a href='javascript:void(0);' title='Remover: " + data.rows[i].DAM_Tipo + " '><img onclick='removerDadoEclesiastico(" + data.rows[i].ID + " );' class='btnExcluirDadoEclesiastico' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>";
                        html += '</td>';
                    html += '</tr>';
                }                        
                html += '</table>';
            }else{
                html = '<p>';
                    html += 'Nenhum dado eclesiástico adicionado.';
                html += '<p>';
            }
            $("#div-grid-dados-eclesiasticos").html(html);
        }, "json"
    );
    
}







function editarDadoEclesiastico(idDadoEclesiastico){
    $.post(controlador, {
        ACO_Descricao: "BuscarDadoEclesiastico",
        ID: idDadoEclesiastico
    },
        function(data){                                 
                if(data.sucesso == "true"){
                    
                    $("#hddIDDadoEclesiastico").val(data.rows.ID);
                    
                    $("#selTipoDadoEclesiasticoEditar").val(data.rows.DAM_Tipo);
                    $("#selTipoDadoEclesiasticoEditar").trigger("onchange");
                    
                    switch (data.rows.DAM_Tipo) {
                     case "ACLAMAÇÃO":
                         $("#txtDataAclamacaoEdicao").val(data.rows.DAM_Data);
                         break;
                     case "BATISMO":
                         $("#txtBatismoDataEdicao").val(data.rows.DAM_Data);
                         $("#txtBatismoDataAceitoEdicao").val(data.rows.DAM_DataAceito);
                         $("#txtBatismoIgrejaNomeEdicao").val(data.rows.DAM_IgrejaNome);                         
                         $("#txtBatismoIgrejaPastorEdicao").val(data.rows.DAM_IgrejaPastor);                         
                         $("#txtBatismoIgrejaCidadeEdicao").val(data.rows.DAM_IgrejaCidade);                         
                         $("#selBatismoIgrejaEstadoEdicao").val(data.rows.DAM_IgrejaUf);
                         $("#txtBatismoAnoEdicao").val(data.rows.DAM_Ano);
                         break;
                     case "RECONCILIAÇÃO":
                         $("#txtDataReconciliacaoEdicao").val(data.rows.DAM_Data); 
                         break;
                     case "TRANSFERÊNCIA":
                         $("#txtTransferenciaDataSecaoEdicao").val(data.rows.DAM_Data);
                         $("#txtTransferenciaDataAceitoEdicao").val(data.rows.DAM_DataAceito);
                         $("#txtTransferenciaNumeroAtaEdicao").val(data.rows.DAM_NumeroAta);
                         $("#txtTransferenciaIgrejaNomeEdicao").val(data.rows.DAM_IgrejaNome);
                         $("#txtTransferenciaIgrejaPastorEdicao").val(data.rows.DAM_IgrejaPastor);
                         $("#txtTransferenciaIgrejaCidadeEdicao").val(data.rows.DAM_IgrejaCidade);
                         $("#selTranseferenciaIgrejaEstadoEdicao").val(data.rows.DAM_IgrejaUf); 
                         break;
                     }
                    
                    $("#dialog-editar-dadoEclesiastico").dialog("open");
                    
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}
function executarEditarDadoEclesiastico(){
        
    var DAM_Tipo = $("#selTipoDadoEclesiasticoEditar").val();
    var ID   = $("#hddIDDadoEclesiastico").val();  
    
    
    var DAM_Data = "";
    var DAM_DataAceito = ""; 
    var DAM_IgrejaNome = ""; 
    var DAM_IgrejaCidade = ""; 
    var DAM_IgrejaUf = ""; 
    var DAM_IgrejaPastor = ""; 
    var DAM_Ano = ""; 
    var DAM_NumeroAta = ""; 
    
    if($.trim(DAM_Tipo) == ""){        
        $("#selTipoDadoEclesiasticoEditar").focus();
        $("#dialog-atencao").html("Por favor, informe o tipo de dado eclesiástico.");
        $("#dialog-atencao").dialog("open");
        return;
    }

    switch (DAM_Tipo) {
     case "ACLAMAÇÃO":
         DAM_Data = $("#txtDataAclamacao").val();
         break;
     case "BATISMO":
         DAM_Data = $("#txtBatismoDataEdicao").val();
         DAM_DataAceito = $("#txtBatismoDataAceitoEdicao").val();
         DAM_IgrejaNome = $("#txtBatismoIgrejaNomeEdicao").val();
         DAM_IgrejaPastor = $("#txtBatismoIgrejaPastorEdicao").val();
         DAM_IgrejaCidade = $("#txtBatismoIgrejaCidadeEdicao").val();
         DAM_IgrejaUf = $("#selBatismoIgrejaEstadoEdicao").val();
         DAM_Ano = $("#txtBatismoAnoEdicao").val();
         break;
     case "RECONCILIAÇÃO":
         DAM_Data = $("#txtDataReconciliacaoEdicao").val(); 
         break;
     case "TRANSFERÊNCIA":
         DAM_Data = $("#txtTransferenciaDataSecaoEdicao").val();
         DAM_DataAceito = $("#txtTransferenciaDataAceitoEdicao").val();
         DAM_NumeroAta = $("#txtTransferenciaNumeroAtaEdicao").val();
         DAM_IgrejaNome = $("#txtTransferenciaIgrejaNomeEdicao").val();
         DAM_IgrejaPastor = $("#txtTransferenciaIgrejaPastorEdicao").val();        
         DAM_IgrejaCidade = $("#txtTransferenciaIgrejaCidadeEdicao").val();
         DAM_IgrejaUf = $("#selTranseferenciaIgrejaEstadoEdicao").val(); 
         break;

     }
    
    
     $.post(controlador, {         
        ACO_Descricao: "SalvarEditarDadoEclesiastico", 
        ID: ID,
        DAM_Tipo: DAM_Tipo,
        DAM_Data: DAM_Data,
        DAM_DataAceito: DAM_DataAceito,
        DAM_IgrejaNome: DAM_IgrejaNome,
        DAM_IgrejaCidade: DAM_IgrejaCidade,
        DAM_IgrejaUf: DAM_IgrejaUf,
        DAM_IgrejaPastor: DAM_IgrejaPastor,
        DAM_Ano: DAM_Ano,
        DAM_NumeroAta: DAM_NumeroAta
     },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            if(data.sucesso == "true"){                 
                
                
                $("#txtDataAclamacaoEdicao").val("");
                $("#txtBatismoDataEdicao").val("");
                $("#txtBatismoDataAceitoEdicao").val("");
                $("#txtBatismoIgrejaNomeEdicao").val("");
                $("#txtBatismoIgrejaPastorEdicao").val("");
                $("#txtBatismoIgrejaCidadeEdicao").val("");
                $("#selBatismoIgrejaEstadoEdicao").val("");
                $("#txtDataReconciliacaoEdicao").val("");                 
                $("#txtTransferenciaDataSecaoEdicao").val("");
                $("#txtTransferenciaDataAceitoEdicao").val("");
                $("#txtTransferenciaNumeroAtaEdicao").val("");
                $("#txtTransferenciaIgrejaNomeEdicao").val("");
                $("#txtTransferenciaIgrejaPastorEdicao").val("");
                $("#txtTransferenciaIgrejaCidadeEdicao").val("");
                $("#selTranseferenciaIgrejaEstadoEdicao").val("");
                $("#txtBatismoAnoEdicao").val("");                
                $("#selTipoDadoEclesiasticoEditar").val("");
                
                
                $("#dialog-editar-dadoEclesiastico").dialog("close");
                listarDadoEclesiastico();                                
                
                
            }
        },"json"
    );    
}

function removerDadoEclesiastico(ID){    
    $.post(controlador, {
        ACO_Descricao: "ExcluirEclesiastico", 
        ID: ID
    },
        function(data) {    
            
            if(data.sucesso == "true"){                
                listarDadoEclesiastico();
                //remove o o dado eclesiastico do select
                /*var txt = '<option value="'+nomeEclesiastico+'" >'+nomeEclesiastico+'</option>';                                
                $('#selTipoDadoEclesiastico').append(txt);
                $("#selTipoDadoEclesiastico").val("");*/                            
            }
        },"json"
    );
}













function adicionarFone(){
    var TEL_Operadora   = $("#selOperadora").val();    
    var TEL_Numero      = $("#txtFone").val();
    var TEL_NomeContato = $("#txtResponsavel").val();    
    
    if($.trim(TEL_Numero) == ""){        
        $("#hddFocus").val("txtFone");
        $("#dialog-atencao").html("Por favor, informe o telefone do contato.");
        $("#dialog-atencao").dialog("open");
        return;
    }     
    if($.trim(TEL_Operadora) == ""){
        $("#hddFocus").val("selOperadora");
        $("#dialog-atencao").html("Por favor, informe a operadora do contato.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    preLoadingOpen("Adicionando telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "AdicionarFone", 
        TEL_Operadora:  TEL_Operadora,
        TEL_Numero: TEL_Numero,
        TEL_NomeContato: TEL_NomeContato
        
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            } 
            
            if(data.sucesso == "true"){                 
                listarFone(); 
                // limpa campos
                $("#selOperadora").val("");
                $("#txtFone").val("");                
                $("#txtResponsavel").val("");                
                $("#selOperadora").focus();
            }
            preLoadingClose();
        },"json"
    );
}

function listarFone(){
    $.post(controlador, {
            ACO_Descricao: "ListarFone"
        },
        function(data){
            console.log(data);
            var html = '';
            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="97%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="22%">Telefone</td>';
                        html += '<td width="18%">Operadora</td>';                                                
                        html += '<td width="45%">Contato</td>';                        
                        html += '<td align="center" width="15%">Ações</td>'; 
                    html += '</tr>';
                var classDif = '';  
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].TEL_Numero + '</td>';                        
                        html += '<td>' + data.rows[i].TEL_Operadora + '</td>';                        
                        html += '<td>' + data.rows[i].TEL_NomeContato + '</td>';                        
                        html += '<td align="center">';                                    
                            html += "<a href='javascript:void(0);' title='Editar'><img onclick='editarFone(" + data.rows[i].ID + ");' class='btnEditarFone' alt='editar' src='../../../modulos/sistema/home/img/botao-editar.png' border='0' width='11px' height='11px' /></a> &nbsp;&nbsp;&nbsp; ";
                            html += "<a href='javascript:void(0);' title='Remover'><img onclick='removerFone(" + data.rows[i].ID + ");' class='btnExcluirFone' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>  ";                            
                        html += '</td>';
                    html += '</tr>';
                }                        
                html += '</table>';
            }else{
                html += 'Nenhum telefone adicionado.';                
            }
            $("#div-fones").html(html);

        }, "json"
    );
    
}

function editarFone(idFone){
    $.post(controlador, {
        ACO_Descricao: "BuscarFone",
        ID: idFone
    },
        function(data){                                 
                if(data.sucesso == "true"){                    
                    $("#hddIDFone").val(data.rows.ID);
                    $("#txtFoneEdicao").val(data.rows.TEL_Numero);
                    $("#selOperadoraEdicao").val(data.rows.TEL_Operadora);
                    $("#txtResponsavelEdicao").val(data.rows.TEL_NomeContato);                    
                    $("#dialog-editar-fone").dialog("open");
                    
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}
function executarEditarFone(){
    var ID   = $("#hddIDFone").val();    
    var TEL_Operadora   = $("#selOperadoraEdicao").val();    
    var TEL_Numero      = $("#txtFoneEdicao").val();
    var TEL_NomeContato = $("#txtResponsavelEdicao").val();    
    
    if($.trim(TEL_Numero) == ""){        
        $("#hddFocus").val("txtFoneEdicao");
        $("#dialog-atencao").html("Por favor, informe o telefone do contato.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if($.trim(TEL_Operadora) == ""){
        $("#hddFocus").val("selOperadoraEdicao");
        $("#dialog-atencao").html("Por favor, informe a operadora do contato.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    preLoadingOpen("Adicionando telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "SalvarEditarFone", 
        TEL_Operadora:  TEL_Operadora,
        TEL_Numero: TEL_Numero,
        TEL_NomeContato: TEL_NomeContato,
        ID: ID
        
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            if(data.sucesso == "true"){                
                // limpa campos
                $("#selOperadoraEdicao").val("");
                $("#txtFoneEdicao").val("");                
                $("#txtResponsavelEdicao").val("");                
                $("#selOperadoraEdicao").focus();
                $("#dialog-editar-fone").dialog("close");
                listarFone();
            }
            preLoadingClose();
        },"json"
    );
}

function limparFone(){
    $.post(controlador, {
        ACO_Descricao: "LimparFone"
    },
        function(data){                     
            var html = '';
                if(data.sucesso == "true"){
                    $("#selOperadora").val("");
                    $("#txtFone").val(""); 
                    $("#txtResponsavel").val(""); 
                    html = '<b>';
                        html += 'Nenhum telefone adicionado.';
                    html += '</b>';                    
                    $("#div-fones").html(html);
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}
    
function removerFone(ID){ 
    preLoadingOpen("Removendo telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "ExcluirFone", 
        ID: ID
    },
        function(data){            
            if(data.sucesso == "true"){                
                listarFone();                
            }   
            
            preLoadingClose();
        },"json"
    );
}
























function adicionarEmail(){    
    var EMA_Email  = $("#txtEmail").val();
    
    if($.trim(EMA_Email) == ""){        
        $("#txtEmail").focus();
        $("#dialog-atencao").html("Por favor, informe o e-mail.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(!isEmail($('#txtEmail').val())){
        $("#txtEmail").focus();
        $("#dialog-atencao").html("Por favor, informe um e-mail válido.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    $.post(controlador, {
        ACO_Descricao: "AdicionarEmail", 
        EMA_Email:  EMA_Email        
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }               
            if(data.sucesso == "true"){                 
                listarEmail();                
                $("#txtEmail").val("");                
                $("#txtEmail").focus();
            }
        },"json"
    );
}

function listarEmail(){    
    $.post(controlador, {
            ACO_Descricao: "ListarEmails"
        },
        function(data){                     
            var html = '';
            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="85%">E-mail</td>';                        
                        html += '<td align="center" width="15%">Ações</td>'; 
                    html += '</tr>';
                var classDif = '';  
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].EMA_Email + '</td>';                        
                        html += '<td align="center">';                               
                            html += "<a href='javascript:void(0);' title='Editar'><img onclick='editarEmail(" + data.rows[i].ID + ");' class='btnEditarEmail' alt='editar' src='../../../modulos/sistema/home/img/botao-editar.png' border='0' width='11px' height='11px' /></a> &nbsp;&nbsp;&nbsp; ";
                            html += "<a href='javascript:void(0);' title='Remover'><img onclick='removerEmail(" + data.rows[i].ID + ");' class='btnExcluirEmail' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>  ";                                                    
                        html += '</td>';
                    html += '</tr>';
                }                        
                html += '</table>';

            }else{
                
                    html += 'Nenhum e-mail adicionado.';
            }
            $("#div-emails").html(html);

        }, "json"
    );    
}


function editarEmail(idEmail){
    $.post(controlador, {
        ACO_Descricao: "BuscarEmail",
        ID: idEmail
    },
        function(data){                                 
                if(data.sucesso == "true"){                    
                    $("#hddIDEmail").val(data.rows.ID);
                    $("#txtEmailEdicao").val(data.rows.EMA_Email);                    
                    $("#dialog-editar-email").dialog("open");
                    
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}
function executarEditarEmail(){
    var ID   = $("#hddIDEmail").val();           
    var EMA_Email      = $("#txtEmailEdicao").val();
    
    
    if($.trim(EMA_Email) == ""){        
        $("#txtEmailEdicao").focus();
        $("#dialog-atencao").html("Por favor, informe o e-mail.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(!isEmail(EMA_Email)){
        $("#txtEmailEdicao").focus();
        $("#dialog-atencao").html("Por favor, informe um e-mail válido.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    preLoadingOpen("Adicionando telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "SalvarEditarEmail", 
        EMA_Email:  EMA_Email,        
        ID: ID
        
    },
        function(data) {            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            if(data.sucesso == "true"){                
                // limpa campos
                $("#hddIDEmail").val("");
                $("#txtEmailEdicao").val("");              
                
                $("#dialog-editar-email").dialog("close");
                listarEmail();
            }
            preLoadingClose();
        },"json"
    );
}

function limparEmail(){
    $.post(controlador, {
        ACO_Descricao: "LimparEmail"
    },
        function(data){                     
            var html = '';
                if(data.sucesso == "true"){
                    $("#txtEmail").val("");                    
                    html = '<b>';
                        html += 'Nenhum e-mail adicionado.';
                    html += '</b>';                    
                    $("#div-emails").html(html);
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );    
}
    
function removerEmail(ID){    
    $.post(controlador, {
        ACO_Descricao: "ExcluirEmail", 
        ID: ID
    },
        function(data){            
            if(data.sucesso == "true"){                
                listarEmail();                
            }            
        },"json"
    );
}

function addProcessoDesligamento(){    
    var PCD_Data      = $("#txtDataDesligamento").val();    
    var PCD_Descricao = $("#txtDescricaoProcedimento").val();    
       
    if($.trim(PCD_Data) == ""){
        $("#hddFocus").val("txtDataDesligamento");
        $("#dialog-atencao").html("Por favor, informe a data do procedimento.");
        $("#dialog-atencao").dialog("open");
        return;   
    }
    
    if(!isDataValida(PCD_Data)){
        $("#hddFocus").val("txtDataDesligamento");
        $("#dialog-atencao").html("Por favor, informe uma data de procedimento válida.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    if(PCD_Descricao == ""){
        $("#hddFocus").val("txtDescricaoProcedimento");
        $("#dialog-atencao").html("Por favor, informe as descrição do procedimento.");
        $("#dialog-atencao").dialog("open");
        return;
    }
        
    preLoadingOpen("Adicionando o procedimento, aguarde...");    
        
    $.post(controlador, {
        ACO_Descricao: "AdicionarProcessoDesligamento", 
        PCD_Data:  PCD_Data,        
        PCD_Descricao:  PCD_Descricao      
    },
        function(data) {
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }               
            if(data.sucesso == "true"){                 
                listarProcessoDesligamento();
                $("#txtDataDesligamento").val("");                
                $("#txtDescricaoProcedimento").val("");
            }
            
            preLoadingClose();
        },"json"
    );
}

function listarProcessoDesligamento(){    
    $.post(controlador, {
            ACO_Descricao: "ListarProcessoDesligamento"        
        },
        function(data){                     
            var html = '';
            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="10%">Data</td>';                        
                        html += '<td width="80%">Descrição</td>';
                        html += '<td align="center" width="10%">Excluir</td>'; 
                    html += '</tr>';
                var classDif = '';
                
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].PCD_Data + '</td>';                        
                        html += '<td>' + data.rows[i].PCD_Descricao + '</td>';
                        html += '<td align="center">';                                    
                            html += "<a href='javascript:void(0);' title='Remover'><img onclick='removerProcessoDesligamento(" + data.rows[i].ID + ", " + data.rows[i].MOD_ID + ", \"" + data.rows[i].MOD_Descricao + "\"    );' class='btnExcluirDadoDesligamento' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>";
                        html += '</td>';
                    html += '</tr>';
                }                        
                html += '</table>';

            }else{
                html = '<p>';
                    html += 'Nenhum procedimento adicionado.';
                html += '</p>';
            }
            $("#div-grid-processo-desligamento").html(html);

        }, "json"
    );    
}

function limparProcessoDesligamento(){
    $.post(controlador, {
        ACO_Descricao: "LimparProcessoDesligamento"
    },
        function(data){                     
            var html = '';
                if(data.sucesso == "true"){
                    $("#txtDataDesligamento").val("");                
                    $("#txtDescricaoProcedimento").val("");                
                    //carregarDadosMotivoDesligamento();                  
                    $("#txtDataDesligamento").focus();                    
                    html = '<p>';
                        html += 'Nenhum procedimento adicionado.';
                    html += '</p>';                    
                    $("#div-grid-processo-desligamento").html(html);
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );    
}
    
function removerProcessoDesligamento(ID, idMotivo, descricaoMotivo){    
    $.post(controlador, {
        ACO_Descricao: "ExcluirProcessoDesligamento", 
        ID: ID
    },
        function(data){            
            if(data.sucesso == "true"){                
                listarProcessoDesligamento();
            }            
        },"json"
    );
}

function imprimirCertifiadoBatismo(id){    
    var url = "../../administrativo/cadastro/documentos/CertificadoBatismo.php?PES_ID=" + id;
    novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
}

function imprimirCarteira(id){    
    var url = "../../administrativo/cadastro/documentos/CarteiraMembro.php?PES_ID=" + id;
    novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
}

// gerenciamento de campos
function gerenciarEstadoCivil(){
    var estadoCivilID = $("#selEstadoCivil").val();
    
    if($.trim(estadoCivilID) != ""){
        $.ajax({
            type: "POST",
            url: controladorEstadoCivil,
            dataType: "json",
            async: false,
            data: {ACO_Descricao: "Consultar", ECV_ID: estadoCivilID}
        })
        .done(function( data ) {        
            if(data.sucesso == "true"){                
                if(data.rows[0].ECV_ExigeConjuge == "S"){
                    $("#fieldsetDataCasamento").show();
                }else{
                    $("#fieldsetDataCasamento").hide();
                }
            }else{
                $("#fieldsetDataCasamento").hide();
            }
        });
    }else{        
        $("#fieldsetDataCasamento").hide();
    }
}

function gerenciarDataFalecimento(mudancaTipo){
    if ($("#ckbFalecimento").prop("checked")){  
        $("#divDataFalecimento").show();
        
        // altera o tipo para INATIVO
        $("#selTipo").val("INATIVO");
        $("#selTipo").trigger('chosen:updated');
        
        $("#selStatus").val("2"); // INATIVO
        $("#selStatus").trigger('chosen:updated');
        
        // garante que os campos retornarão para o valor inicial "VAZIO"
        /*$("#txtDataInativacao").val("");
        $("#selMotivoInativacao").val("TRANSFERENCIA");
        $("#selMotivoInativacao").trigger('chosen:updated');
        $("#txtDescricaoInativacao").val("");
        $("#txtDataDescricaoInativacao").val("");*/
    }else{
        $("#txtDataFalecimento").val("");
        $("#divDataFalecimento").hide();  
                
        $("#selStatus").val("1"); // ATIVO
        $("#selStatus").trigger('chosen:updated');
        
        if(!mudancaTipo){
            // altera o tipo para INATIVO
            $("#selTipo").val("MEMBRO");
            $("#selTipo").trigger('chosen:updated');
        }
    }
}

// CARREGAMENTO DE TABELAS AUXILIARES
function carregarTabelasAuxiliares(pessoaID){
    // e-mails
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionEmails", PES_ID: pessoaID}
    })
    .done(function( data ) {        
        if(data.sucesso == "true"){                    
            listarEmail();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
    // telefones
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionFone", PES_ID: pessoaID}
    })
    .done(function( data ) {        
        if(data.sucesso == "true"){                    
            listarFone();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
    // família
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionFamiliar", PES_ID: pessoaID}
    })
    .done(function( data ) { 
        if(data.sucesso == "true"){                    
            listarFamiliar();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
    // dados eclesiásticos
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionEclesiastico", PES_ID: pessoaID}
    })
    .done(function( data ) { 
        if(data.sucesso == "true"){                    
            listarDadoEclesiastico();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
    // atividades
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionAtividade", PES_ID: pessoaID}
    })
    .done(function( data ) { 
        if(data.sucesso == "true"){                    
            listarAtividade();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
    // processos de desligamento
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionProcessoDesligamento", PES_ID: pessoaID}
    })
    .done(function( data ) { 
        if(data.sucesso == "true"){                    
            listarProcessoDesligamento();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
    // atividades
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionMinisterio", PES_ID: pessoaID}
    })
    .done(function( data ) { 
        if(data.sucesso == "true"){                    
            listarMinisterio();
        }else{
            if(data.excecao == "true"){
                var dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
        }
    });
    
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



function listarContatos(idMembro){    
    var dadosFone = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
        dadosFone += '<tr class="cabecalhoTabela">';
            dadosFone += '<td width="100%">Telefones</td>';                            
        dadosFone += '</tr>';        
        dadosFone += '<tr>';
            dadosFone += '<td width="100%">Nenhum telefone cadastrado</td>';                            
        dadosFone += '</tr>';
    dadosFone += '</table>';
    
    var dadosEmail = '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
        dadosEmail += '<tr class="cabecalhoTabela">';
            dadosEmail += '<td width="100%">E-mails</td>';                            
        dadosEmail += '</tr>';        
        dadosEmail += '<tr>';
            dadosEmail += '<td width="100%">Nenhum e-mail cadastrado</td>';                            
        dadosEmail += '</tr>';
    dadosEmail += '</table>';    
    var dadosImpressao = "";
    preLoadingOpen("Consultando, aguarde...");
    
    if(preencherSessionFone(idMembro)){
        var htmlFone = criarTabelaFone();
        if(htmlFone != null){
            dadosFone = htmlFone;
        }
    }
    
    if(preencherSessionEmail(idMembro)){ 
        var hmtmlEmail = criarTabelaEmail();
        if(hmtmlEmail != null){
            dadosEmail = hmtmlEmail;
        }
    }
    dadosImpressao = dadosFone;
    dadosImpressao+= "<br>";    
    dadosImpressao+= dadosEmail;    
    $("#div-lista-contato").html(dadosImpressao);
    $("#dialog-contato").dialog("open");
    preLoadingClose();    
}

function criarTabelaEmail(){
    var htmlEmail = "";
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "ListarEmails"}
    })
    .done(function( data ) {         
        if(data.sucesso == "true"){
            htmlEmail += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                htmlEmail += '<tr class="cabecalhoTabela">';
                    htmlEmail += '<td width="100%">E-mail</td>';                            
                htmlEmail += '</tr>';
            var classDif = '';  
            for(var i=0; i<data.rows.length; i++){
                classDif = 'class="linhaNormal"';
                if(i%2 == 0){
                    classDif = 'class="linhaCor"';
                }
                htmlEmail += '<tr ' + classDif +'>';
                    htmlEmail += '<td>' + data.rows[i].EMA_Email + '</td>';                            
                htmlEmail += '</tr>';
            }                        
            htmlEmail += '</table>';
        }else{
            return null;
        }
    });
    return htmlEmail;
}

function criarTabelaFone(){
    var htmlFone = "";
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "ListarFone"}
    })
    .done(function( data ) {        
        if(data.sucesso == "true"){
            htmlFone += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                htmlFone += '<tr class="cabecalhoTabela">';
                    htmlFone += '<td width="25%">Telefone</td>';
                    htmlFone += '<td width="25%">Operadora</td>';                                                
                    htmlFone += '<td width="50%">Contato</td>';                                
                htmlFone += '</tr>';
            var classDif = '';  
            for(var i=0; i<data.rows.length; i++){
                classDif = 'class="linhaNormal"';
                if(i%2 == 0){
                    classDif = 'class="linhaCor"';
                }
                htmlFone += '<tr ' + classDif +'>';
                    htmlFone += '<td>' + data.rows[i].TEL_Numero + '</td>';                        
                    htmlFone += '<td>' + data.rows[i].TEL_Operadora + '</td>';                        
                    htmlFone += '<td>' + data.rows[i].TEL_NomeContato + '</td>';
                htmlFone += '</tr>';
            }                        
            htmlFone += '</table>';
        }else{
            return null;
        }
    });
    return htmlFone;
}

function preencherSessionEmail(idMembro){
    var retorno = false;    
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionEmails", PES_ID: idMembro}
    })
    .done(function( data ) { 
        if(data.sucesso == "true"){
            retorno = true;
        }else{
            retorno = false;
        }
    });
    return retorno;
}
function preencherSessionFone(idMembro){
    var retorno = false;    
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionFone", PES_ID: idMembro}
    })
    .done(function( data ) {        
        if(data.sucesso == "true"){
            retorno = true;
        }else{
            retorno = false;
        }
    });
    return retorno;
}

function printFichaEmBranco(){
    var url = "../../administrativo/cadastro/documentos/FichaMembroEmBranco.php";
    novaJanelaFullscreen(url, '_blank', 'fullscreen=yes');
}








// status
function getStatus(){
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/StatusMembroControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", MES_Status: "A"}
    })
    .done(function( data ) {
        $("#selStatus").html("<option value=''></option>");
        
        if(data.sucesso == "true"){
            var html = '';
            var selected = '';
            for(var i=0; i<data.rows.length; i++){                
                if(data.rows[i].MES_ID == 1){
                    selected = "selected = 'true'";
                }else{
                    selected = "";
                }
                html += '<option '+selected+' value="' + data.rows[i].MES_ID + '">' + data.rows[i].MES_Descricao + '</option>';
            }
            
            $("#selStatus").append(html);
            $("#selStatus").trigger('chosen:updated');
        }
    });
}
function openADDStatus(){
    $("#dialog-add-status").dialog("open");
    $('#txtADDStatus').val("");
}
function salvarADDStatus(){    
    if($.trim($('#txtADDStatus').val()) == ""){
        $("#hddFocus").val("txtADDStatus");
        $("#dialog-atencao").html("Por favor, informe o status.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // bind form using ajaxForm 
    $('#frmStatus').ajaxForm({
        dataType:  'json', // Comentar essa linha para debugar
        success: function(data){
            preLoadingClose();

            if(data.excecao == "true"){
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
            }else{
                getStatus();
                $('#txtADDStatus').val("");
                $("#dialog-add-status").dialog("close");
            } 
        } 
    }).submit();
}



// estado civil
function getEstadoCivil(){
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/EstadoCivilControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", ECV_Status: "A"}
    })
    .done(function( data ) {
        $("#selEstadoCivil").html("<option value=''></option>");        
        if(data.sucesso == "true"){
            var html = '';            
            for(var i=0; i<data.rows.length; i++){                
                
                html += '<option value="' + data.rows[i].ECV_ID + '">' + data.rows[i].ECV_Descricao + '</option>';
            }
            
            $("#selEstadoCivil").append(html);
            $("#selEstadoCivil").trigger('chosen:updated');
        }
    });
}
function openADDEstadoCivil(){
    $("#dialog-add-estadoCivil").dialog("open");
    $('#txtADDEstadoCivil').val("");
}
function salvarADDEstadoCivil(){
    if($.trim($('#txtADDEstadoCivil').val()) == ""){
        $("#hddFocus").val("txtADDStatus");
        $("#dialog-atencao").html("Por favor, informe o estado civil.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // bind form using ajaxForm 
    $('#frmEstadoCivil').ajaxForm({
        dataType:  'json', // Comentar essa linha para debugar
        success: function(data){
            preLoadingClose();

            if(data.excecao == "true"){
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
            }else{
                getEstadoCivil();
                $('#txtADDEstadoCivil').val("");
                $("#dialog-add-estadoCivil").dialog("close");
            } 
        } 
    }).submit();
}


// area atuacao
function getAreaAtuacao(){
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/AreaAtuacaoControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", AAT_Status: "A"}
    })
    .done(function( data ) {
        $("#selAreaAtuacao").html("<option value=''></option>");        
        if(data.sucesso == "true"){
            var html = '';            
            for(var i=0; i<data.rows.length; i++){                
                
                html += '<option value="' + data.rows[i].AAT_ID + '">' + data.rows[i].AAT_Descricao + '</option>';
            }
            
            $("#selAreaAtuacao").append(html);
            $("#selAreaAtuacao").trigger('chosen:updated');
        }
    });
}

function openADDAreaAtuacao(){
    $("#dialog-add-areaAtuacao").dialog("open");
    $('#txtADDAreaAtuacao').val("");
}

function salvarADDAreaAtuacao(){    
    if($.trim($('#txtADDAreaAtuacao').val()) == ""){
        $("#hddFocus").val("txtADDAreaAtuacao");
        $("#dialog-atencao").html("Por favor, informe a área de atução.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // bind form using ajaxForm 
    $('#frmAreaAtuacao').ajaxForm({
        dataType:  'json', // Comentar essa linha para debugar
        success: function(data){
            preLoadingClose();

            if(data.excecao == "true"){
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
            }else{
                getAreaAtuacao();
                $('#txtADDAreaAtuacao').val("");
                $("#dialog-add-areaAtuacao").dialog("close");
            } 
        } 
    }).submit();
}



// faixa salarial
function getFaixaSalarial(){
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/RendaSalarioControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", ARS_Status: "A"}
    })
    .done(function( data ) {
        $("#selFaixaSalarial").html("<option value=''></option>");        
        if(data.sucesso == "true"){
            var html = '';            
            for(var i=0; i<data.rows.length; i++){                
                
                html += '<option value="' + data.rows[i].ARS_ID + '">' + data.rows[i].ARS_Descricao + '</option>';
            }
            
            $("#selFaixaSalarial").append(html);
            $("#selFaixaSalarial").trigger('chosen:updated');
        }
    });
}

function openADDFaixaSalarial(){
    $("#dialog-add-faixaSalarial").dialog("open");
    $('#txtADDFaixaSalarial').val("");
}

function salvarADDFaixaSalarial(){    
    if($.trim($('#txtADDFaixaSalarial').val()) == ""){
        $("#hddFocus").val("txtADDFaixaSalarial");
        $("#dialog-atencao").html("Por favor, informe a faixa salarial.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // bind form using ajaxForm 
    $('#frmFaixaSalarial').ajaxForm({
        dataType:  'json', // Comentar essa linha para debugar
        success: function(data){
            preLoadingClose();

            if(data.excecao == "true"){
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
            }else{
                getFaixaSalarial();
                $('#txtADDFaixaSalarial').val("");
                $("#dialog-add-faixaSalarial").dialog("close");
            } 
        } 
    }).submit();
}


// atividade
function getAtividade(){
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/AtividadeControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", ATV_Status: "A"}
    })
    .done(function( data ) {
        $("#selAtividade").html("<option value=''></option>");        
        if(data.sucesso == "true"){
            var html = '';            
            for(var i=0; i<data.rows.length; i++){                
                
                html += '<option value="' + data.rows[i].ATV_ID + '">' + data.rows[i].ATV_Descricao + '</option>';
            }
            
            $("#selAtividade").append(html);
            $("#selAtividade").trigger('chosen:updated');
        }
    });
}

function openADDAtividade(){
    $("#dialog-add-atividade").dialog("open");
    $('#txtADDAtividade').val("");
}

function salvarADDAtividade(){    
    if($.trim($('#txtADDAtividade').val()) == ""){
        $("#hddFocus").val("txtADDAtividade");
        $("#dialog-atencao").html("Por favor, informe a atividade.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // bind form using ajaxForm 
    $('#frmAtividade').ajaxForm({
        dataType:  'json', // Comentar essa linha para debugar
        success: function(data){
            preLoadingClose();

            if(data.excecao == "true"){
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
            }else{
                getAtividade();
                $('#txtADDAtividade').val("");
                $("#dialog-add-atividade").dialog("close");
            } 
        } 
    }).submit();
}

// nivel escolaridade
function getNivelEscolaridade(){
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/NivelEscolaridadeControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", NES_Status: "A"}
    })
    .done(function( data ) {
        $("#selNivelEscolaridade").html("<option value=''></option>");        
        if(data.sucesso == "true"){
            var html = '';            
            for(var i=0; i<data.rows.length; i++){                
                
                html += '<option value="' + data.rows[i].NES_ID + '">' + data.rows[i].NES_Descricao + '</option>';
            }
            $("#selNivelEscolaridade").html(html);
            $("#selNivelEscolaridade").trigger('chosen:updated');
        }
    });
}

function openADDEscolaridade(){
    $("#dialog-add-nivelEscolaridade").dialog("open");
    $('#txtADDNivelEscolaridade').val("");
}

function salvarADDNivelEscolaridade(){    
    if($.trim($('#txtADDNivelEscolaridade').val()) == ""){
        $("#hddFocus").val("txtADDNivelEscolaridade");
        $("#dialog-atencao").html("Por favor, informe o nível de escolaridade.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // bind form using ajaxForm 
    $('#frmNivelEscolaridade').ajaxForm({
        dataType:  'json', // Comentar essa linha para debugar
        success: function(data){
            preLoadingClose();

            if(data.excecao == "true"){
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
            }else{
                getNivelEscolaridade();
                $('#txtADDNivelEscolaridade').val("");
                $("#dialog-add-nivelEscolaridade").dialog("close");
            } 
        } 
    }).submit();
}
// congregacoes
function getCongregacao(){
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/CongregacaoControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", UNI_Status: "A"}
    })
    .done(function( data ) {
        var html = '<option value="">SEDE</option>';
        if(data.sucesso == "true"){
            for(var i=0; i<data.rows.length; i++){                                
                html += '<option value="' + data.rows[i].UNI_ID + '">' + data.rows[i].UNI_Descricao + '</option>';
            }
            $("#selUnidade").html(html);
            $("#selUnidade").trigger('chosen:updated');
        }
    });
}

function openADDCongregacao(){
    $("#dialog-add-congregacao").dialog("open");
    $('#txtADDCongregacao').val("");
}

function salvarADDCongregacao(){    
    if($.trim($('#txtADDCongregacao').val()) == ""){
        $("#hddFocus").val("txtADDCongregacao");
        $("#dialog-atencao").html("Por favor, informe a congregação.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // bind form using ajaxForm 
    $('#frmUnidade').ajaxForm({
        dataType:  'json', // Comentar essa linha para debugar
        success: function(data){
            preLoadingClose();

            if(data.excecao == "true"){
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
            }else{
                getCongregacao();
                $('#txtADDCongregacao').val("");
                $("#dialog-add-congregacao").dialog("close");
            } 
        } 
    }).submit();
}









function gereciarMotivoInativacao(){
    var motivo = $("#selMotivoInativacao").val();
    
    if(motivo == "TRANSFERENCIA"){
        $("#fieldsetDescricaoInativacao").show();
        $("#labDescricaoInativacao").html("Nome da Igreja");
    }else{
        if(motivo == "ABANDONO"){
            $("#fieldsetDescricaoInativacao").show();
            $("#labDescricaoInativacao").html("Descrição");
        }else{
            if(motivo == "FALECIMENTO"){
                $("#fieldsetDescricaoInativacao").hide();
            }else{
                if(motivo == "DESAPARECIMENTO"){
                    $("#fieldsetDescricaoInativacao").hide();
                }else{
                    if(motivo == "OUTRO"){
                        $("#fieldsetDescricaoInativacao").show();
                        $("#labDescricaoInativacao").html("Descrição do Motivo");
                    }
                }
            }
        }
    }
}

function gerenciarTipo(){
    var tipo = $("#selTipo").val();
    
    if(tipo == "INATIVO"){
        $("#ckbFalecimento").prop("checked", true);        
    }else{
        $("#ckbFalecimento").prop("checked", false);
    }
    
    gerenciarDataFalecimento(true);
}


function getMembroSecundario(){
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: true,
        data: {ACO_Descricao: "Consultar", PES_Status: "A", GRID:true}
    })
    .done(function( data ) {
        var html = '<option value=""></option>';
        if(data.sucesso == "true"){
            for(var i=0; i<data.rows.length; i++){                                
                html += '<option value="' + data.rows[i].PES_ID + '">' + data.rows[i].PES_Nome + '</option>';
            }
            $("#selMembroSecundario").html(html);
            $("#selMembroSecundario").trigger('chosen:updated');
        }
    });
}


// ministérios

function openAddMinisterio(){
    $("#dialog-add-ministerio").dialog("open");
    $('#txtADDMinisterio').val("");
}

function salvarADDMinisterio(){ 
    if($.trim($('#txtADDMinisterio').val()) == ""){
        $("#hddFocus").val("txtADDMinisterio");
        $("#dialog-atencao").html("Por favor, informe o ministério.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    // bind form using ajaxForm 
    $('#frmMinisterio').ajaxForm({
        dataType:  'json', // Comentar essa linha para debugar
        success: function(data){
            preLoadingClose();

            if(data.excecao == "true"){
                $("#dialog-excecao").html(data.mensagem);
                $("#dialog-excecao").dialog("open");
            }else{
                getMinisterios();
                $('#txtADDMinisterio').val("");
                $("#dialog-add-ministerio").dialog("close");
            } 
        } 
    }).submit();
}


function getMinisterios(){    
    var AMI_ID;    
    if($('#selAreaMinisterial').val()> 0){
        AMI_ID = $('#selAreaMinisterial').val();
    }else{
        AMI_ID = " IS NULL ";
    }
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/MinisterioControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", MIN_Status: "A", AMI_ID: AMI_ID}
    })
    .done(function( data ) {
        $("#selMinisterio").html("<option value=''></option>");        
        if(data.sucesso == "true"){
            var html = '';            
            for(var i=0; i<data.rows.length; i++){
                html += '<option value="' + data.rows[i].MIN_ID + '">' + data.rows[i].MIN_Descricao + '</option>';
            }            
            $("#selMinisterio").html(html);
            $("#selMinisterio").trigger('chosen:updated');
        }else{
            $("#selMinisterio").html(html);
            $("#selMinisterio").trigger('chosen:updated');
        }
    });
}


function gerenciarMinisterioAtual(){    
    if ($("#ckbMinisterioAual").prop("checked")){       
        $("#txtMinisterioAte").val("");
        $("#txtMinisterioAte").prop('disabled', true);                
    }else{
        $("#txtMinisterioAte").prop('disabled', false);
    }
}



function gerenciarMinisterioAtualEdicao(){    
    if ($("#ckbMinisterioAtualEdicao").prop("checked")){       
        $("#txtMinisterioAteEdicao").val("");
        $("#txtMinisterioAteEdicao").prop('disabled', true);                
    }else{
        $("#txtMinisterioAteEdicao").prop('disabled', false);
    }
}




function addMinisterio(){
    var MIN_ID   = $("#selMinisterio").val();        
    var MIN_Descricao = $("#selMinisterio :selected").text();    
    var MMI_Desde  = $("#txtMinisterioDesde").val();
    var MMI_Ate = $("#txtMinisterioAte").val();    
    var AMI_ID = $("#selAreaMinisterial").val();
    var AMI_Descricao = $("#selAreaMinisterial :selected").text();
    
    if($.trim(MIN_ID) == ""){                        
        $("#hddFocus").val("selMinisterio");
        $("#dialog-atencao").html("Por favor, informe o ministério.");
        $("#dialog-atencao").dialog("open");        
        return;
    }  
    if($.trim(MMI_Desde) == ""){                
        $("#hddFocus").val("txtMinisterioDesde");
        $("#dialog-atencao").html("Por favor, informe a data de início no ministério.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    if(!isDataValida(MMI_Desde)){                
        $("#hddFocus").val("txtMinisterioDesde");
        $("#dialog-atencao").html("Por favor, informe uma data de início de atividade válida.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    if(!$("#ckbMinisterioAual").prop("checked")){
        if($.trim(MMI_Ate) == ""){                
            $("#hddFocus").val("txtMinisterioAte");
            $("#dialog-atencao").html("Por favor, informe a data de término no ministério.");
            $("#dialog-atencao").dialog("open");
            return;
        }  
        if(!isDataValida(MMI_Ate)){                
            $("#hddFocus").val("txtMinisterioAte");
            $("#dialog-atencao").html("Por favor, informe uma data de término no ministério válida.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    if( (MMI_Desde != "") && (MMI_Ate != "") ){        
        //compararDatas(strDataInicial, strHoraInicial, strDataFinal, strHoraFinal){
        /******** COMPARA DATA NO FORMATO DD/MM/AAAA 00:00 *******/
        //se não quiser informar oo horario, definir as variaves de hora na função como null        
        if(!compararDatas(MMI_Desde, null, MMI_Ate, null)){
            $("#hddFocus").val("txtMinisterioAte");
            $("#dialog-atencao").html("Por favor, a data de término deve ser maior do que a data de início no ministério.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }

    $.post(controlador, {
        ACO_Descricao: "AdicionarMinisterio", 
        MIN_ID:  MIN_ID,
        MMI_Desde: MMI_Desde,
        MMI_Ate: MMI_Ate,
        MIN_Descricao: MIN_Descricao,
        AMI_ID: AMI_ID,
        AMI_Descricao: AMI_Descricao        
    },
        function(data) {
            //alert(data);
            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }   
            
            if(data.sucesso == "true"){ 
                
                $("#selMinisterio").val("");                
                $("#selMinisterio").trigger('chosen:updated');
                
                $("#selAreaMinisterial").val("");                
                $("#selAreaMinisterial").trigger('chosen:updated');
                
                $("#txtMinisterioDesde").val("");
                $("#txtMinisterioAte").val("");
                
                $("#ckbMinisterioAual").prop("checked", false);                
                $("#hddFocus").val("selMinisterio");
                focus($("#hddFocus").val());
                
                getMinisterios();
                gerenciarMinisterioAtual();
                listarMinisterio();
            }
            
        },"json"
    );    
}

function limparMinisterio(){
    $.post(controlador, {
        ACO_Descricao: "LimparMinisterio"
    },
        function(data){                     
            var html = '';
            if(data.sucesso == "true"){                           
                html = '<p>';
                    html += 'Nenhuma ministério adicionado.';
                html += '<p>';                    
                $("#div-grid-ministerio").html(html);
            }else{
                if(data.excecao == "true"){
                    var dialog = "dialog-excecao";                    
                    $("#" + dialog).html(data.mensagem);
                    $("#" + dialog).dialog("open");
                }
            }
        }, "json"
    );
}

function listarMinisterio(){    
    $.post(controlador, {
        ACO_Descricao: "ListarMinisterio"
    },
        function(data){   
            
            console.log(data);
            
            var html = '';

            if(data.sucesso == "true"){

                html += '<p>HISTÓRICO DE MINISTÉRIOS</p><table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="300px">Área Ministerial</td>';
                        html += '<td width="300px">Ministerio</td>';
                        html += '<td width="150px">Desde</td>';                                
                        html += '<td width="150px">Até</td>';                                
                        html += '<td align="center" width="40px">Ações</td>'; 
                    html += '</tr>';
                var classDif = '';
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    //remove o membro primario do select                
                    /*$("#selMembroSecundario").find('[value="'+data.rows[i].PES_Secundario_ID+'"]').remove();
                    $("#selMembroSecundario").val("");
                    $("#selMembroSecundario").trigger('chosen:updated');*/                    
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].AMI_Descricao + '</td>';
                        html += '<td>' + data.rows[i].MIN_Descricao + '</td>';
                        html += '<td>' + data.rows[i].MMI_Desde + '</td>';
                        if(data.rows[i].MMI_Ate ==  null ){
                            html += '<td> </td>';
                        }else{
                            html += '<td>' + data.rows[i].MMI_Ate + '</td>';                            
                        }
                        

                        html += '<td align="center">';
                            html += "<a href='javascript:void(0);' title='Editar: " + data.rows[i].MIN_Descricao + " '><img onclick='editarMinisterio(" + data.rows[i].ID + " );' class='btnEditarMinisterio' alt='editar' src='../../../modulos/sistema/home/img/botao-editar.png' border='0' width='11px' height='11px' /></a> &nbsp;&nbsp;&nbsp; ";
                            html += "<a href='javascript:void(0);' title='Remover: " + data.rows[i].MIN_Descricao + " '><img onclick='removerMinisterio(" + data.rows[i].ID + " );' class='btnExcluirMinisterio' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>  ";                            
                            
                        html += '</td>';                                
                    html += '</tr>';
                }                        
                html += '</table>';

            }else{
                html = '<p>';
                    html += 'Nenhuma ministério adicionado.';
                html += '<p>';
            }                    
            $("#div-grid-ministerio").html(html);

        }, "json"
    );
}


function getMinisterioEdicao(){    
    var AMI_ID;    
    if($('#selAreaMinisterioEdicao').val()> 0){
        AMI_ID = $('#selAreaMinisterioEdicao').val();
    }else{
        AMI_ID = " IS NULL ";
    }
    
    $.ajax({
        type: "POST",
        url: "../../administrativo/cadastro/controladores/MinisterioControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", MIN_Status: "A", AMI_ID: AMI_ID}
    })
    .done(function( data ) {
        $("#selMinisterioEdicao").html("<option value=''></option>");        
        if(data.sucesso == "true"){
            var html = '';            
            for(var i=0; i<data.rows.length; i++){                
                
                html += '<option value="' + data.rows[i].MIN_ID + '">' + data.rows[i].MIN_Descricao + '</option>';
            }            
            $("#selMinisterioEdicao").html(html);
            $("#selMinisterioEdicao").trigger('chosen:updated');
        }else{
            $("#selMinisterioEdicao").html("");
            $("#selMinisterioEdicao").trigger('chosen:updated');
        }
    });
}

function editarMinisterio(idMinisterio){
    $.post(controlador, {
        ACO_Descricao: "BuscarMinisterio",
        ID: idMinisterio
    },
        function(data){
                
                if(data.sucesso == "true"){
                    
                    $("#hddIDMinisterio").val(data.rows.ID);                      
                    $("#selAreaMinisterioEdicao").val(data.rows.AMI_ID);
                    $("#selAreaMinisterioEdicao").trigger('chosen:updated');
                    getMinisterioEdicao();                                                          
                    $("#selMinisterioEdicao").val(data.rows.MIN_ID);
                    $("#selMinisterioEdicao").trigger('chosen:updated');
                    $("#txtMinisterioDesdeEdicao").val(data.rows.MMI_Desde);
                    if (data.rows.MMI_Ate) {// dessa forma trata a variavel sendo null ou empty                        
                        $("#txtMinisterioAteEdicao").val(data.rows.MMI_Ate);                        
                        $("#ckbMinisterioAtualEdicao").prop("checked", false);
                        $("#txtMinisterioAteEdicao").prop("disabled", false);                        
                    }else{
                        $("#ckbMinisterioAtualEdicao").prop("checked", true);                        
                        $("#txtMinisterioAteEdicao").val("");
                        $("#txtMinisterioAteEdicao").prop("disabled", true);
                    }     
                    $("#dialog-editar-ministerio").dialog("open");                    
                }else{
                    if(data.excecao == "true"){
                        var dialog = "dialog-excecao";                    
                        $("#" + dialog).html(data.mensagem);
                        $("#" + dialog).dialog("open");
                    }
                }
        }, "json"
    );
}

function executarEditarMinisterio(){
    var MIN_ID   = $("#selMinisterioEdicao").val();        
    var MIN_Descricao = $("#selMinisterioEdicao :selected").text();    
    var MMI_Desde  = $("#txtMinisterioDesdeEdicao").val();
    var MMI_Ate = $("#txtMinisterioAteEdicao").val();
    var ID   = $("#hddIDMinisterio").val();  
    
    var AMI_ID = $("#selAreaMinisterioEdicao").val();
    var AMI_Descricao = $("#selAreaMinisterioEdicao :selected").text();
    
    if($.trim(MIN_ID) == ""){                        
        $("#hddFocus").val("selMinisterioEdicao");
        $("#dialog-atencao").html("Por favor, informe o ministério.");
        $("#dialog-atencao").dialog("open");        
        return;
    }  
    if($.trim(MMI_Desde) == ""){                
        $("#hddFocus").val("txtMinisterioDesdeEdicao");
        $("#dialog-atencao").html("Por favor, informe a data de início no ministério.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    if(!isDataValida(MMI_Desde)){                
        $("#hddFocus").val("txtMinisterioAteEdicao");
        $("#dialog-atencao").html("Por favor, informe uma data de início no ministério válida.");
        $("#dialog-atencao").dialog("open");
        return;
    }  
    
    if(!$("#ckbMinisterioAtualEdicao").prop("checked")){
        if($.trim(MMI_Ate) == ""){                
            $("#hddFocus").val("txtMinisterioAteEdicao");
            $("#dialog-atencao").html("Por favor, informe a data de término no ministério.");
            $("#dialog-atencao").dialog("open");
            return;
        }  
        if(!isDataValida(MMI_Ate)){                
            $("#hddFocus").val("txtMinisterioAteEdicao");
            $("#dialog-atencao").html("Por favor, informe uma data de término no ministério válida.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }
    
    if( (MMI_Desde != "") && (MMI_Ate != "") ){        
        //compararDatas(strDataInicial, strHoraInicial, strDataFinal, strHoraFinal){
        /******** COMPARA DATA NO FORMATO DD/MM/AAAA 00:00 *******/
        //se não quiser informar oo horario, definir as variaves de hora na função como null        
        if(!compararDatas(MMI_Desde, null, MMI_Ate, null)){
            $("#hddFocus").val("txtMinisterioAteEdicao");
            $("#dialog-atencao").html("Por favor, a data de término deve ser maior do que a data de início no ministério.");
            $("#dialog-atencao").dialog("open");
            return;
        }
    }

    $.post(controlador, {
        ACO_Descricao: "SalvarEditarMinisterio", 
        MIN_ID:  MIN_ID,
        MIN_Descricao: MIN_Descricao,
        MMI_Desde: MMI_Desde,
        MMI_Ate: MMI_Ate,
        ID: ID,
        AMI_ID: AMI_ID,
        AMI_Descricao: AMI_Descricao
    },
        function(data) {
            //alert(data);
            
            var dialog = "dialog-sucesso";
            if(data.excecao == "true"){
                dialog = "dialog-excecao";                    
                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            if(data.sucesso == "true"){                 
                
                $("#selAreaMinisterioEdicao").val("");                
                $("#selAreaMinisterioEdicao").trigger('chosen:updated');
                
                $("#selMinisterioEdicao").val("");
                $("#selMinisterioEdicao").trigger('chosen:updated');   
                
                $("#ckbMinisterioAtualEdicao").prop("checked", false);
                $("#txtMinisterioDesdeEdicao").val("");
                $("#txtMinisterioAteEdicao").val("");
                $("#hddIDMinisterio").val("");  
                
                $("#dialog-editar-ministerio").dialog("close");
                listarMinisterio();                                
                
            }
            
        },"json"
    );     
}

function removerMinisterio(ID){    
    $.post(controlador, {
        ACO_Descricao: "ExcluirMinisterio", 
        ID: ID
    },
        function(data){
            if(data.sucesso == "true"){                
                listarMinisterio();
            }
        },"json"
    );
}













