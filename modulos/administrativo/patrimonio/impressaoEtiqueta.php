<?php
    require_once("../../../lib/fpdf17/fpdf.php");
    require_once("../../../lib/fpdf17/code39.php");
    require_once("../../../inc/config.inc.php");    
    require_once("./inc/autoload.inc.php");    
    require_once("../../../classes/interfaces/InterfaceDatabase.php");
    require_once("../../../classes/dbs/DbMysql.php");
    require_once("../../../classes/dbs/Db.php");

   // print_r($_POST);exit;

    // Variaveis de Tamanho

    $mesq = "5"; // Margem Esquerda (mm)
    $mdir = "5"; // Margem Direita (mm)
    $msup = "12"; // Margem Superior (mm)
    $leti = "72"; // Largura da Etiqueta (mm)
    $aeti = "27"; // Altura da Etiqueta (mm)
    $ehet = "3,2"; // Espaço horizontal entre as Etiquetas (mm)
    $pdf=new PDF_Code39('P','mm','Letter'); // Cria um arquivo novo tipo carta, na vertical.
    $pdf->Open(); // inicia documento
    $pdf->AddPage(); // adiciona a primeira pagina    
    $pdf->SetMargins('5','12,7'); // Define as margens do documento
    $pdf->SetAuthor(SISTEMA_SIGLA); // Define o autor
    $pdf->SetFont('helvetica','',8); // Define a fonte
    $pdf->SetDisplayMode('fullpage');

    $coluna = 0;
    $linha = 0;
    
    /*$strSQL = "SELECT * FROM CAD_PAR_PARAMETROS WHERE PAR_Descricao = 'INST_NOME_FANTASIA' ";
    $arrStrDados = Db::getInstance()->select($strSQL);*/
    
    
    
    $arrObjsPar = FachadaGerencial::getInstance()->consultarParametro(null);        
    $arrObjsPar = $arrObjsPar["objects"];   
    $strNomeFantasia = $arrObjsPar[0]->getNomeFantasia();
    
    
      
    $strSQL  = "SELECT * FROM PAT_PTM_PATRIMONIOS P ";
    $strSQL .= "INNER JOIN PAT_TIP_TIPOS_PATRIMONIOS TP ON (TP.TIP_ID = P.TIP_ID) ";
    $strSQL .= "INNER JOIN PAT_IPT_ITENS_PATRIMONIAIS IP ON (IP.TIP_ID = P.TIP_ID) ";
    $strSQL .= "INNER JOIN PAT_FRA_FORMAS_AQUISICAO A ON (A.FRA_ID = P.FRA_ID) ";
    $strSQL .= "WHERE P.PTM_ID IN (".$_GET["PTM_ID_IN"].") ";
    $strSQL .= "GROUP BY P.PTM_ID";
    
    $arrStrDados = Db::getInstance()->select($strSQL);
    
    for($intI=0; $intI<count($arrStrDados); $intI++){
        if($linha == "10") {
            $pdf->AddPage();
            $linha = 0;
        }
        
        if($coluna == "3") { // Se for a terceira coluna
            $coluna = 0; // $coluna volta para o valor inicial
            $linha = $linha +1; // $linha é igual ela mesma +1
        }
        
        if($linha == "10") { // Se for a última linha da página
            $pdf->AddPage(); // Adiciona uma nova página
            $linha = 0; // $linha volta ao seu valor inicial
        }
        
        $posicaoV = $linha*$aeti;
        $posicaoH = $coluna*$leti;

        if($coluna == "0") { // Se a coluna for 0
            $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
        } else { // Senão
            $somaH = $mesq+$posicaoH; // Soma Horizontal é a margem inicial mais a posiçãoH
        }

        if($linha =="0") { // Se a linha for 0
            $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
        } else { // Senão
            $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
        }

        $pdf->Text($somaH, $somaV, substr($strNomeFantasia, 0, 35)); // Imprime o nome da pessoa de acordo com as coordenadas
        $pdf->Code39($somaH, $somaV+2, $arrStrDados[$intI]["PTM_NumeroTombamento"], 0.8); // Imprime o endereço da pessoa de acordo com as coordenadas
        //$pdf->Text($somaH,$somaV+8,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
        //$pdf->Text($somaH,$somaV+12,$cep); // Imprime o cep da pessoa de acordo com as coordenadas

        $coluna = $coluna+1;
    }
    //MONTA A ARRAY PARA ETIQUETAS
    /*while($dados = mysql_fetch_array($busca)) {
    $nome = $dados["nome"];
    $ende = $dados["logradouro"];
    $bairro = $dados["bairro"];
    $estado = $dados["uf"];
    $cida = $dados["cidade"];
    $local = $bairro . " - " . $cida . " - " . $estado;
    $cep = "CEP: " . $dados["cep"];

    if($linha == "10") {
    $pdf->AddPage();
    $linha = 0;
    }

    if($coluna == "3") { // Se for a terceira coluna
    $coluna = 0; // $coluna volta para o valor inicial
    $linha = $linha +1; // $linha é igual ela mesma +1
    }

    if($linha == "10") { // Se for a última linha da página
    $pdf->AddPage(); // Adiciona uma nova página
    $linha = 0; // $linha volta ao seu valor inicial
    }

    $posicaoV = $linha*$aeti;
    $posicaoH = $coluna*$leti;

    if($coluna == "0") { // Se a coluna for 0
    $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
    } else { // Senão
    $somaH = $mesq+$posicaoH; // Soma Horizontal é a margem inicial mais a posiçãoH
    }

    if($linha =="0") { // Se a linha for 0
    $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
    } else { // Senão
    $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
    }

    $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
    $pdf->Text($somaH,$somaV+4,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
    $pdf->Text($somaH,$somaV+8,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
    $pdf->Text($somaH,$somaV+12,$cep); // Imprime o cep da pessoa de acordo com as coordenadas

    $coluna = $coluna+1;
    }*/

    $pdf->Output();
?>