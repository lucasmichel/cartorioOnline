<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);
    
    if(isset($_GET)){
        
        $arrStrFiltros["PTM_Condicao"] = $_GET["PTM_Condicao"];
        $arrStrFiltros["TIP_ID"] = $_GET["TIP_ID"];
        $arrStrFiltros["IPT_ID"] = $_GET["IPT_ID"];
        
        
        $arrObj = FachadaPatrimonio::getInstance()->consultarPatrimonio($arrStrFiltros);
        if($arrObj != null){
            if(count($arrObj) > 0){      
                
                $arrObj = $arrObj["objects"];
                
                $arrObjsPar = FachadaGerencial::getInstance()->consultarParametro(null);    
                $arrObjsPar = $arrObjsPar["objects"]; 
                $objParametro = new Parametro();
                $objParametro = $arrObjsPar[0];
                
                
                $txtIgrejaCNPJ = strtoupper($objParametro->getCnpj());                
                $txtIgrejaBairro = strtoupper($objParametro->getEnderecoBairro());
                $txtIgrejaCEP = strtoupper($objParametro->getEnderecoCep());
                $txtIgrejaCidade = strtoupper($objParametro->getEnderecoCidade());
                $txtIgrejaComplemento = strtoupper($objParametro->getEnderecoComplemento());                
                $txtIgrejaLogradouro = strtoupper($objParametro->getEnderecoLogradouro());
                $txtIgrejaNumero = strtoupper($objParametro->getEnderecoNumero());
                $txtIgrejaUF = strtoupper($objParametro->getEnderecoUf());                
                $txtIgrejaNomeFantasia = strtoupper($objParametro->getNomeFantasia());                
                $txtIgrejaTelefone = strtoupper($objParametro->getTelefone()); 
                
                $txtEndereco= $txtIgrejaCNPJ."<br>".$txtIgrejaLogradouro.", ".$txtIgrejaNumero." - ".$txtIgrejaCidade. " - ". $txtIgrejaBairro." - ".$txtIgrejaUF." - ". $txtIgrejaCEP." - ".$txtIgrejaComplemento."<br>".$txtIgrejaTelefone;;
                
?>
<html>
    <head>
        <title><?php echo "Gerado em ".date("d/m/Y H:i:s");?></title>
        <link type="text/css" rel="stylesheet" href="../../../sistema/home/css/ficha.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="../../../../js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script>
        <script type="text/javascript" src="../../../sistema/home/js/sistema.js"></script>       
    </head>
    <body>        
        <div id="containerFicha">
            <?php
                include("../../../sistema/gerencial/inc/executar-impressao.inc.php");
            ?>
            <div id="impressaoConteudo">
                <div id="cabecalho">
                    <div id="logo">
                        <?php
                            include("../../../sistema/gerencial/inc/cabecalho-impressao.inc.php");
                        ?>
                    </div>
                    <div id="titulo">
                        <h1>Lista do Patrimônio</h1>
                    </div>
                </div>
                <hr/>
                
                <div id="ficha">
                    <table border="0" id="dadosFicha" cellpadding="4" align="center" >
                        <tr>
                            <td>
                                <table class="dadosFicha">
                                    <tr class="cabecalhoFicha">
                                        <td>ID</td>
                                        <td>PATRIMÔNIO</td>
                                        <td>QTD</td>
                                        <td>DESCRIÇÃO DO BEM</td>
                                        <td>VALOR R$</td>
                                        <td>GRUPO</td>
                                        <td>SUBGRUPO</td>
                                        <td>AQUISIÇÃO</td>
                                        <td>ONDE ESTÁ</td>
                                    </tr>

                                    <?php
                                    $intContador = 0;
                                    $intTotal = count($arrObj);
                                    for($intI=0; $intI<count($arrObj); $intI++) {
                                        $objPatrimonio = new Patrimonio();                
                                        $objPatrimonio = $arrObj[$intI];
                                        $classDif = 'class="linhaNormal"';
                                        if($intI%2 == 0){
                                            $classDif = 'class="linhaCor"';
                                        }
                                    ?>


                                    <tr <?php echo $classDif; ?> >
                                        <td><?php echo $objPatrimonio->getId(); ?> </td>
                                        <td><?php echo $objPatrimonio->getNumeroTombamento(); ?> </td>
                                        <td><?php echo $objPatrimonio->getQuantidade(); ?> </td>
                                        <td><?php echo $objPatrimonio->getDescricao(); ?> </td>                                
                                        <td><?php echo "R$ ".NumeroHelper::getInstance()->formatarMoeda($objPatrimonio->getValorEstimado()); ?> </td>                                
                                        <td><?php echo $objPatrimonio->getTipoPatrimonio()->getDescricao(); ?> </td>
                                        <td><?php echo $objPatrimonio->getItemPatrimonio()->getDescricao(); ?> </td>
                                        <td><?php echo $objPatrimonio->getFormaAquisicao()->getDescricao(); ?> </td>                                
                                        <td><?php echo $objPatrimonio->getCongregacao()->getDescricao(); ?> </td>
                                    </tr>

                                    <?php
                                        }
                                    ?>

                                </table>
                            </td>
                        </tr>
                
                        <tr>
                            <td>
                            <?php
                                include("../../../sistema/gerencial/inc/rodape-impressao.inc.php");
                            ?> 
                            </td>
                        </tr>
                    </table>
                    
                    
                </div>
                
            </div>
        </div>
    </body>
</html>
<?php
            }
        }
    }
?>