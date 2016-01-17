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
            
            $("#txtPesquisaDataInicial").mask("99/99/9999");
            $("#txtPesquisaDataInicial").datepicker();
            
            $("#txtPesquisaDataFinal").mask("99/99/9999");
            $("#txtPesquisaDataFinal").datepicker(); 
            
            $("#btnExportPrint" ).click(function() {
                exportImprimir("relatorio");
            });

            $("#btnExportExcel" ).click(function() {
                exportExcel("tableRelatorio");
            });

            $("#btnExportPdf" ).click(function() {
                exportPdf("Rel_Acumlulado_Por_CentroCusto", "relatorio", "L");
            });
        }
        
        //para o autocomplete
        function gerar(){
            var dataInicial     = $("#txtPesquisaDataInicial").val();
            var dataFinal       = $("#txtPesquisaDataFinal").val();
            var centroDeCusto   = $("#selCentroCustoPesquisa").val();
            preLoadingOpen("Gerando relatório, aguarde...");
            $.post("../../administrativo/financeiro/controladores/RelatorioControlador.php", {
                ACO_Descricao: "AcumuladoPorCentroCusto",                
                LCA_DataInicial: dataInicial,
                LCA_DataFinal: dataFinal,
                CEN_ID: centroDeCusto
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
        
    </script>
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Relat&oacute;rio Acumulado por Centro de Custo</a></li>            
        </ul>
        <div id="tabs-1">
            <div style="margin-bottom: 20px;">                
                <form>  
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataInicial">De</label>
                        <input type="text" id="txtPesquisaDataInicial" placeholder="__/__/____" class="campoTextoPadrao" value="<?php echo date("01/m/Y");?>"/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaDataFinal">At&eacute;</label>
                        <input type="text" id="txtPesquisaDataFinal" placeholder="__/__/____" class="campoTextoPadrao" value="<?php echo date("d/m/Y");?>"/>
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                            <label for="selCentroCustoPesquisa">Centro de Custo</label>                                
                            <select data-placeholder="SELECIONE O CENTRO DE CUSTO." style="width:215px;" class="chosen-select-deselect" id="selCentroCustoPesquisa"  >                                
                                <option value="0" selected="true">TODOS</option>
                                <?php
                                    $arrStrFiltros["CEN_Status"] = "A";
                                    $arrObjs  = FachadaFinanceiro::getInstance()->consultarCentroCusto($arrStrFiltros);
                                    if($arrObjs != null){
                                        $arrObjs = $arrObjs["objects"];                                                
                                        for($intI=0; $intI<count($arrObjs); $intI++){
                                           echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
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