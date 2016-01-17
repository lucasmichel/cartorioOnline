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
            $("#btnExportPrint" ).click(function() {
                exportImprimir("relatorio");
            });
            $("#btnExportExcel" ).click(function() {
                exportExcel("tableRelatorio");
            });
            $("#btnExportPdf" ).click(function() {
                exportPdf("Rel_Fornecedores", "relatorio", "L");
            });
        }
        
        function gerar(){
            var pesquisaTipo = $("#selPesquisaTipo").val();            
            preLoadingOpen("Processando solicitação, aguarde...");            
            $.post("../../administrativo/financeiro/controladores/RelatorioControlador.php", {
                ACO_Descricao: "Fornecedor", 
                FOR_Tipo: pesquisaTipo
            },
                function(data){                    
                    if(data.sucesso == "true"){                           
                        $("#relatorio").html(data.relatorio);
                        $('#divexport').show();
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
            <li><a href="#tabs-1">Relat&oacute;rio de Fornecedores</a></li>            
        </ul>
        <div id="tabs-1">
            <div style="margin-bottom: 20px;">
                <form> 
                    <fieldset class="coluna">
                        <label for="selPesquisaTipo">Tipo</label>
                        <select id="selPesquisaTipo" class="campoSelect">                            
                            <option value="" selected>TODOS</option>
                            <option value="PF">PESSOA FISICA</option>
                            <option value="PJ">PESSOA JURIDICA</option>  
                        </select>                    
                    </fieldset>
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