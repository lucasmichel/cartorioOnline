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
        //para o autocomplete
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, não encontrado!'},
            '.chosen-select-width'     : {width:"95%"}
        };
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
        //para o autocomplete

        
        function init(){
            // tabs
            $('#tabs').tabs();
            $("#divexport").hide();
            
            $('#txtPesquisaDataInicial').datepicker();
            $('#txtPesquisaDataInicial').mask("99/99/9999");
            
            $('#txtPesquisaDataFinal').datepicker();
            $('#txtPesquisaDataFinal').mask("99/99/9999");
            
            $("#btnExportPrint" ).click(function() {
                exportImprimir("relatorio");
            });

            $("#btnExportExcel" ).click(function() {
                exportExcel("tableRelatorio");
            });

            $("#btnExportPdf" ).click(function() {
                exportPdf("Rel_Lista_Membros", "relatorio", "L");
            });
        }
        
        function gerar(){
            var ATV_ID = $("#selPesquisaAtividade").val();
            var PES_ID = $("#selPesquisaMembros").val();
            
            var ATM_Desde = $("#txtPesquisaDataInicial").val();
            var ATM_Ate = $("#txtPesquisaDataFinal").val();
            
             
            
            preLoadingOpen("Processando solicitação, aguarde...");
            
            $.post("../../administrativo/cadastro/controladores/RelatorioControlador.php", {
                ACO_Descricao: "MembrosAtividades", 
                ATV_ID: ATV_ID,
                PES_ID: PES_ID,
                ATM_Desde: ATM_Desde,
                ATM_Ate: ATM_Ate
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
            <li><a href="#tabs-1">Relat&oacute;rio de Membros por Atividade</a></li>            
        </ul>
        <div id="tabs-1">
            <div>
                <form>
                                   
                    <fieldset class="linha"> 
                        
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                            <label for="selPesquisaAtividade">Atividades</label>                                
                                <select data-placeholder="TODOS" style="width:280px;" class="chosen-select-deselect" id="selPesquisaAtividade"  name="MIN_ID">
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros = array();
                                        $arrStrFiltros["ATV_Status"] = "A";
                                        $arrObjs  = FachadaCadastro::getInstance()->consultarAtividade($arrStrFiltros);
                                        
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
                            <div class="side-by-side clearfix">
                            <label for="selPesquisaMembros">Membros</label>                                
                                <select data-placeholder="TODOS" style="width:280px;" class="chosen-select-deselect" id="selPesquisaMembros"  name="PES_ID">
                                    <option value=""></option>
                                    <?php
                                        //$arrStrFiltros = array();
                                        //$arrStrFiltros["PES_Status"] = "A";
                                        $arrObjs  = FachadaCadastro::getInstance()->consultarMembro(null);                                        
                                        if($arrObjs != null){
                                            $arrObjs = $arrObjs["objects"];                                                
                                            for($intI=0; $intI<count($arrObjs); $intI++){
                                               echo '<option value="'. $arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getNome().'</option>';
                                            }
                                        }
                                    ?> 
                                </select>
                            </div>
                        </fieldset>
                        
                        <fieldset class="coluna">
                            <label for="txtPesquisaDataInicial">De</label>
                            <input id="txtPesquisaDataInicial" class="campoTextoPadrao" value="<?php echo date("01/01/Y"); ?>" type="text" value="01/10/2014" placeholder="__/__/____">
                        </fieldset>
                        <fieldset class="coluna">
                            <label for="txtPesquisaDataFinal">Até</label>
                            <input id="txtPesquisaDataFinal" class="campoTextoPadrao" value="<?php echo date("d/m/Y"); ?>" type="text" placeholder="__/__/____">
                        </fieldset>
                        <fieldset class="coluna">
                            <input type="button" value="Gerar" onclick="gerar();" class="botao"/>
                        </fieldset>
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