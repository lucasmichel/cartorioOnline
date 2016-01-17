// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../sistema/gerencial/controladores/ModuloControlador.php";
var dg           = $('#grid');

// inicialização
function init(){
    // tabs
    $('#tabs').tabs();
        
    $('#dialog-atencao').dialog({
        autoOpen: false,
        buttons: {
            "Ok": function() {
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
        var categoriaID       = $("#selPesquisaCategoria").val();
        var pesquisaDescricao = $("#txtPesquisaDescricao").val();    

        if($("#numlines").size() > 0){
            limitConsulta = parseInt($("#numlines").val());
        }    

        var params = {
            ACO_Descricao: "Consultar",
                MCT_ID: categoriaID,
                MOD_Descricao: pesquisaDescricao,
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
        ,toolBarButtons: []
        ,mapper:[{
            name: 'MOD_ID', title: 'Cód.', width: 60, align: 'left'
        },{
            name: 'MOD_Descricao', title: 'Subm&oacute;dulo', width: 440, align: 'left'
        },{
            name: 'MCT_Descricao', title: 'M&oacute;dulo', width: 440, align: 'left'
        },{
            name: 'MOD_Imagem', title: '&Iacute;cone', width: 60, align: 'center', render: function(d) {
                var icone = '<img src="img/botoes/submodulos/' + d + '" style="width: 32px; height: 32px;"/>';
                
                return icone;
            }
        }]
    });
}