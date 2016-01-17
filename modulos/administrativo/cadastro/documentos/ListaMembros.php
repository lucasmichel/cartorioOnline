<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    require_once('../../../../lib/html2pdf_v4.03/html2pdf.class.php');  
    
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);
    
    
    /*var_dump($_GET);
    die();*/
    
    if(isset($_GET["PES_Status"])){
        
        
        if(isset($_GET["pesquisarPor"])){
            if($_GET["pesquisarPor"] == "nome"){
                $_GET["PES_Nome"] = $_GET["pesquiasrCampo"];
            }

            if($_GET["pesquisarPor"] == "cpf"){
                $_GET["PES_CPF"] = $_GET["pesquiasrCampo"];
            }

            if($_GET["pesquisarPor"] == "matricula"){
                $_GET["PES_Matricula"] = $_GET["pesquiasrCampo"];
            }   
        }
        
        
        
        $arrFiltroParametro = "";
        $arrDadosParametro = FachadaGerencial::getInstance()->consultarParametro($arrFiltroParametro);
        
        /*echo '<pre>';
        print_r($arrDadosParametro["objects"]);
        die();*/
        
        $txtRazaoSocialIgreja = strtoupper($arrDadosParametro["objects"][15]->getValor());
        $txtIgrejaCNPJ = strtoupper($arrDadosParametro["objects"][0]->getValor());                
        $txtIgrejaBairro = strtoupper($arrDadosParametro["objects"][4]->getValor());       
        $txtIgrejaCEP = strtoupper($arrDadosParametro["objects"][5]->getValor());                
        $txtIgrejaCidade = strtoupper($arrDadosParametro["objects"][6]->getValor());                
        $txtIgrejaComplemento = strtoupper($arrDadosParametro["objects"][7]->getValor());                
        $txtIgrejaLogradouro = strtoupper($arrDadosParametro["objects"][8]->getValor());                
        $txtIgrejaNumero = strtoupper($arrDadosParametro["objects"][9]->getValor());                
        $txtIgrejaUF = strtoupper($arrDadosParametro["objects"][10]->getValor());                
        $txtIgrejaNomeFantasia = strtoupper($arrDadosParametro["objects"][13]->getValor());                
        $txtIgrejaTelefone = strtoupper($arrDadosParametro["objects"][18]->getValor()); 
        $txtIgrejaFax = strtoupper($arrDadosParametro["objects"][11]->getValor()); 
        $strEndereco  = $txtIgrejaCNPJ."<br/>";
        $txtImagem = $arrDadosParametro["objects"][12]->getValor();
        

        $strComplemento = "";
        $strFax = "";

        if(trim($txtIgrejaComplemento) != ""){
            $strComplemento = ", ".$txtIgrejaComplemento;
        }

        if(trim($txtIgrejaFax) != ""){
            $strFax = " Fax: ".$txtIgrejaFax;
        }

        $strEndereco .= $txtIgrejaLogradouro.", ".$txtIgrejaNumero.$strComplemento."<br/>";
        $strEndereco .= $txtIgrejaBairro." - ".$txtIgrejaCidade." - ".$txtIgrejaUF."<br/>";
        $strEndereco .= "CEP: ".$txtIgrejaCEP." Tel.: ".$txtIgrejaTelefone.$strFax;
        
        
        

        $arrObj = FachadaCadastro::getInstance()->consultarMembro($_GET);
        
        if($arrObj != null){
            if(count($arrObj) > 0){
                
                $strTable = "<html>";
                    $strTable .= "<head>";
                        $strTable .= "<title>Lista de Membros gerada em ".date("d/m/Y")."</title>";
                        $strTable .= "<link type='text/css' rel='stylesheet' href='../../../sistema/home/css/sistema.css'/>";
                        $strTable .= "<link type='text/css' rel='stylesheet' href='../../../sistema/home/css/ficha.css'/>";
                    $strTable .= "</head>";                
                    $strTable .= "<body>";                

                        $strTable .= "<div id='ficha'>";
                            $strTable .= "<img src=".$txtImagem." />";
                            $strTable .= "<h1 style='font-size: 18px;'>LISTA DE MEMBROS</h1>";
                            

                            $strTable .= "<table id='dadosRelatorio' border='1px' cellpadding='5' cellspacing='0' width='900px'>";
                            
                                $strTable .= "<tr>";
                                    $strTable .= "<td width='200px' >Nome</td>";
                                    $strTable .= "<td width='100px' >Categoria</td>";
                                    $strTable .= "<td width='200px' >Email's</td>";
                                    $strTable .= "<td width='200px' >Telefones</td>";
                                    $strTable .= "<td width='100px' >Matrícula</td>";
                                    $strTable .= "<td width='100px'>Batizado?</td>";
                                $strTable .= "</tr>";
                            
                                foreach ($arrObj["objects"] as $object) {
                                    $membro = new Membro();
                                    $objCategoriaMembro = new CategoriasMembro();
                                    $membro = $object;
                                    $objCategoriaMembro = $membro->getCategoria();

                                    $strTable .= "<tr>";
                                        $strTable .= "<td>".$membro->getNome()."</td>";
                                        $strTable .= "<td>".$objCategoriaMembro->getDescricao()."</td>";
                                        $strTable .= "<td>".$membro->getEmailPrimario()." - ".$membro->getEmailSecundario()."</td>";
                                        $strTable .= "<td>".$membro->getTelefoneCelular()." - ".$membro->getTelefoneResidencial()."</td>";
                                        $strTable .= "<td>".$membro->getMatricula()."</td>";
                                        if($membro->getBatizado() == "S"){
                                            $strTable .= "<td>SIM - ".$membro->getBatizadoDesde()."</td>";
                                        }else{
                                            $strTable .= "<td>NÃO</td>";
                                        }
                                        //$strTable .= "<td>".$membro->getBatizado()." - ".$membro->getBatizadoDesde()."</td>";
                                    $strTable .= "</tr>";

                                }
                            
                            $strTable .= "</table>";

                        $strTable .= "</div>";

                    $strTable .= "</body>";
                $strTable .= "</html>";
                
                //echo $strTable;
                $objHtml2PDF = new HTML2PDF('L','A4','pt');
                $objHtml2PDF->WriteHTML($strTable);
                $objHtml2PDF->Output('listaMembros.pdf');

            }
        }
    }    
?>