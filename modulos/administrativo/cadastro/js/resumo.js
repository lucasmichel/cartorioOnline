// inicialização
var controlador  = "../../administrativo/cadastro/controladores/ResumoControlador.php";

function init(){
    // cria as tabs
    $('#tabs').tabs(); 
    
    
    gerarResumoMembroPorTipo();
    //gerarResumoMembroPorSexo();
}

function gerarResumoMembroPorTipo(){    
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "MembroPorStatus"}
    })
    .done(function( data ) {        
         if(data.sucesso == "true"){              
            $('#resMembroPorStatus').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 1,//null,
                    plotShadow: false
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: data.grafico.categories,
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Qtd. de Membros',
                        align: 'middle'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y} pessoa(s)</b>'
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
                legend: {
                    enabled: true
                },
                credits: {
                    enabled: false
                },
                series: [{
                    type: 'pie',
                    name: 'Quantidade',   
                    data: data.grafico.data
                }]
            });
        }
 
        $("#relatorioMembroPorStatus").html(data.relatorio);
    });
}

function gerarResumoMembroPorSexo(){
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "MembroPorSexo"}
    })
    .done(function( data ) {
         if(data.sucesso == "true"){              
            $('#resMembroPorSexo').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    width: 835
                },
                title: {
                    text: 'Quantidade de Membros por Sexo'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                series: [{
                    type: 'pie',
                    name: 'Qtd.',
                    data: [
                        ['Masculino',   data.grafico.dataM],
                        ['Feminino',       data.grafico.dataF]
                    ]
                }]
            });
        }
 
        $("#relatorioMembroPorSexo").html(data.relatorio);
    });
}