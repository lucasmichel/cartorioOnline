<?php
    ini_set('default_charset','UTF-8');
    
    // codificação UTF-8
    session_start();
    
    include("../../../inc/config.inc.php");
    include("../gerencial/inc/seguranca.inc.php");
    include("inc/autoload.inc.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo SISTEMA_TITULO; ?></title>
    <link type="image/ico" rel="shortcut icon" href="img/favi.png" /> 
    
    <!-- jQuery -->
    <!--<script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.1.7.1.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.ui/jquery.ui.1.8.17.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo SISTEMA_HTTP; ?>/js/jquery.ui/overcast/jquery.ui.1.8.17.custom.css"/>-->
    
    
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.1.10.2.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.ui/jquery.ui.1.10.4.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo SISTEMA_HTTP; ?>/js/jquery.ui/overcast/jquery.ui.1.10.4.custom.css"/>
    
    <!-- DataPicker (Idioma) -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.ui.datapicker/jquery.ui.datepicker.pt-BR.js"></script>
    
    <!-- jQuery Form -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.form/jquery.form.js"></script>
    
    <!-- DataGrid -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.ui.datagrid/jquery.ui.datagrid.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo SISTEMA_HTTP; ?>/js/jquery.ui.datagrid/jquery.ui.datagrid.css" />    
                
    <!-- HighCharts (Gráficos) -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.highcharts/highcharts.js"></script>    
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.highcharts/exporting.js"></script>
    
    <!-- EXPORTAR PARA O EXCEL -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.export.excel/jquery.battatech.excelexport.js"></script>
    
    <!-- JSON (Objeto json jquery) -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.json/jquery.json-2.3.min.js"></script>
    
    <!-- Utilitários -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.utilitarios/jquery.mask.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.utilitarios/jquery.cep.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.utilitarios/jquery.price.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.utilitarios/jquery.alphanumeric.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.utilitarios/jquery.print.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.utilitarios/jquery.blockUI.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.utilitarios/jquery.comum.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.utilitarios/jquery.print.js"></script>    
    
    <!-- jQuery Carrega Imagem (Exibir imagem upload) -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.preview.image/jquery.preimage.js"></script>
    
    <!-- jQuery photoboot -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.photoboot/jquery.photobooth.js"></script>               
    <link type="text/css" rel="stylesheet" href="<?php echo SISTEMA_HTTP; ?>/js/jquery.photoboot/Photobooth.css" />    
    
    <!-- jQuery TimeEntry -->
    <link rel="stylesheet" type="text/css" href="<?php echo SISTEMA_HTTP; ?>/js/jquery.time.entry/jquery.timeentry.css" />
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.time.entry/jquery.plugin.js"></script>        
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.time.entry/jquery.timeentry.js"></script>     
    
    <!-- jQuery AutoComplete -->
    <link rel="stylesheet" type="text/css" href="<?php echo SISTEMA_HTTP; ?>/js/jquery.autocomplete/chosen.css" />
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.autocomplete/chosen.proto.js"></script>
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.autocomplete/chosen.jquery.js"></script>
    <!-- jQuery AutoComplete -->  
   
    <!-- jQuery Croppic -->        
    <link rel="stylesheet" type="text/css" href="<?php echo SISTEMA_HTTP; ?>/js/jquery.croppic/croppic.css" />
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.croppic/croppic.js"></script>
    <!-- jQuery Croppic -->
      
    <!-- Exports -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.excel/jquery.battatech.excelexport.js"></script>
    <!-- Exports -->
    
    <!-- Lightbox -->        
    <link rel="stylesheet" type="text/css" href="<?php echo SISTEMA_HTTP; ?>/js/jquery.lightbox/css/lightbox.css" />
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/js/jquery.lightbox/js/lightbox.min.js"></script>
    <!-- Lightbox -->
    
    <!-- Principal (Sistema) -->
    <script type="text/javascript" src="<?php echo SISTEMA_HTTP; ?>/modulos/sistema/home/js/sistema.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo SISTEMA_HTTP; ?>/modulos/sistema/home/css/sistema.css" />
    <link type="text/css" rel="stylesheet" href="css/modulo-categoria.css"/>
    <link type="text/css" rel="stylesheet" href="css/modulo.css"/>    
    <link type="text/css" rel="stylesheet" href="css/menu.css" /> 
    <link type="text/css" rel="stylesheet" href="css/navegacao.css"/>
    <link type="text/css" rel="stylesheet" href="css/relatorio.css"/>
    <link type="text/css" rel="stylesheet" href="css/ficha.css"/>
    <link type="text/css" rel="stylesheet" href="css/tabela.css"/>
    
    <script type="text/javascript">        
        $(document).ready(function(){
            exibirTela("content", "modulo-categoria.php");
        });
        
        function abrirAtendimentoOnLine(){
            window.open("chat.php", "Igreja Conectada", "height = 600, width = 400",  "location = no", "toolbar = no", "menubar = no" );
        }
        
    </script>
</head>
<body>
    <div id="container">
        <div id="topo">
            <input type="hidden" id="hddCaminho" value="" >
            <input type="hidden" id="hddModuloCategoria" value="" >            
            <img src="img/logo.png" alt="<?php echo SISTEMA_SIGLA; ?>" title="<?php echo SISTEMA_TITULO; ?>" id="logo"/>

            <!-- menus -->
            <a href="sair.php">
                <img src="img/sair.png" alt="Sair" title="Sair do Sistema" class="alinhamentoEsquerdoMenuHeader" border="0"/>
            </a>
            <!--<a href="javascript: void(0);" onclick="atualizarBarraNavegacao('navegacao', 'inc/navegacao.inc.php'); exibirTela('content', '../gerencial/senha.php');">
                <img src="img/alterar-senha.png" alt="Senha" title="Alterar senha" class="alinhamentoEsquerdoMenuHeader" border="0"/>
            </a>-->
            <a href="javascript: void(0);" onclick="atualizarBarraNavegacao('navegacao', 'inc/navegacao.inc.php'); exibirTela('content', 'modulo-categoria.php');">
                <img src="img/modulo.png" alt="M&oacute;dulo" title="M&oacute;dulos do Sistema" class="alinhamentoEsquerdoMenuHeader" border="0"/>
            </a>
        </div><!-- topo -->
        <div id="saudacao">
            <p>
                <?php 
                    $strTextoSaudacaoHorario = "Boa noite";

                    if((date("H:i:s") < "12:00:00") and (date("H:i:s") > "00:00:00")){
                        $strTextoSaudacaoHorario = "Bom dia";
                    }else{
                        if((date("H:i:s") < "18:00:00") and (date("H:i:s") >= "12:00:00")){
                            $strTextoSaudacaoHorario = "Boa tarde";
                        }
                    }
                    
                    $strUsuarioNome = "";
                    
                    if(isset($_SESSION["USUARIO_NOME"])){
                        $strUsuarioNome = $_SESSION["USUARIO_NOME"];                        
                    }else{
                        $strUsuarioNome = $_SESSION["USUARIO_LOGIN"];
                    }
                    
                    echo $strTextoSaudacaoHorario.', <b>'.$strUsuarioNome.'</b>. Voc&ecirc; est&aacute; logado no <b>'.SISTEMA_SIGLA;                    
                    echo '</b>.';
                    
                    if(isset($_SESSION["USUARIO_ULTIMOACESSO"])){
                        if(trim($_SESSION["USUARIO_ULTIMOACESSO"]) != ""){
                            echo ' (&Uacute;ltimo Acesso: '.  DataHelper::getInstance()->converterDataBancoParaDataUsuario($_SESSION["USUARIO_ULTIMOACESSO"].")");
                        }
                    }
                ?>
            </p>
            <?php         
            
                // identifica a versão do sistema
                //$arrStrSys = Db::getInstance()->select("SELECT SYS_Versao FROM CAD_SYS_SYSTEM");
            
                //identifica o nome da igreja
                //$arrObjs = FachadaGerencial::getInstance()->consultarParametro(null);                                
                /*if($arrObjs != null){
                    $arrObjs = $arrObjs["objects"];                    
                    echo '<p style="margin-top:10px;">';                        
                        echo '<strong>Ambiente: </strong>' .$arrObjs[0]->getNomeFantasia();                        
                    echo '</p>';
                }*/
            ?>    
        </div><!-- #saudacao -->
        <div id="navegacao">
        </div><!-- #navegacao -->
        <div id="content">
        </div><!-- #content -->
    </div><!-- #container -->
    <div id="rodape">
        
        <div style="margin-left:10px; margin-right: 10px;">
            <div style="float: left; margin-top:10px; ">
                Desenvolvimento <a href="http://<?php //echo EMPRESA_SITE;?>" target="_blank" style="color: #FFF; text-decoration: none; font-weight: bold;"><?php //echo EMPRESA;?></a>
            </div>
            <div style="float: right; margin-top:10px; ">
                <b>Vers&atilde;o do Software:1.0</b> <?php //echo $arrStrSys[0]["SYS_Versao"];?>
            </div>
        </div>
        
        <!--<p>
            Desenvolvimento <a href="http://<?php //echo EMPRESA_SITE;?>" target="_blank" style="color: #FFF; text-decoration: none; font-weight: bold;"><?php //echo EMPRESA;?></a>
        </p>-->
        
        <!--<div>
            <div style="float: left;">
                
            </div>
            <div style="float: right;">
                <p>
                    <b>Vers&atilde;o do Software:</b> <?php echo $arrStrSys[0]["SYS_Versao"];?>
                </p>
            </div>
        </div>-->
        
    </div>
</body>
</html>