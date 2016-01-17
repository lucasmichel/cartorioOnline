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
                exportPdf("Rel_Patrimonial", "relatorio", "L");
            });            
         }
         
         
         function consultarItens(grupoID, subgrupoID){    
            var grupoID = $("#" + grupoID).val();

            if(grupoID == ""){
                $("#" + subgrupoID).html("<option value=''>SELECIONE</option>");
            }else{    
                preLoadingOpen("Carregando subgrupos, aguarde...");

                $("#" + subgrupoID).html("<option value=''>SELECIONE</option>");

                $.ajax({
                    type: "POST",
                    url: "../../administrativo/patrimonio/controladores/ItemPatrimonioControlador.php",
                    dataType: "json",
                    async: false,
                    data: {ACO_Descricao: "Consultar", TIP_ID: grupoID}
                })
                .done(function( data ) {            
                     if(data.sucesso == "true"){                
                        for(var i=0; i<data.rows.length; i++){
                            $("#" + subgrupoID).append('<option value="' + data.rows[i].IPT_ID + '">' + data.rows[i].IPT_Descricao + '</option>');
                        }                
                    }
                });

                preLoadingClose();
            }
        }
         
        
        function gerar(){
            var pesquisaCondicao  = $("#selPesquisaCondicao").val();
            var pesquisaTipo      = $("#selPesquisaTipo").val();              
            var pesquisaItem      = $("#selPesquisaItem").val();
            var pesquisaDescricao = $("#txtPesquisaDescricao").val();  

            $("#ckbSintetico").val("A");
            if($("#ckbSintetico").is(":checked")) $("#ckbSintetico").val("S");  
            
            preLoadingOpen("Processando solicitação, aguarde...");
            
            if($("#ckbSintetico").val()=="A"){
                $.post("../../administrativo/patrimonio/controladores/RelatorioControlador.php", {
                    ACO_Descricao: "Analitico",                    
                    PTM_Condicao: pesquisaCondicao,
                    TIP_ID: pesquisaTipo,
                    PTM_Descricao: pesquisaDescricao,
                    IPT_ID: pesquisaItem
                },
                    function(data){  
                        if(data.sucesso == "true"){
                            $('#divexport').show();
                            $("#relatorio").html(data.relatorio);
                        }

                        preLoadingClose();
                    }, "json"
                );
            }else{
                $.post("../../administrativo/patrimonio/controladores/RelatorioControlador.php", {
                    ACO_Descricao: "Sintetico",                    
                    PTM_Condicao: pesquisaCondicao,
                    TIP_ID: pesquisaTipo,
                    PTM_Descricao: pesquisaDescricao,
                    IPT_ID: pesquisaItem
                },
                    function(data){ 
                        //alert(data);return;
                        if(data.sucesso == "true"){
                            $('#divexport').show();
                            $("#relatorio").html(data.relatorio);
                        }

                        preLoadingClose();
                    }, "json"
                );            
            }
        }
    </script>
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Relat&oacute;rio Patrimonial</a></li>            
        </ul>
        <div id="tabs-1">
            <div style="margin-bottom: 10px;">
                <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
                <form id="frmPesquisa" onSubmit="return false;">  
                    <fieldset class="coluna">
                        <label for="selPesquisaTipo">Grupo</label>
                        <select id="selPesquisaTipo" class="campoSelect" style="width: 200px;" onchange="consultarItens('selPesquisaTipo', 'selPesquisaItem');">
                            <option value="">TODOS</option>
                            <?php
                                $arrStrFiltros               = array();                                
                                $arrStrFiltros["TIP_Status"] = "A";
                                $arrObjTiposPatrimonios        = null;    
                                $arrObjTiposPatrimonios        = FachadaPatrimonio::getInstance()->consultarTipoPatrimonio($arrStrFiltros);
                                $arrObjTiposPatrimonios = $arrObjTiposPatrimonios["objects"];
                                if($arrObjTiposPatrimonios != null){
                                    if(count($arrObjTiposPatrimonios) > 0){
                                        $strHtml = "";
                                        for($intI=0; $intI<count($arrObjTiposPatrimonios); $intI++){
                                            $strHtml .= '<option value="'.$arrObjTiposPatrimonios[$intI]->getId().'">'.html_entity_decode($arrObjTiposPatrimonios[$intI]->getDescricao()).'</option>';
                                        }
                                        echo $strHtml;
                                    }
                                }
                            ?>
                        </select>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaItem">Subgrupo</label>                                
                        <select id="selPesquisaItem" name="ITP_ID" class="campoSelect" style="width: 200px;">
                            <option value="">SELECIONE</option>
                        </select>
                    </fieldset>
                    <fieldset class="coluna">                        
                        <label for="txtPesquisaDescricao">Descrição</label>
                        <input type="text" id="txtPesquisaDescricao" name="" class="campoTextoPadrao" value=""  style="width: 300px; "/>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaCondicao">Condi&ccedil;&atilde;o</label>
                        <select id="selPesquisaCondicao" name="PTM_Condicao" class="campoSelect" style="width: 200px;" >
                            <option value="">TODOS</option>
                            <option value="NOVO">NOVO</option>
                            <option value="BOM">BOM</option>
                            <option value="REGULAR">REGULAR</option>
                            <option value="RUIM">RUIM</option>
                        </select>
                    </fieldset>
                    <fieldset class="coluna">
                        <input type="button" value="Gerar" onclick="gerar();" class="botao"/>
                    </fieldset>
                    
                    <fieldset class="linha">
                        <input type="checkbox" id="ckbSintetico"  class="botao"/>Sintético
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