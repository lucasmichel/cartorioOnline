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
            var PES_Status = $("#selPesquisaStatus").val();    
            var PES_Sexo   = $("#selPesquisaSexo").val();    
            var NES_ID     = $("#selPesquisaNivelEscolaridade").val();    
            var ECV_ID     = $("#selPesquisaEstadoCivil").val();
            
            preLoadingOpen("Processando solicitação, aguarde...");
            
            $.post("../../administrativo/cadastro/controladores/RelatorioControlador.php", {
                ACO_Descricao: "FuncionarioGeral", 
                PES_Status: PES_Status,                
                PES_Sexo: PES_Sexo,
                NES_ID: NES_ID,
                ECV_ID: ECV_ID
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
            <li><a href="#tabs-1">Relat&oacute;rio de Funcionários</a></li>            
        </ul>
        <div id="tabs-1">
            <div>
                <form>
                                   
                    <fieldset class="linha"> 
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selPesquisaSexo">Sexo</label>                                
                                <select data-placeholder="TODOS" class="chosen-select-deselect" id="selPesquisaSexo">                                    
                                    <option value=""></option>
                                    <option value="M">MASCULINO</option>
                                    <option value="F">FEMININO</option>
                                </select>
                            </div>
                        </fieldset>                        
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                            <label for="selPesquisaNivelEscolaridade">Nível de escolaridade</label>                                
                                <select data-placeholder="TODOS" style="width:200px;" class="chosen-select-deselect"  id="selPesquisaNivelEscolaridade"  name="NES_ID">
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros = array();
                                        $arrStrFiltros["NES_Status"] = "A";
                                        $arrObjs  = FachadaCadastro::getInstance()->consultarNivelEscolaridade($arrStrFiltros);
                                        
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
                            <label for="selPesquisaEstadoCivil">Estado civil</label>                                
                                <select data-placeholder="TODOS" style="width:280px;" class="chosen-select-deselect" id="selPesquisaEstadoCivil"  name="ECV_ID">
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros = array();
                                        $arrStrFiltros["ECV_Status"] = "A";
                                        $arrObjs  = FachadaCadastro::getInstance()->consultarEstadoCivil($arrStrFiltros);
                                        
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
                                    <label for="selPesquisaStatus">Status</label>                                
                                    <select data-placeholder="TODOS" class="chosen-select-deselect" id="selPesquisaStatus" style="width: 100px;">                                    
                                        <option value=""></option>
                                        <option value="A">ATIVO</option>
                                        <option value="I">INATIVO</option>
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