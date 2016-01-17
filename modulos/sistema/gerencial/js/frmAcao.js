// codificação utf-8
var dg = $('#grid');

var enderecoControl = "../../sistema/gerencial/controladores/AcaoControlador.php";

// inicialização
function init(){
    // cria as tabs
    $('#tabs').tabs();
    
    // Dialog
    $('#dialog-sucesso').dialog({
        autoOpen: false,
        width: 400,
        buttons: {
            "Ok": function() {                
                cancelar();                
                exibirDadosGrid(); 
                $(this).dialog("close");
            }
        }
    });
    
    $('#dialog-atencao').dialog({
        autoOpen: false,
        width: 400,
        buttons: {
            "Ok": function() {
                focus($("#hddFocus").val());                
                $(this).dialog("close"); 
            }
        }
    });
        
    // carrega o grid
    exibirDadosGrid();     
}

// coloca o cursor no idElemento informado
function focus(idElemento){
    $("#" + idElemento).focus();
}

function salvar(){ 
    var formularioID = $("#hddFormularioID").val();
    var permAcao     = "Salvar"; 
    if($("#hddCodigo").val() != ""){
        permAcao = "Alterar";
    }
/*
    // checa permissão
    $.post(enderecoControl, {
        acao: "ChecarPermissao",
        FRM_ID: formularioID,
        formularioAcao: permAcao
    },
        function(data){ 
            //alert(data); return;
            if(data.sucesso == "acesso-negado"){
                $("#dialog-atencao").html(data.mensagem);        
                $("#dialog-atencao").dialog("open");
                return;
            }else{
  */  
                if($.trim($('#txtDescricao').val()) == ""){        
                    $("#hddFocus").val("txtDescricao");
                    $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o.");        
                    $("#dialog-atencao").dialog("open");
                    return;
                }

                $("#ckbStatus").val("A");
                if($("#ckbStatus").is(":checked")) $("#ckbStatus").val("I");
                
                // verifica se nome ja existe...
                $.post(enderecoControl, {
                    acao: "VerificarDescricaoExiste",
                    ACO_ID: $("#hddCodigo").val(), 
                    ACO_Descricao: $.trim($('#txtDescricao').val())
                },
                    function(data){
                        //alert(data); return;
                        if(data.sucesso === "true"){
                            // bind form using ajaxForm 
                            $('#frmFormulario').ajaxForm({
                                 //dataType identifies the expected content type of the server response 
                                dataType:  'json', // Comentar essa linha para debugar
                                // success identifies the function to invoke when the server response 
                                // has been received
                                success: function(data){
                                    //alert(data);
                                    if(data.sucesso == "acesso-negado"){
                                        $("#dialog-atencao").html(data.mensagem);        
                                        $('#dialog-atencao').dialog('open');
                                    }else{
                                        if(data.sucesso == "true"){                
                                            $("#dialog-sucesso").html(data.mensagem);        
                                            $('#dialog-sucesso').dialog('open');
                                        }else{
                                            $("#dialog-atencao").html(data.mensagem);        
                                            $('#dialog-atencao').dialog('open');
                                        }
                                    }
                                }
                            }).submit();                            
                        }else{
                            $("#dialog-atencao").html(data.mensagem);
                            $("#dialog-atencao").dialog("open"); 
                        }
                    }, "json"
                );
                    /*
            }
        }, "json"
    );*/
}

