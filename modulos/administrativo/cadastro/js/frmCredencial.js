// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/cadastro/controladores/MembroControlador.php";
var dg           = $('#grid');

// inicialização
function init(){
    // tabs
    $('#tabs').tabs();
    
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
    
    // configura o grid
    initGRID();   
      
    // carrega o grid
    consultar();  
}

function gerar(){
    var ids = "";
    
    for(var i=0; i<dg.datagrid('getSelectedRows').length; i++){
        ids += dg.datagrid('getSelectedRows')[i].cells[0].innerHTML;
        
        if(i<(dg.datagrid('getSelectedRows').length - 1)){
            ids += ",";
        }
    }
    
    // pega o id do registro                           
    var url = "../../administrativo/cadastro/documentos/CarteiraMembro.php?PES_ID=" + ids;
    popUpCentralizado(url, 755, 595);
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
            pesquisarCampo: pesquiasrCampo,
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
        ,uniqueRow: false
        ,onClickRow: function(row) {
            $(this).datagrid('selectRow',row);
        }
        ,toolBarButtons: [
            {
                label: 'Emitir Credencial'
                ,icon: 'print'
                ,fn: function(){                    
                    if(dg.datagrid('getSelectedRows').length > 0){
                        gerar();                        
                    }else{
                        $("#dialog-atencao").html("Por favor, selecione o(s) registro(s) que deseja imprimir a credencial.");        
                        $("#dialog-atencao").dialog("open"); 
                    }                    
                }                
            }
        ]
        ,mapper:[{
            name: 'PES_ID', title: 'ID', width: 60, align: 'center'
        },{
            name: 'PES_ArquivoFoto', title: 'Foto', width: 60, align: 'center', render: function(foto) {                
                if(foto.length > 0){                      
                    return '<img  src="'+foto+'"  width="25" height="30" />';                                        
                }else{
                    return '<img  src="../../../modulos/sistema/home/img/semFoto.png"  width="25" height="30" />';                    
                }
            }        
        },{
            name: 'PES_Nome', title: 'Nome', width: 510, align: 'left'        
        },{
            name: 'PES_CPF', title: 'CPF', width: 110, align: 'left'                
        },{
            name: 'PES_Matricula', title: 'Matrícula', width: 120, align: 'left'        
        },{
            name: 'PES_DataNascimento', title: 'Data de nascimento', width: 120, align: 'left'
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