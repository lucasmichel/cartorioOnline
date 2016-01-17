// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../sistema/gerencial/controladores/ParametroControlador.php";

// inicialização
function init(){    
    // define as abas
    $('#tabs').tabs();
    $("#txtQuantidadeFolhaLivro").numeric();
    $("#txtQuantidadeLinhaFolha").numeric();
    
    
    // dialogs
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
                $(this).dialog("close"); 
            }
        }
    });

  
    $("#fileImagem").change(function(){
        readImage(this);
    });
    $('#txtEmail').alphanumeric({allow:"._-@"});
    $('#txtFone').mask("(99) 9999.9999");
    initAlterar();
}

function readImage(input) { 
    if ( input.files && input.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {            
            var totalBits = e.target.result.length;            
            var totalKilobits = totalBits/1024;
            var totalMegaBits = totalKilobits/1024;
            if(totalMegaBits < 100.0000){
                //com isso aqui se pode exibir a imagem antes mesmo de ser feito o upload da mesma
                //$('#img').attr( "src", e.target.result );
                //$('#base').text( e.target.result );             
                $("#div-foto-nova").html("<center><img width='300' height='80' class='fotoTirada'  src='"+e.target.result+"' ></center>");
                
                $(".fotoTirada").attr("src", e.target.result);
                $(".fotoTirada").attr("width", 300);
                $(".fotoTirada").attr("height", 80);
                //passa o valor para a variavel pra sallvar no banco
                strBase64ImagemUpload = e.target.result;
                 
                $("#hddImagem").val(strBase64ImagemUpload);
            }else{
                $("#dialog-atencao").html("Atenção, a imagem deverá ser de até 1MB.");
                $('#dialog-atencao').dialog('open');
            }
        };       
        FR.readAsDataURL( input.files[0] );
    }
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

function initAlterar(){ 
      
    // PARA TESTE 
    $.post(controlador, {
        ACO_Descricao: "Consultar"        
    },
        function(data) {              
            if(data.sucesso == "true"){  
                //preencherContato();
                $("#txtCNPJ").val(data.rows[0].PAR_CNPJ); 
                $("#txtDenominacao").val(data.rows[0].PAR_Denominacao);                
                
                $("#txtEnderecoBairro").val(data.rows[0].PAR_EnderecoBairro); 
                $("#txtEnderecoCEP").val(data.rows[0].PAR_EnderecoCep); 
                $("#txtEnderecoCidade").val(data.rows[0].PAR_EnderecoCidade); 
                $("#txtEnderecoComplemento").val(data.rows[0].PAR_EnderecoComplemento); 
                $("#txtEnderecoLogradouro").val(data.rows[0].PAR_EnderecoLogradouro); 
                $("#txtEnderecoNumero").val(data.rows[0].PAR_EnderecoNumero); 
                $("#selEnderecoUF").val(data.rows[0].PAR_EnderecoUf); 
                
                
                $("#txtQuantidadeFolhaLivro").val(data.rows[0].PAR_TotFolhaLivro); 
                $("#txtQuantidadeLinhaFolha").val(data.rows[0].PAR_TotLinhaFolha); 
                
                
                if(data.rows[0].PAR_Logo.length > 1){                    
                    $("#hddImagem").val(data.rows[0].PAR_Logo);
                    $("#imagemAtual").attr("src",data.rows[0].PAR_Logo);
                }else{
                    $("#hddImagem").val("");
                    $("#imagemAtual").attr("src","../../sistema/gerencial/img/sem-logo.png");
                }
                $("#txtNomeFantasia").val(data.rows[0].PAR_NomeFantasia);                
                $("#txtPastor").val(data.rows[0].PAR_Pastor); 
                $("#txtRazaoSocial").val(data.rows[0].PAR_RazaoSocial);                                 
                $("#txtSite").val(data.rows[0].PAR_Site); 
                
            }
        }, "json"
    );    
}

function preencherContato(){

    // e-mails
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "PreencherSessionEmails"}
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
        data: {ACO_Descricao: "PreencherSessionFone"}
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
    
    // código                
    /*if($.trim($('#txtCNPJ').val()) != ""){        
        if(!isCNPJValido($('#txtCNPJ').val())){
            $("#hddFocus").val("txtCNPJ");
            $("#dialog-atencao").html("Por favor, informe um CNPJ v&aacute;lido.");        
            $("#dialog-atencao").dialog("open");
            return;
        }
    }*/

    preLoadingOpen("Gravando..."); 

    $('#frm').ajaxForm({                    
        dataType:  'json',                    
        success: function(data) {             
            preLoadingClose();
            if(data.sucesso == "true"){                
                $("#dialog-sucesso").html("Parâmetros atualizados com sucesso.");        
                $('#dialog-sucesso').dialog('open');
            }else{
                var dialog = "dialog-atencao";

                if(data.excecao == "true"){
                    dialog = "dialog-excecao";                    
                }   

                $("#" + dialog).html(data.mensagem);
                $("#" + dialog).dialog("open");
            }
            
            
        } 
    }).submit();             
}

function cancelar(){}
function consultar(){}




function adicionarFone(){    
    var PART_Numero = $("#txtFone").val();
    
    if($.trim(PART_Numero) == ""){        
        $("#hddFocus").val("txtFone");
        $("#dialog-atencao").html("Por favor, informe o telefone.");
        $("#dialog-atencao").dialog("open");
        return;
    }
    
    preLoadingOpen("Adicionando telefone, aguarde...");
    
    $.post(controlador, {
        ACO_Descricao: "AdicionarFone",         
        PART_Numero: PART_Numero
        
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
                $("#txtFone").val("");                
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
            var html = '';
            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="97%">';
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="100%">Telefone</td>';                        
                        html += '<td align="center" width="10%">Excluir</td>'; 
                    html += '</tr>';
                var classDif = '';  
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].PART_Numero + '</td>';                        
                        html += '<td align="center">';                                    
                            html += "<a href='javascript:void(0);' title='Remover'><img onclick='removerFone(" + data.rows[i].ID + ");' class='btnExcluirFone' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>";
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

function limparFone(){
    $.post(controlador, {
        ACO_Descricao: "LimparFone"
    },
        function(data){                     
            var html = '';
                if(data.sucesso == "true"){                    
                    $("#txtFone").val(""); 
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
    var PARE_EMAILS  = $("#txtEmail").val();
    
    if($.trim(PARE_EMAILS) == ""){        
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
        PARE_EMAILS:  PARE_EMAILS        
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
                        html += '<td width="90%">E-mail</td>';                        
                        html += '<td align="center" width="10%">Excluir</td>'; 
                    html += '</tr>';
                var classDif = '';  
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].PARE_EMAILS + '</td>';                        
                        html += '<td align="center">';                                    
                            html += "<a href='javascript:void(0);' title='Remover'><img onclick='removerEmail(" + data.rows[i].ID + ");' class='btnExcluirEmail' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>";
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