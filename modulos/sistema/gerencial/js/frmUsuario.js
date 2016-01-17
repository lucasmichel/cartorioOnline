// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../sistema/gerencial/controladores/UsuarioControlador.php";
var dg           = $('#grid');

// inicialização
function init(){    
    // cria as tabs
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
    
    $("#txtTelefone").mask('(99)9999.9999');
    
    initGRID();
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
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();    
        var pesquisaStatus    = $("#selPesquisaStatus").val();    

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar", 
                USU_Login: pesquisaDescricao,
                USU_Status: pesquisaStatus,
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
                            USU_ID: $("#hddID").val()
                        },
                            function(data){                                
                                if(data.sucesso == "true"){                                    
                                    $("#selGrupo").val(data.rows[0].GRU_ID);
                                    $("#txtNome").val(data.rows[0].USU_Nome);
                                    $("#txtLogin").val(data.rows[0].USU_Login);
                                    /*$("#txtSenha").val("***************");
                                    $("#txtConfirmeSenha").val("***************");
                                    $("#txtSenha").attr("disabled", true);
                                    $("#txtConfirmeSenha").attr("disabled", true);*/
                                    $("#txtEmail").val(data.rows[0].USU_Email);
                                    $("#txtTelefone").val(data.rows[0].USU_Telefone);
                                    
                                    if(data.rows[0].USU_Status == "I"){ 
                                        $("#ckbStatus").prop("checked", true);
                                    }
                                    
                                    preLoadingClose();
                                    $('#tabs').tabs('option', 'active', 1);
                                }
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
            name: 'USU_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'USU_Nome', title: 'Nome', width: 150, align: 'left'
        },{
            name: 'USU_Login', title: 'Login', width: 150, align: 'left'
        },{
            name: 'GRU_Descricao', title: 'Grupo', width: 150, align: 'left'
        },{
            name: 'USU_Email', title: 'Email', width: 220, align: 'left'
        },{
            name: 'USU_DataHoraCadastro', title: 'Cadastrado em', width: 150, align: 'left'
        },{
            name: 'USU_DataHoraUltimoAcesso', title: 'Último acesso', width: 150, align: 'left'
        },{
            name: 'USU_Status', title: 'Ativo', width: 60, align: 'center', render: function(d) {
                var status = 'SIM';
                
                if(d == "N"){
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
    
    if($.trim($("#selGrupo").val()) == ""){
        $("#hddFocus").val("selGrupo");
        $("#dialog-atencao").html("Por favor, selecione o grupo do usuário.");
        $('#dialog-atencao').dialog('open');
        return;
    } 

    if($.trim($("#txtNome").val()) == ""){
        $("#hddFocus").val("txtNome");
        $("#dialog-atencao").html("Por favor, informe o nome do usuário.");
        $('#dialog-atencao').dialog('open');
        return;
    } 

    if($.trim($("#txtLogin").val()) == ""){
        $("#hddFocus").val("txtLogin");
        $("#dialog-atencao").html("Por favor, informe o login do usuário.");
        $('#dialog-atencao').dialog('open');
        return;
    } 
    
    // verifica a existência do login
    if(!existeLogin()){
        return;
    }
    
    if($.trim($("#txtSenha").val()) == ""){
        $("#hddFocus").val("txtSenha");
        $("#dialog-atencao").html("Por favor, informe a senha do usuário.");
        $('#dialog-atencao').dialog('open');
        return;
    }
    
    if($.trim($("#txtConfirmeSenha").val()) == ""){
        $("#hddFocus").val("txtConfirmeSenha");
        $("#dialog-atencao").html("Por favor, confirme a senha do usuário.");
        $('#dialog-atencao').dialog('open');
        return;
    }
    
    if($.trim($("#txtSenha").val()) != $.trim($("#txtConfirmeSenha").val())){
        $("#hddFocus").val("txtConfirmeSenha");
        $("#dialog-atencao").html("A confirmação de senha não confere.");
        $('#dialog-atencao').dialog('open');
        return;
    }
    
    if($.trim($("#txtEmail").val()) == ""){
        $("#hddFocus").val("txtEmail");
        $("#dialog-atencao").html("Por favor, informe um email.");        
        $("#dialog-atencao").dialog("open");
        return;                    
    }
    
    if(!isEmail($.trim($("#txtEmail").val()))){
        $("#hddFocus").val("txtEmail");
        $("#dialog-atencao").html("Por favor, informe um email válido.");        
        $("#dialog-atencao").dialog("open");
        return;                    
    }

    // verifica a existência do login
    if(!existeEmail()){
        return;
    }
    
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
    $("#selGrupo").val(""); 
    $("#txtNome").val(""); 
    $("#txtLogin").val("");    
    $("#txtEmail").val("");    
    $("#txtSenha").val("");
    $("#txtSenha").attr("disabled", false);
    $("#txtConfirmeSenha").val("");
    $("#txtConfirmeSenha").attr("disabled", false);
    $("#txtTelefone").val("");
    
    $("#spnChecagemUsuario").html("");
    $("#spnChecagemEmail").html("");    
    $("#ckbStatus").attr("checked", false);    
}

function existeLogin(){
    var login   = $.trim($("#txtLogin").val());
    var retorno = false;
    
    preLoadingOpen("Verificando existência de login, aguarde...");

    if (login.length >= 6){
        $.ajax({
            type: "POST",
            url: controlador,
            dataType: "json",
            async: false,
            data: {ACO_Descricao: "Consultar", USU_LoginIgual: login}
        })
        .done(function( data ) {        
            // verifica o ID do registro
            // para que não seja levado em conta a checagem de existência
            // de login quando for uma alteração
            // pois na alteração o usuário poderá não alterar o login ou e-mail
            if(data.USU_ID = $("#hddID").val()){
                // inverte o valor para 'falso'
                // caso o ID seja igual ao do HDDID
                // que é preenchido no alterar
                if(data.sucesso == "true"){
                    data.sucesso = "false";
                }
            }
            
            if(data.sucesso == "true"){                
                $("#hddFocus").val("txtLogin");
                $("#dialog-atencao").html("Já existe um usuário com este login.");   
                $('#dialog-atencao').dialog('open');
            }else{
                if(data.excessao == "true"){
                    $("#dialog-excecao").html(data.mensagem);   
                    $('#dialog-excecao').dialog('open');
                }else{
                    retorno = true;
                }
            }
        });
        
        preLoadingClose();
    }else{ 
        $("#hddFocus").val("txtLogin");
        $("#dialog-atencao").html("O login deve ter pelo menos 6 caracteres.");
        $('#dialog-atencao').dialog('open');
        preLoadingClose();
    }
    
    return retorno;
}

function existeEmail(){
    var email   = $.trim($("#txtEmail").val());
    var retorno = false;
    
    preLoadingOpen("Verificando existência de email, aguarde...");

    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Consultar", USU_Email: email}
    })
    .done(function( data ) {
        // verifica o ID do registro
        // para que não seja levado em conta a checagem de existência
        // de login quando for uma alteração
        // pois na alteração o usuário poderá não alterar o login ou e-mail
        if(data.USU_ID = $("#hddID").val()){
            // inverte o valor para 'falso'
            // caso o ID seja igual ao do HDDID
            // que é preenchido no alterar
            if(data.sucesso == "true"){
                data.sucesso = "false";
            }
        }
        
        if(data.sucesso == "true"){                
            $("#hddFocus").val("txtLogin");
            $("#dialog-atencao").html("Já existe um usuário com este email.");   
            $('#dialog-atencao').dialog('open');
        }else{
            if(data.excessao == "true"){
                $("#dialog-excecao").html(data.mensagem);   
                $('#dialog-excecao').dialog('open');
            }else{
                retorno = true;
            }
        }
    });

    preLoadingClose();
    
    return retorno;
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
    var ids = new Array();

    for(var i=0; i<dg.datagrid('getSelectedRows').length; i++){
        ids.push(dg.datagrid('getSelectedRows')[i].cells[0].innerHTML); 
    }
    
    $.post(controlador, {
        ACO_Descricao: "Excluir",
        USU_ID: ids
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