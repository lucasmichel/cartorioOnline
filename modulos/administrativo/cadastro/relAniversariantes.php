<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");
    
    $strDir = "../../administrativo/cadastro";
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo SISTEMA_TITULO; ?></title> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
                exportPdf("Rel_Aniversariantes", "relatorio", "L");
            });
        }

        function gerar(){ 
            var PES_MesAniversario = $("#selMesPesquisa").val();
            var UNI_ID = $("#selUnidadePesquisa").val(); 
            var MES_ID = $("#selStatusPesquisa").val();
            var MEM_Tipo = $("#selTipo").val();            
            
            preLoadingOpen("Gerando relatório, aguarde...");

            $.post("../../administrativo/cadastro/controladores/RelatorioControlador.php", 
            {
                ACO_Descricao: "AniversariantesPorMes", 
                PES_MesAniversario: PES_MesAniversario,
                UNI_ID: UNI_ID,
                MES_ID: MES_ID,
                UNI_Descricao: $("#selUnidadePesquisa option:selected").text(),
                MES_Descricao: $("#selStatusPesquisa option:selected").text(),
                MEM_Tipo: MEM_Tipo
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
            <li><a href="#tabs-1">Relat&oacute;rio de Aniversariantes por Mês</a></li>            
        </ul>
        <div id="tabs-1">
            <div>
                <form>  
                    <fieldset class="linha">
                        <fieldset class="coluna">                                    
                            <label for="selMesPesquisa">M&ecirc;s</label>                                    
                            <?php echo MesSelectComponente::getInstance()->gerar("selMesPesquisa", "", date("m"));?>
                        </fieldset>
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selUnidadePesquisa">Unidade (Matriz / Congrega&ccedil;&atilde;o)</label>                                
                                <select data-placeholder="TODAS" style="width:280px;" class="chosen-select-deselect" id="selUnidadePesquisa">                                    
                                    <option value=""></option>
                                    <option value="SEDE">SEDE</option>
                                    <?php
                                        $arrStrFiltros = array();
                                        $arrStrFiltros["UNI_Status"] = "A";
                                        $arrObjs  = FachadaCadastro::getInstance()->consultarCongregacao($arrStrFiltros);
                                        
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
                                <label for="selTipo">Tipo</label>                                
                                <select data-placeholder="SELECIONE O TIPO." style="width:200px;" class="chosen-select-deselect" id="selTipo">
                                    <option value="CONGREGADO">CONGREGADO</option>
                                    <option value="INATIVO">INATIVO</option>
                                    <option value="MEMBRO" selected>MEMBRO</option>
                                    <option value="VISITANTE">VISITANTE</option>
                                </select>
                            </div>
                        </fieldset>
                        
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selStatusPesquisa">Status do Membro</label>                                
                                <select data-placeholder="TODOS" class="chosen-select-deselect" id="selStatusPesquisa" style="width:200px;" >                                    
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros = array();
                                        $arrStrFiltros["MES_Status"] = "A";
                                        $arrObjs  = FachadaCadastro::getInstance()->consultarStatusMembro($arrStrFiltros);
                                        
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