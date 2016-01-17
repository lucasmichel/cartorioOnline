<?php
    // codificação UTF-8    
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../livroRegistro/relatorios";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/resumo.js"></script> 
</head>
<body> 
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Resumo</a></li>            
        </ul>
        <div id="tabs-1">
            
            <form id="frmPesquisa" onSubmit="return false;">                
                <fieldset class="coluna"></fieldset>
                
                <fieldset class="coluna">
                    <div class="side-by-side clearfix">
                        <label for="selTipoFiltro">Filtrar por:</label>                                
                        <select data-placeholder="SELECIONE O TIPO DE FILTRO" style="width:250px;" class="chosen-select-deselect" id="selTipoFiltro">
                            <option value="linha" selected="true" >Linha</option>
                            <option value="livro">Livro</option>
                            <option value="folha">Folha</option>
                            
                        </select>
                    </div>
                </fieldset>
                <fieldset class="coluna">
                    <label for="txtDataInicio">Data inicial:</label>
                    <input type="text" id="txtDataInicio" class="campoData" placeholder="__/__/____" style="width: 75px;" value="<?php echo date("01/m/Y");?>"/>
                </fieldset>
                <fieldset class="coluna">
                    <label for="txtDataFim">Data final:</label>
                    <input type="text" id="txtDataFim" class="campoData" placeholder="__/__/____" style="width: 75px;" value="<?php echo date("d/m/Y");?>"/>
                </fieldset>
                <fieldset class="coluna">
                    <input type="button" value="Filtrar" onclick="gerarGrafico();" class="botao"/>
                </fieldset>
                
            </form>
            <?php
                // exportacao de conteúdo
                //include("../../sistema/gerencial/inc/export.inc.php");  
            ?>
            
            <div id="relatorio" style="margin-top: 10px; width: 100%; height: 400px;" >
                
                <div id="graficoReceita" style="min-width: 310px; height: 50%; max-width: 100%; margin: 0 auto">
                    Carregando...
                </div>               
                <div id="graficoDespesa" style="min-width: 310px; height: 50%; max-width: 100%; margin: 0 auto; margin-top: 10px;">
                    Carregando...
                </div>             
            </div>
        </div>
    </div>
    <script type="text/javascript">
        init();
    </script>
</body>
</html>