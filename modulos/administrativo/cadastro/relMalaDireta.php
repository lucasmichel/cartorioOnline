<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");
    include("../../sistema/home/inc/doc.inc.php");
    $strDir = "../../administrativo/cadastro";
?>
<!DOCTYPE html>
<html>
<head>    
    <title><?php echo SISTEMA_TITULO; ?></title> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/relMalaDireta.js"></script>
</head>
<body>    
    <div id="tabs">
    <ul>
        <li><a href="#tabs-1">Relat&oacute;rio de Mala Direta</a></li>            
    </ul>
    <div id="tabs-1" style="height: 500px;">
        <div id="print" >
            <form id="frmPesquisa" onSubmit="return false;"> 
                
                <fieldset class="linha" style="margin-bottom: 15px;">
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selMala">Assunto</label>                                
                            <select data-placeholder="TODOS" style="width:280px;" class="chosen-select-deselect"  id="selMala"  name="NES_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["MAD_ID"] = null;
                                    $arrObj = FachadaCadastro::getInstance()->consultarMalaDireta($arrStrFiltros);
                                    if($arrObj != null){
                                        $arrObj = $arrObj["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getAssunto()).'</option>';
                                        }
                                    }else{
                                        echo '<option value="">NENHUMA MALA DIRETA CADASTRADA</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset> 
                    <fieldset class="coluna">
                        <input type="button" value="Gerar" onclick="gerarGrafico();" class="botao"/>
                    </fieldset>
                </fieldset>
                
                
                <fieldset class="linha" style="margin-bottom: 15px;">
                    <fieldset class="coluna">
                        <a href="javascript: void(0);" onclick="imprimir('relatorio');"><img src="../../sistema/home/img/imprimir.png" width="24" height="24" border="0" alt="Imprimir" title="Imprimir" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp;
                    </fieldset>
                    <fieldset class="coluna">
                        <a href="javascript: void(0);" onclick="getDocument('pdf');"><img src="../../sistema/home/img/pdf.png" width="24" height="24" border="0" alt="Gerar PDF" title="Gerar PDF" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp;
                    </fieldset>
                    <fieldset class="coluna" >
                        <a href="javascript: void(0);" onclick="exportExcel();"><img src="../../sistema/home/img/xls.png" width="24" height="24" border="0" alt="Gerar EXCEL" title="Gerar EXCEL" align="absmiddle"  /></a>
                    </fieldset>                    
                </fieldset>
                
            </form>
        </div>
        <div id="relatorio">        
            <div style="min-width: 310px; height: 250px; max-width: 100%; margin: 0 auto; overflow: auto;">
                <div id="dados" ><b>Carregando...</b></div>
            </div>
        </div>
        <div id="dialogs">
                <div id="explorar-envio" title="Visualizar envio">
                    <div id="div-grid-explora-envio"></div>
                </div>
            </div><!-- dialogs --> 
    </div>            
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>