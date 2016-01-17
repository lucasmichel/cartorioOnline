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
                exportPdf("Rel_Balancete_Financeiro", "relatorio", "L");
            });
        }
        
        //para o autocomplete
        function gerar(){
            preLoadingOpen("Gerando relatório, aguarde...");
            
            $.post("../../administrativo/financeiro/controladores/RelatorioControlador.php", {
                ACO_Descricao: "BalanceteFinanceiro",                
                BAL_Mes: $("#selMes").val(),
                BAL_MesDescricao: $("#selMes option:selected").text(),
                BAL_Ano: $("#selAno").val()
            },
                function(data){
                    //alert(data);return;
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
            <li><a href="#tabs-1">Balancete Financeiro</a></li>            
        </ul>
        <div id="tabs-1">
            <div style="margin-bottom: 20px;">                
                <form>  
                    <fieldset class="coluna">
                        <label>Mês</label>
                        <?php
                            echo MesSelectComponente::getInstance()->gerar("selMes", "BAL_Mes", date("m"));
                        ?>
                    </fieldset>
                    <fieldset class="coluna">
                        <label>Ano</label>
                        <?php
                            echo AnoSelectComponente::getInstance()->gerar("selAno", "BAL_Ano", date("Y"));
                        ?>
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