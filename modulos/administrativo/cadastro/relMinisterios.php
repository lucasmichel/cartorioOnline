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
        
        function getMinisterios(){    
            var AMI_ID;    
            if($('#selPesquisaAreaMinisterial').val()> 0){
                AMI_ID = $('#selPesquisaAreaMinisterial').val();
            }else{
                AMI_ID = " IS NULL ";
            }
            $.ajax({
                type: "POST",
                url: "../../administrativo/cadastro/controladores/MinisterioControlador.php",
                dataType: "json",
                async: false,
                data: {ACO_Descricao: "Consultar", MIN_Status: "A", AMI_ID: AMI_ID}
            })
            .done(function( data ) {
                $("#selPesquisaMinisterio").html("<option value=''></option>");        
                if(data.sucesso == "true"){
                    var html = '<option value=""></option>';            
                    for(var i=0; i<data.rows.length; i++){
                        html += '<option value="' + data.rows[i].MIN_ID + '">' + data.rows[i].MIN_Descricao + '</option>';
                    }            
                    $("#selPesquisaMinisterio").html(html);
                    $("#selPesquisaMinisterio").trigger('chosen:updated');
                }else{
                    $("#selPesquisaMinisterio").html(html);
                    $("#selPesquisaMinisterio").trigger('chosen:updated');
                }
            });
        }
        
        function gerar(){
            var MIN_ID = $("#selPesquisaMinisterio").val();
            var AMI_ID = $("#selPesquisaAreaMinisterial").val();
            
            preLoadingOpen("Processando solicitação, aguarde...");
            
            $.post("../../administrativo/cadastro/controladores/RelatorioControlador.php", {
                ACO_Descricao: "Ministerios", 
                MIN_ID: MIN_ID,
                AMI_ID: AMI_ID
                
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
            <li><a href="#tabs-1">Relat&oacute;rio de Ministérios</a></li>            
        </ul>
        <div id="tabs-1">
            <div>
                <form>                                   
                    <fieldset class="linha">
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selPesquisaAreaMinisterial">Área Ministerial</label>                                
                                <select data-placeholder="TODAS" style="width:350px;" class="chosen-select-deselect" id="selPesquisaAreaMinisterial" name="AMI_ID" onchange="getMinisterios();">                                
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros["AMI_Status"] = "A";
                                        $arrObjFaixa  = FachadaCadastro::getInstance()->consultarAreaMinisterial($arrStrFiltros);
                                        if($arrObjFaixa != null){
                                            $arrObj = $arrObjFaixa["objects"];
                                            for($intI=0; $intI<count($arrObj); $intI++){
                                               echo '<option value="'. $arrObj[$intI]->getId().'">'.$arrObj[$intI]->getDescricao().'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </fieldset>                        
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                            <label for="selPesquisaMinisterio">Ministério</label>                                
                                <select data-placeholder="TODOS" style="width:350px;" class="chosen-select-deselect" id="selPesquisaMinisterio"  name="MIN_ID">
                                    <option value=""></option>
                                    <?php
                                        $arrStrFiltros = array();
                                        $arrStrFiltros["MIN_Status"] = "A";
                                        $arrObjs  = FachadaCadastro::getInstance()->consultarMinisterio($arrStrFiltros);
                                        
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