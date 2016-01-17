// codificação utf-8
// código do formulário para poder checar as permissões
var formularioID = $("#hddFormularioID").val();
var controlador  = "../../livroRegistro/grafico-impressao/controladores/PrintLivroPrevioControlador.php";
var controladorFolha  = "../../livroRegistro/livro-previo/controladores/FolhaPrevioControlador.php";
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

                var html = '<option value="">TODAS</option>';
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


function pesquisar(){    
    var LIP_ID = $('#selLivroPesquisa').val();
    var FPR_ID = $('#selFolhaPesquisa').val();
    
    
    $.post(controlador, {
        ACO_Descricao: "Consultar",
        LIP_ID: LIP_ID,
        FPR_ID: FPR_ID
    },
        function(data){   
            
            var html = '';

            if(data.sucesso == "true"){
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                    html += '<tr>';
                        html += '<td>';
                            html += 'CARTORIO ÚNICO DE NOTAS E REGISTROS<br>Comarca do MORENO-PE';
                        html += '</td>';
                    html += '</tr>';
                    
                    html += '<tr>';
                        html += '<td>';
                            html += 'Livro nº: 3 de registros Prévios';
                        html += '</td>';
                    html += '</tr>';
                    
                html += '</table>';
                
                
                
                html += '<table class="dadosTabela" border="1px" cellpadding="5" cellspacing="0" width="100%">';
                
                
                
                
                    html += '<tr class="cabecalhoTabela">';
                        html += '<td width="300px">Área Ministerial</td>';
                        html += '<td width="300px">Ministerio</td>';
                        html += '<td width="150px">Desde</td>';                                
                        html += '<td width="150px">Até</td>';                                
                        html += '<td align="center" width="40px">Ações</td>'; 
                    html += '</tr>';
                var classDif = '';
                for(var i=0; i<data.rows.length; i++){
                    classDif = 'class="linhaNormal"';
                    if(i%2 == 0){
                        classDif = 'class="linhaCor"';
                    }
                    //remove o membro primario do select                
                    /*$("#selMembroSecundario").find('[value="'+data.rows[i].PES_Secundario_ID+'"]').remove();
                    $("#selMembroSecundario").val("");
                    $("#selMembroSecundario").trigger('chosen:updated');*/                    
                    html += '<tr ' + classDif +'>';
                        html += '<td>' + data.rows[i].AMI_Descricao + '</td>';
                        html += '<td>' + data.rows[i].MIN_Descricao + '</td>';
                        html += '<td>' + data.rows[i].MMI_Desde + '</td>';
                        if(data.rows[i].MMI_Ate ==  null ){
                            html += '<td> </td>';
                        }else{
                            html += '<td>' + data.rows[i].MMI_Ate + '</td>';                            
                        }
                        

                        html += '<td align="center">';
                            html += "<a href='javascript:void(0);' title='Editar: " + data.rows[i].MIN_Descricao + " '><img onclick='editarMinisterio(" + data.rows[i].ID + " );' class='btnEditarMinisterio' alt='editar' src='../../../modulos/sistema/home/img/botao-editar.png' border='0' width='11px' height='11px' /></a> &nbsp;&nbsp;&nbsp; ";
                            html += "<a href='javascript:void(0);' title='Remover: " + data.rows[i].MIN_Descricao + " '><img onclick='removerMinisterio(" + data.rows[i].ID + " );' class='btnExcluirMinisterio' alt='excluir' src='../../../modulos/sistema/home/img/botao-remover.png' border='0'/></a>  ";                            
                            
                        html += '</td>';                                
                    html += '</tr>';
                }                        
                html += '</table>';

            }else{
                html = '<p>';
                    html += 'Nenhuma ministério adicionado.';
                html += '<p>';
            }                    
            $("#div-grid-ministerio").html(html);

        }, "json"
    );
}