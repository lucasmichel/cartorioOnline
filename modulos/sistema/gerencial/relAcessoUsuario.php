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
                exportPdf("Rel_Patrimonial", "relatorio", "L");
            });            
         }
         
         
        
        function gerar(){
            var USA_DataHoraInicial  = $("#txtDataAcessoInicio").val();
            var USA_DataHoraFinal  = $("#txtDataAcessoFim").val();
            var USU_Status  = $("#selPesquisaStatus").val();
            
            preLoadingOpen("Processando solicitação, aguarde...");
            
            
            $.post("../../sistema/gerencial/controladores/RelatorioControlador.php", {
                ACO_Descricao: "RelatorioAcessoUsuario",                    
                USA_DataHoraInicial: USA_DataHoraInicial,
                USA_DataHoraFinal: USA_DataHoraFinal,
                USU_Status: USU_Status
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
            <li><a href="#tabs-1">Relat&oacute;rio de Usuários</a></li>            
        </ul>
        <div id="tabs-1">
            <div style="margin-bottom: 10px;">
                <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
                <form id="frmPesquisa" onSubmit="return false;">  
                    <fieldset class="coluna">
                        <label for="txtDataAcessoInicio">Data inicial de acesso</label>                        
                        <input type="text" id="txtDataAcessoInicio" name="USA_DataHoraInicio" class="campoData" placeholder="__/__/____" style="width: 120px;" />
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtDataAcessoFim">Data final de acesso</label>                                
                        <input type="text" id="txtDataAcessoFim" name="USA_DataHoraFim" class="campoData" placeholder="__/__/____" style="width: 120px;" />
                    </fieldset>                    
                    <fieldset class="coluna">
                        <label for="selPesquisaStatus">Ativo</label>
                        <select id="selPesquisaStatus" name="USU_Status" class="campoSelect" style="width: 200px;" >
                            <option value="A" selected>SIM</option>
                            <option value="I">NÃO</option>                            
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