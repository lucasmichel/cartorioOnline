/* codificação utf-8 */
// seta o focus no elemento informado
function focus(elementoID){    
    $("#" + elementoID).focus(0.5);
    $("#" + elementoID).addClass("focus");    
}
function fimFocus(elementoID){    
    $("#" + elementoID).removeClass("focus");  
}

// função que permite ir para o elemento que desejar ao precionar ENTER
function proximoENTER(e, campo){
    if (e.keyCode == 13){
        campo.focus();
    }	
}

// inicia a tela de preloading
function preLoadingOpen(texto){
    var textoPreloading = "<h1 style='color: #FFFFFF;'>Processando, aguarde...</h1>";
    
    if($.trim(texto) != null){
        if($.trim(texto) != ""){
            textoPreloading = "<h1 style='color: #FFFFFF;'>" + texto + "</h1>";
        }
    }
    
    $.blockUI({ message: textoPreloading, css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
}

// fecha a tela de preloading
function preLoadingClose(){
    $.unblockUI(); 
}

function atualizarBarraNavegacao(div, tela){
    $("#" + div).html("");
    $("#" + div).load(tela);
}

function exibirTela(div, tela){
    $("#" + div).html("<center><img src='img/loading-grey.gif' style='margin-top: 180px;'></center>");
    $("#" + div).load(tela);    
}

function imprimir(div){
    $('#' + div).printThis();
}

function checarPermissao(acao, formularioID, formularioAcao){  
    var permissao;
    
    $.ajax({
        type: "POST",
        url: "../gerencial/controladores/PermissaoControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: acao, FRM_ID: formularioID, FRM_Acao: formularioAcao}
    })
    .done(function( data ) {        
         permissao = data;
    });
    
    return permissao;
}