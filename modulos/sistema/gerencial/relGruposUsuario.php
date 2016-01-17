<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title> 
    <script type="text/javascript">
        function init(){
            // tabs
            $('#tabs').tabs();
            $('#divexport').hide();
            $("#txtDataAcessoInicio").mask("99/99/9999");
            $("#txtDataAcessoInicio").datepicker();
            $("#txtDataAcessoFim").mask("99/99/9999");
            $("#txtDataAcessoFim").datepicker();
            
            $("#btnExportPrint" ).click(function() {
                exportImprimir("relatorio");
            });

            $("#btnExportExcel" ).click(function() {
                exportExcel("tableRelatorio");
            });

            $("#btnExportPdf" ).click(function() {
                exportPdf("Rel_Patrimonial", "relatorio", "P");
            });            
         }
         
         
        
        function gerar(){
            preLoadingOpen("Processando solicitação, aguarde...");
            $.post("../../sistema/gerencial/controladores/RelatorioControlador.php", {
                ACO_Descricao: "RelatorioGruposUsuario"
            },
                function(data){  
                    if(data.sucesso == "true"){
                        $('#divexport').show();                        
                        $("#relatorio").html(data.relatorio);
                    }

                    preLoadingClose();
                }, "json"
            );
            
        }
    </script>
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Relat&oacute;rio de Grupos de Usuários</a></li>            
        </ul>
        <div id="tabs-1">
            <div style="margin-bottom: 10px;">                
                <form id="frmPesquisa" onSubmit="return false;">                      
                    <fieldset class="coluna">
                        <input type="button" value="Gerar" onclick="gerar();" class="botao"/>
                    </fieldset>  
                </form>
            </div>
            <?php
                // exportacao de conteúdo
                include("../../sistema/gerencial/inc/export.inc.php");  
            ?>
            <div id="relatorio"></div>
        </div>             
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>