function exibirDadosGrid(){    
    
    // limpa o grid a cada vez que a consulta é realizada
    dg.datagrid('getTbody').empty();
    var txtPesquisaDescricao = $("#txtPesquisaDescricao").val();
    var selPesquisaStatus    = $("#selPesquisaStatus").val();
    var formularioID         = $("#hddFormularioID").val();
    //var filtroValor        = $('input:radio[name=rdbFiltro]:checked').val();
    var limitConsulta        = 20; // limit padrão
    
    if($("#numlines").size() > 0){
        limitConsulta = parseInt($("#numlines").val());
    }    
    
    //ATENÇÂO USAR ISTO PRA DEBUG!!!!!!!
    /*
    $.post(enderecoControl, {
        acao: "Consultar",
        ACO_Status: selPesquisaStatus,
        ACO_Descricao: txtPesquisaDescricao,
        limit: limitConsulta,
        FRM_ID: "",    
        offset: 0
    },
        function(data) {                            
            alert(data);  
        }
    );
    //ATENÇÂO USAR ISTO PRA DEBUG!!!!!!!
    */

    // checa permissão
    $.post(enderecoControl, {
        acao: "ChecarPermissao",
        FRM_ID: formularioID,
        formularioAcao: "Consultar"
    },
        function(data){             
            if(data.sucesso == "acesso-negado"){
                $("#dialog-atencao").html(data.mensagem);        
                $("#dialog-atencao").dialog("open");
                return;
            }else{                
                dg.datagrid({
                    jsonStore: {
                        url: enderecoControl
                        ,params: {
                            acao: "Consultar", 
                            ACO_Status: selPesquisaStatus,
                            ACO_Descricao: txtPesquisaDescricao,
                            limit: limitConsulta,
                            FRM_ID: ""            
                        }
                    }
                    ,ajaxMethod: "POST"
                    ,limit: limitConsulta
                    ,pagination: true
                    ,autoLoad: true
                    ,title: ''
                    ,rowNumber: false
                    ,onClickRow: function() {}
                    ,toolBarButtons:[
                        {
                            label: 'Alterar'
                            ,icon: 'pencil'
                            ,fn: function() {
                                if(dg.datagrid('getSelectedRow').length > 0){
                                    // checa permissão
                                    $.post(enderecoControl, {
                                        acao: "ChecarPermissao",
                                        FRM_ID: formularioID,
                                        formularioAcao: "Alterar"
                                    },
                                        function(data) { 
                                            //alert(data); return;
                                            if(data.sucesso == "acesso-negado"){
                                                $("#dialog-atencao").html(data.mensagem);        
                                                $("#dialog-atencao").dialog("open");
                                                return;
                                            }else{
                                                // pega o id do registro
                                                var id = dg.datagrid('getSelectedRow')[0].cells[0].innerHTML;
                                                // verifica se ainda está em aberto
                                                // caso esteja em execução a operação não é
                                                // permitida 
                                                $.post(enderecoControl, {
                                                    acao: "Consultar",
                                                    ACO_ID: id
                                                },
                                                    function(data) {
                                                        //alert(data); return;
                                                        if(data.sucesso == "true"){
                                                            // consulta os dados da OS
                                                            $.post(enderecoControl, {
                                                                acao: "Consultar",
                                                                ACO_ID: id
                                                            },
                                                                function(data){
                                                                    //alert(data); return;
                                                                    if(data.sucesso == "true"){
                                                                        $("#hddCodigo").val(data.rows[0].ACO_ID);
                                                                        $("#txtDescricao").val(data.rows[0].ACO_Descricao);
                                                                        
                                                                        if(data.rows[0].ACO_Status == "I"){                                                                            
                                                                            $("#ckbStatus").attr("checked", true);
                                                                        }

                                                                        $("#txtDescricao").attr("disabled", false);
                                                                        $('#tabs').tabs().tabs('select', 1);
                                                                    }
                                                                }, "json"
                                                            );
                                                        }else{
                                                            $("#dialog-atencao").html(data.mensagem);        
                                                            $("#dialog-atencao").dialog("open");
                                                        }
                                                    }, "json"
                                                );
                                            }
                                        }, "json"
                                    );
                                }else{
                                    $("#dialog-atencao").html("Por favor, selecione o registro que deseja alterar.");
                                    $("#dialog-atencao").dialog("open");
                                }
                            }
                        },
                        {
                            label: 'Detalhe'
                            ,icon: 'document'
                            ,fn: function(){
                                if(dg.datagrid('getSelectedRow').length > 0){

                                    // checa permissão
                                    $.post(enderecoControl, {
                                        acao: "Consultar",
                                        FRM_ID: formularioID,
                                        formularioAcao: "Alterar"
                                    },
                                        function(data) { 
                                            //alert(data); return;
                                            if(data.sucesso == "acesso-negado"){
                                                $("#dialog-atencao").html(data.mensagem);        
                                                $("#dialog-atencao").dialog("open");
                                                return;
                                            }else{
                                                // verifica se ainda está em aberto
                                                // caso esteja em execução a operação não é
                                                // permitida 
                                                $.post(enderecoControl, {
                                                    acao: "Consultar",
                                                    ACO_ID: dg.datagrid('getSelectedRow')[0].cells[0].innerHTML
                                                },
                                                    function(data) {
                                                        //alert(data); return;
                                                        if(data.sucesso == "true"){
                                                            // consulta os dados da OS
                                                            $.post(enderecoControl, {
                                                                acao: "Consultar",
                                                                ACO_ID: dg.datagrid('getSelectedRow')[0].cells[0].innerHTML
                                                            },
                                                                function(data){
                                                                    //alert(data); return;
                                                                    if(data.sucesso == "true"){
                                                                        $("#hddCodigo").val(data.rows[0].ACO_ID);
                                                                        $("#txtDescricao").val(data.rows[0].ACO_Descricao);

                                                                        if(data.rows[0].ACO_Status == "I"){
                                                                            $("#ckbStatus").attr("checked", true);
                                                                        }

                                                                        $("#ckbStatus").attr("disabled", true);
                                                                        $("#txtDescricao").attr("disabled", true);                                                                        
                                                                        $("#btnSalvar").hide();
                                                                        $('#tabs').tabs().tabs('select', 1);
                                                                    }
                                                                }, "json"
                                                            );
                                                        }else{
                                                            $("#dialog-atencao").html(data.mensagem);
                                                            $("#dialog-atencao").dialog("open");
                                                        }
                                                    }, "json"
                                                );
                                            }
                                        }, "json"
                                    );                 

                                }else{
                                    $("#dialog-atencao").html("Por favor, selecione o registro que deseja detalhar.");        
                                    $("#dialog-atencao").dialog("open");      
                                }
                            }
                        },{
                            label: 'Desmarcar'
                            ,icon: 'refresh'
                            ,fn: function(){
                                $(this).datagrid('clearSelectedRow')
                            }
                        }
                    ]
                    ,mapper:[{
                        name: 'ACO_ID', title: 'ID.', width: 50, align: 'left'
                    },{
                        name: 'ACO_Descricao', title: 'Descri&ccedil;&atilde;o', width: 900, align: 'left'
                    },{
                        name: 'ACO_Status', title: 'Ativo', width: 50, align: 'center', render: function(d){
                            if (d == "I") return "Não"; else return "Sim";
                        }
                    }]
                });                
            }
        }, "json"
    );   
}

function cancelar(){
    $('#tabs').tabs().tabs('select', 0); // retorna para a primeira aba
    $("#hddCodigo").val("");  
    $("#hddFocus").val("");    
    $("#txtDescricao").val("");
    $("#txtDescricao").attr("disabled", false);        
    $("#ckbStatus").attr("checked", false);
    $("#ckbStatus").attr("disabled", false);
    $("#btnSalvar").show();
}