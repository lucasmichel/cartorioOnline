// inicialização
var controlador  = "../../sistema/gerencial/controladores/ResumoControlador.php";

function init(){
    // cria as tabs
    $('#tabs').tabs();
    
    $('#dialog-detalhe').dialog({
        autoOpen: false,
        width: 500,
        buttons: {
            "Fechar": function() { 
                $(this).dialog("close"); 
            }
        }
    });
    
    gerarGrafico();
}


function gerarGrafico(){ 
    preLoadingOpen("Gerando resumo, aguarde...");
      
    $.post(controlador, 
    {
        ACO_Descricao: "DadosDoGrafico"
    },
        function(data){            
            $("#dados").html(data.html);
            
            preLoadingClose();
        }, "json"
    );
}

function detalhar(grupoID){    
    preLoadingOpen(null);
    var html = '<table width="100%">';
    
    $.ajax({
        type: "POST",
        url: controlador,
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "Detalhar", GRU_ID: grupoID}
    })
    .done(function( data ) {        
         $("#dialog-detalhe").html(data.html);
    });
    
    html += '</table>';
    $('#dialog-detalhe').dialog("open");
    preLoadingClose();
}