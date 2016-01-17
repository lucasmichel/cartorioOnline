// inicialização
var controlador  = "../../administrativo/financeiro/controladores/ResumoControlador.php";

function init(){
    // cria as tabs
    $('#tabs').tabs();
    
    $("#btnExportPrint" ).click(function() {
        exportImprimir("resumo");
    });
    
    $("#btnExportExcel" ).click(function() {
        exportExcel("dadosRelatorio");
    });
    
    $("#btnExportPdf" ).click(function() {
        exportPdf("Lembretes_Financeiro", "resumo", "L");
    });
    
    $("#btnExportExcel").hide();
}