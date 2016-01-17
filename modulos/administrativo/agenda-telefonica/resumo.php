<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");
    include("../../sistema/gerencial/inc/seguranca.inc.php");
    include("inc/autoload.inc.php");
    
    $strDir = "../../administrativo/agenda-telefonica"; 
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
            <li><a href="#tabs-1">Agenda Eletrônica</a></li>
        </ul>
        <div id="tabs-1">
            <?php
                // exportacao de conteúdo
                include("../../sistema/gerencial/inc/export.inc.php");  
            ?>
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
            </div><!-- dialogs --> 
            <form onSubmit="return false;">                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="txtPesquisaNome">Informe o nome</label>
                        <input type="text" id="txtPesquisaNome" class="campoTextoPadrao" placeholder="INFORME O NOME DESEJADO." style="width: 300px;"/>
                    </fieldset>
                    
                    <fieldset class="coluna">                        
                        <div class="side-by-side clearfix">                            
                            <label for="selPesquisaTipo">Tipo</label>
                            <select style="width:300px;" class="chosen-select-deselect"  id="selPesquisaTipo">
                                <option value="" selected>SELECIONE O TIPO.</option>
                                <option value="MEMBRO">MEMBRO</option>
                                <option value="FORNECEDOR">FORNECEDOR</option>
                                <option value="FUNCIONARIO">FUNCIONÁRIO</option>                                    
                            </select>
                        </div>                                       
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <input type="button" class="botao" value="Consultar" onclick="gerar();"/>
                    </fieldset>
                    
                </fieldset>
            </form>
            <div style="margin-top: 20px;" id="relatorio">                
            </div> 
        </div>
    </div>
    <script type="text/javascript">
        init();
    </script>
</body>
</html>