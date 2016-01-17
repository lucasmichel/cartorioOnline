// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val(); 
var controlador  = "../../administrativo/cadastro/controladores/MembroControlador.php";

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
}

function gerar(){
    var PES_ID = $("#selMembro").val(); 
    
    if(PES_ID > 0){                 
        $.post(controlador, {
            ACO_Descricao: "VerificarBatismo", 
            PES_ID: PES_ID
        },
            function(data) {    

                if(data.sucesso == "true"){                
                    var url = "../../administrativo/cadastro/documentos/CertificadoBatismo.php?PES_ID=" + PES_ID;
                    popUpCentralizado(url, 842, 595);               
                }else{

                    $("#dialog-atencao").html("Membro ainda não batizado");
                    $("#dialog-atencao").dialog("open");
                }

            },"json"
        );        
    }else{
        $("#dialog-atencao").html("Por favor, selecione o membro que deseja imprimir o certificado.");
        $("#dialog-atencao").dialog("open");
    }  
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