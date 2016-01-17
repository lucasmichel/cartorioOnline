<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    
    header('Content-Type: text/html; charset=utf-8', true);
    
    if(isset($_GET["consultar"])){         
        if($_GET["consultar"] != "all"){
            $txt = $_GET["consultar"];
            $txtImpressao = " LETRA: ".strtoupper($_GET["consultar"]);
        }else{
            $txt = null;
            $txtImpressao = " LETRA: A-Z";
        }
    }
    
    // consulta os membros
    $strSqlMembro  = "SELECT PES_Nome, PES_TelefoneResidencial, PES_TelefoneCelular,  ";
    $strSqlMembro .= "MEM_EmpresaTelefoneComercial, MEM_EmpresaTelefoneFax ";
    $strSqlMembro .= "FROM ADM_MEM_MEMBROS AS MEMBROS ";
    $strSqlMembro .= "INNER JOIN CAD_PES_PESSOAS AS PESSOA ON (PESSOA.PES_ID = MEMBROS.PES_ID) ";
    $strSqlMembro .= "WHERE PES_Nome LIKE '".trim($txt)."%' ";        
    $strSqlMembro .= "ORDER BY PES_Nome ASC ";
    
    $arrDadosMembro =  Db::getInstance()->select($strSqlMembro);

    // consulta os funcionarios
    $strSqlFuncionarios = "SELECT PES_Nome, PES_TelefoneResidencial, PES_TelefoneCelular  ";        
    $strSqlFuncionarios .= "FROM RH_FUN_FUNCIONARIOS AS FUNCIONARIOS ";
    $strSqlFuncionarios .= "INNER JOIN CAD_PES_PESSOAS AS PESSOA ON (PESSOA.PES_ID = FUNCIONARIOS.PES_ID) ";        
    $strSqlFuncionarios .= "WHERE PES_Nome LIKE '".trim($txt)."%' ";
    $strSqlFuncionarios .= "ORDER BY PES_Nome ASC ";
    $arrDadosFuncionarios =  Db::getInstance()->select($strSqlFuncionarios);

    //consulta os fornecedores
    $strSqlFornecedores = "SELECT FOR_NomeFantasia, FOR_CNPJ, FOR_Telefone  ";        
    $strSqlFornecedores .= "FROM FIN_FOR_FORNECEDORES ";
    $strSqlFornecedores .= "WHERE FOR_NomeFantasia LIKE '".trim($txt)."%' ";
    $strSqlFornecedores .= "ORDER BY FOR_NomeFantasia ASC ";        
    $arrDadosFornecedores =  Db::getInstance()->select($strSqlFornecedores);
    
    //cria um unico array com todos os dados
    $arrayImpressao = array();
    $intContador    = 0;

    if($arrDadosMembro != null){
        if(count($arrDadosMembro) > 0){
            for($intI=0; $intI<count($arrDadosMembro); $intI++){
                $arrayImpressao[$intContador]["nome"] = $arrDadosMembro[$intI]["PES_Nome"];
                $arrayImpressao[$intContador]["tipo"] = "MEMBRO";
                $arrayImpressao[$intContador]["fone"] = "Residencial: ".$arrDadosMembro[$intI]["PES_TelefoneResidencial"].", Celular: ".$arrDadosMembro[$intI]["PES_TelefoneCelular"].", Comercial: ".$arrDadosMembro[$intI]["MEM_EmpresaTelefoneComercial"].", Fax: ".$arrDadosMembro[$intI]["MEM_EmpresaTelefoneFax"];
                $intContador++;
            }
        }        
    }


    if($arrDadosFuncionarios != null){
        if(count($arrDadosFuncionarios) > 0){
            for($intj=0; $intj<count($arrDadosFuncionarios); $intj++){
                $arrayImpressao[$intContador]["nome"] = $arrDadosFuncionarios[$intj]["PES_Nome"]." - FUNCIONARIO ";
                $arrayImpressao[$intContador]["tipo"] = "FUNCION&Aacute;RIO";
                $arrayImpressao[$intContador]["fone"] = "Residencial: ".$arrDadosFuncionarios[$intj]["PES_TelefoneResidencial"].", Celular: ".$arrDadosFuncionarios[$intj]["PES_TelefoneCelular"];
                $intContador++;
            }
        }        
    }

    if($arrDadosFornecedores != null){
        if(count($arrDadosFornecedores) > 0){
            for($inth=0; $inth<count($arrDadosFornecedores); $inth++){
                $arrayImpressao[$intContador]["nome"] = $arrDadosFornecedores[$inth]["FOR_NomeFantasia"];
                $arrayImpressao[$intContador]["tipo"] = "FORNECEDOR (<b>CNPJ:</b>".$arrDadosFornecedores[$inth]["FOR_CNPJ"].")";
                $arrayImpressao[$intContador]["fone"] = "Telefone: ".$arrDadosFornecedores[$inth]["FOR_Telefone"];
                $intContador++;
            }
        }        
    }    
?>

<html>
    <head>
        <title><?php echo SISTEMA_TITULO; ?></title>
        <link type="text/css" rel="stylesheet" href="../../../sistema/home/css/sistema.css"/>
        <link type="text/css" rel="stylesheet" href="../../../sistema/home/css/ficha.css"/>        
        <script type="text/javascript" src="../../../../js/jquery.1.7.1.js"></script>        
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script> 
        <script type="text/javascript" src="../../../../modulos/sistema/home/js/sistema.js"></script>  
    </head>
    <body>        
        <div style="display: inline-block;">
            <table align="left" cellpadding="5" border="0" style="border:0 !important;">
                <tr>
                    <td>
                        <a href='javascript:void(0);' onclick='imprimir("ficha");' title='Imprimir'><img src='../../../sistema/home/img/imprimir.png' align='absmiddle' border='0'/></a>
                    </td>
                </tr>    
            </table>
        </div>        
        <div id="ficha">
            
            <?php
                include("../../../sistema/home/inc/doc.inc.php");
                echo $strHtmlTopoDocumentoImpressao;
            ?>
            <h2 class="subtitulo">Agenda Telef&ocirc;nica</h2>
            <table style="width: 900px; border-collapse: separate; border-spacing: 1px; "  align="center" >
                <tr align="left" >
                    <td>
                        <h2 style="font-size: 16px;"><?php echo $txtImpressao;?> </h2>
                    </td>
                </tr>
            <?php
                if($arrayImpressao != null){
                    if(count($arrayImpressao) > 0){
                        
                        sort($arrayImpressao);
                        
                        for($intI=0; $intI<count($arrayImpressao); $intI++){                    
                            if($intI % 2 == 0) 
                                $cor = "#F4F4F4"; 
                            else $cor = "#FFF";
                            echo "<tr>
                                    <td>
                                        <div id='div-nome-agenda' style='background-color:".$cor.";'>
                                            <table border='0' id='dadosRelatorio' cellpadding='5' cellspacing='0' width='100%'>                                            
                                            <tr >                                    
                                                <td width='40%' >".$arrayImpressao[$intI]["nome"]."</td>
                                                <td width='20%' >".$arrayImpressao[$intI]["tipo"]."</td>    
                                                <td width='40%' >".$arrayImpressao[$intI]["fone"]."</td>
                                            </tr>
                                            </table>
                                        </div>
                                    </td>
                                  </tr>";
                       }
                    }
                }
            ?>             
            </table>
        </div>
    </body>
</html>

