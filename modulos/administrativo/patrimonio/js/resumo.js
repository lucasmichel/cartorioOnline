var controlador  = "../../administrativo/patrimonio/controladores/ResumoControlador.php";
var charts;
var tabelaDadosHtml;
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
    
    gerarGrafico();    
}

function gerarGrafico(){   
    preLoadingOpen("Gerando resumo, aguarde...");
    $("#grafico").html("<b>Carregando...</b>");
    $("#dados").html("<b>Carregando...</b>");
    
    $.post(controlador, 
    {
        ACO_Descricao: "DadosDoGrafico"
    },
        function(data){
            
            
            if(data.sucesso == "true"){
                txtIgreja = data.dadosIgreja;
                tabelaDadosHtml = data.dados.EXCEL;
                txtTitulo1 = data.dadosTitulo1;
                txtTitulo2 = data.dadosTitulo2;
                txtTitulo3 = data.dadosTitulo3;
                txtRodaPe = data.dadosRodape;
            
                var categories = data.dados.chart.categories;
                var series = data.dados.chart.series;
                
                var chart = new Highcharts.Chart({
                    chart: {
                        type: 'column',
                        renderTo: "grafico"
                    },
                    title: {                        
                        text: data.dados.chart.title
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: categories,
                        title: {
                            text: 'Grupos de Patrimônio',
                            align: 'high'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Quantidade (Un)',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' unidade(s)'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    credits: {
                        enabled: false
                    },
                    
                    series: [{                    
                            name: series.name,
                            data: series.data
                    }]                    
                    
                });                
                charts=new Array();            
                charts.push({title:data.dados.chart.title,svg:chart.getSVG()});
                $("#dados").html(tabelaDadosHtml);                
                preLoadingClose();
            }else{                
                $("#grafico").html("<b>"+data.mensagem+"</b>");
                $("#dados").html("<b>"+data.mensagem+"</b>");
                preLoadingClose();
            } 
            
            
        }, "json"
    );
}