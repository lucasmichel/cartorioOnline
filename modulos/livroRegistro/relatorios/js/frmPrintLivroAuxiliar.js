// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val();
var controlador  = "../../livroRegistro/livro-auxiliar/controladores/LivroAuxiliarControlador.php";
var controladorFolha  = "../../livroRegistro/livro-auxiliar/controladores/FolhaAuxiliarControlador.php";
var dg           = $('#grid');

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

// inicialização
function init(){
    // cria as tabs
    $('#tabs').tabs();    
      
}

function preencheFolhaPesquisa(){
    var LIP_ID = $('#selLivroPesquisa').val();
    
    if(LIP_ID > 0){
        $("#selFolhaPesquisa").html("<option value=''>CARREGANDO...</option>");
        $("#selFolhaPesquisa").trigger('chosen:updated');

        $.ajax({
            type: "POST",
            url: controladorFolha,
            dataType: "json",
            async: false,
            data: {
                ACO_Descricao: "Consultar", 
                LIP_ID: LIP_ID
            }
        })
        .done(function( data ) {        
            if(data.sucesso == "true"){                

                var html = '<option value=""></option>';
                for(var i=0; i<data.rows.length; i++){ 
                    html += '<option value="' + data.rows[i].FPR_ID + '">' + data.rows[i].FPR_NumeroFolha+ '</option>';
                }
                $("#selFolhaPesquisa").html(html);
                $("#selFolhaPesquisa").trigger('chosen:updated');

            }else{
                //$("#fieldsetDataCasamento").hide();
                $("#selFolhaPesquisa").html("<option value=''></option>");
                $("#selFolhaPesquisa").trigger('chosen:updated');
            }
        });
    }else{
        $("#selFolhaPesquisa").html("<option value=''></option>");
        $("#selFolhaPesquisa").trigger('chosen:updated');
    }    
}