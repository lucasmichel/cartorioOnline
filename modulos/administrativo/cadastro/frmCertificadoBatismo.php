<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/cadastro";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmCertificadoBatismo.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Certificado de Batismo</a></li>            
        </ul>        
        <div id="tabs-1">
            <div id="dialogs">
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
            </div><!-- dialogs -->            
            <form style=" height: 550px; " id="frmCadastro" onSubmit="return false;">                
                <fieldset class="linha"> 
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">                                        
                            <select data-placeholder="SELECIONE O MEMBRO" style="width:350px;" class="chosen-select-deselect" id="selMembro"  name="PES_Membro_ID"  >
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["PES_Status"] = "A";
                                    $arrStrFiltros["MembroNaoFuncionario"] = true; //pra trazer mebros que não estão relacionados com funcionários ainda                                                
                                    $arrObjMembro  = FachadaCadastro::getInstance()->consultarMembro($arrStrFiltros);
                                    if($arrObjMembro != null){
                                        $arrObj = $arrObjMembro["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">   '.utf8_encode($arrObj[$intI]->getNome()).'</option>';
                                        }
                                    }else{
                                        echo '<option value="">Selecione o membro</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="linha">
                        <input type="button" value="Gerar" onclick="gerar();" class="botao"/>                                        
                    </fieldset>
                </fieldset>                
                
            </form>            
        </div>      
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>