var controlador  = "../../livroRegistro/relatorios/controladores/ResumoControlador.php";
var charts;
var tabelaDadosHtml;

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

function init(){
    // cria as tabs
    $('#tabs').tabs();
    
    $("#btnExportPrint" ).click(function() {
        exportImprimir("relatorio");
    });

    $("#btnExportExcel" ).click(function() {
        exportExcel("tableRelatorio");
    });

    $("#btnExportPdf" ).click(function() {
        exportPdf("Rel_Resumo_Patrimonial", "dados", "P");
    }); 
    
    $("#btnExportPrint" ).hide();
    $("#btnExportExcel" ).hide();
    $("#btnExportPdf" ).hide();
    
    $('#txtFiltroFim').datepicker();
    $('#txtFiltroFim').mask("99/99/9999");
    
    $('#txtFiltroInicio').datepicker();
    $('#txtFiltroInicio').mask("99/99/9999");
    
    
    gerarGrafico();    
}

function gerarGrafico(){   
    preLoadingOpen("Gerando, aguarde...");
    $("#grafico").html("<b>Carregando...</b>");
    $("#dados").html("<b>Carregando...</b>");
    
    $.post(controlador, 
    {
        ACO_Descricao: "DadosDoGrafico",
        tipoConsulta: $("#selTipoFiltro").val(),
        dataInicial: $("#txtDataInicio").val(),
        dataFim: $("#txtDataFim").val()
        
        
    },
        function(data){
            
            
            if(data.sucesso == "true"){
   
                graficoReceita(data.graficoReceita);
                graficoDespesa(data.graficoDespesa);
                
                preLoadingClose();
            }else{                
                $("#graficoReceita").html("<b>"+data.mensagem+"</b>");
                $("#graficoDespesa").html("<b>"+data.mensagem+"</b>");
                preLoadingClose();
            } 
            
            
        }, "json"
    );
}


function graficoReceita(data){
    var series = data.series;
    $('#graficoReceita').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Receitas'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Total',
            colorByPoint: true,
            data: series
            /*data: [{
                name: 'Microsoft Internet Explorer',
                y: 56.33
            }, {
                name: 'Chrome',
                y: 24.03,
                sliced: true,
                selected: true
            }, {
                name: 'Firefox',
                y: 10.38
            }, {
                name: 'Safari',
                y: 4.77
            }, {
                name: 'Opera',
                y: 0.91
            }, {
                name: 'Proprietary or Undetectable',
                y: 0.2
            }]*/
        }]
    });
    return true;
    
}
function graficoDespesa(data){
    var series = data.series;
    $('#graficoDespesa').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Despesas'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Total',
            colorByPoint: true,
            data: series
            /*data: [{
                name: 'Microsoft Internet Explorer',
                y: 56.33
            }, {
                name: 'Chrome',
                y: 24.03,
                sliced: true,
                selected: true
            }, {
                name: 'Firefox',
                y: 10.38
            }, {
                name: 'Safari',
                y: 4.77
            }, {
                name: 'Opera',
                y: 0.91
            }, {
                name: 'Proprietary or Undetectable',
                y: 0.2
            }]*/
        }]
    });
    return true;
}