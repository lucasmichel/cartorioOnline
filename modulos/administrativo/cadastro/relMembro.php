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
            var MES_ID     = $("#selPesquisaStatus").val();    
            var PES_Sexo   = $("#selPesquisaSexo").val();    
            var NES_ID     = $("#selPesquisaNivelEscolaridade").val();    
            var ECV_ID     = $("#selPesquisaEstadoCivil").val();  
            var UNI_ID     = $("#selPesquisaUnidade").val();
            var MEM_Tipo = $("#selTipo").val();            
            var MEM_MaiorMenor = $("#selPesquisaMaiorMenor").val();
            var PES_Idade = $("#selPesquisaIdade").val();
            
            //preLoadingOpen("Processando solicitação, aguarde...");
            
            $.post("../../administrativo/cadastro/controladores/RelatorioControlador.php", {
                ACO_Descricao: "MembroGeral", 
                MES_ID: MES_ID,                
                PES_Sexo: PES_Sexo,
                NES_ID: NES_ID,
                ECV_ID: ECV_ID,
                UNI_ID: UNI_ID,
                MEM_Tipo: MEM_Tipo,
                MaiorMenor: MEM_MaiorMenor,
                PES_Idade: PES_Idade
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
            <li><a href="#tabs-1">Relat&oacute;rio Geral de Membros</a></li>            
        </ul>
        <div id="tabs-1">
            <div>
                <form>
                                   
                    <fieldset class="linha"> 
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selPesquisaSexo">Sexo</label>                                
                                <select data-placeholder="TODOS" style="width:150px;" class="chosen-select-deselect" id="selPesquisaSexo">                                    
                                    <option value=""></option>
                                    <option value="M">MASCULINO</option>
                                    <option value="F">FEMININO</option>
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
                                <label for="selPesquisaStatus">Status do Membro</label>                                
                                <select data-placeholder="TODOS" class="chosen-select-deselect" id="selPesquisaStatus" style="width:200px;">                                    
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
                                <label for="selPesquisaUnidade">Unidade (Matriz / Congrega&ccedil;&atilde;o)</label>                                
                                <select data-placeholder="TODAS" style="width:280px;" class="chosen-select-deselect" id="selPesquisaUnidade"  name="UNI_ID">
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
                                <label for="selPesquisaMaiorMenor">Maior / Menor</label>                                
                                <select data-placeholder="TODOS" style="width:280px;" class="chosen-select-deselect" id="selPesquisaMaiorMenor" >                                    
                                    <option value=""></option>                                    
                                    <option value="MAIOR">MAIOR</option>
                                    <option value="MENOR">MENOR</option>
                                    
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="coluna">
                            <div class="side-by-side clearfix">
                                <label for="selPesquisaIdade">Idade</label>                                
                                <select data-placeholder="TODAS" style="width:280px;" class="chosen-select-deselect" id="selPesquisaIdade" >                                    
                                    <option value="" ></option>
                                    <option value="02" >02</option>
                                    <option value="04" >04</option>
                                    <option value="06" >06</option>
                                    <option value="08" >08</option>
                                    <option value="10" >10</option>
                                    <option value="15" >15</option>
                                    <option value="20" >20</option>
                                    <option value="25" >25</option>
                                    <option value="30" >30</option>                                    
                                    <option value="35" >35</option>                                    
                                    <option value="40" >40</option>                                    
                                    <option value="45" >45</option>                                    
                                    <option value="50" >50</option>                                    
                                    <option value="55" >55</option>                                    
                                    <option value="60" >60</option>                                    
                                    <option value="65" >65</option>                                    
                                    <option value="70" >70</option>                                    
                                    <option value="75" >75</option>                                    
                                    <option value="80" >80</option>                                    
                                    <option value="85" >85</option>                                    
                                    <option value="90" >90</option>                                    
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