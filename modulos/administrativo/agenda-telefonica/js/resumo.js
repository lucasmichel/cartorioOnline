var controlador  = "../../administrativo/agenda-telefonica/controladores/ResumoControlador.php";

// inicialização
function init(){    
    // cria as tabs
    $('#tabs').tabs();
    
    $('#dialog-sucesso').dialog({
        autoOpen: false,
        buttons: {
            "Ok": function() { 
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
    
    $("#btnExportPrint" ).click(function() {
        exportImprimir("relatorio");
    });    
    $("#btnExportExcel" ).click(function() {
        exportExcel("relatorio");
    });    
    $("#btnExportPdf" ).click(function() {
        exportPdf("Agenda", "relatorio", "L");
    }); 
}

function gerar(){
    if($.trim($('#selPesquisaTipo').val()) == ""){                
        $("#hddFocus").val("selPesquisaTipo");
        $("#dialog-atencao").html("Por favor, informe o tipo.");
        $("#dialog-atencao").dialog("open");
        return;
    } 
    
    preLoadingOpen(null);
    
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: 'json',
        cache: false,
        async:false,    
        data: {
            ACO_Descricao: "Consultar",
            PESQ_Nome : $("#txtPesquisaNome").val(),
            PESQ_Tipo : $("#selPesquisaTipo").val()
        }
    }).done(function( data ) {
        if(data.sucesso === "true"){
            $('#relatorio').html(data.dados);
        }
        
        preLoadingClose();
    });
}      

function cancelar(){}
function consultar(){}

//para o autocomplete
var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, não encontrado!'},
    '.chosen-select-width'     : {width:"95%"}
};
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
//para o autocomplete 
