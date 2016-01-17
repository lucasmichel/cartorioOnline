<?php
    // codificação UTF-8
    session_start();
    include("../../../../lib/html2pdf_v4.03/html2pdf.class.php");
    
    // recupera o pdfID
    $strPdfId = $_GET["pdfID"];
    
    $novoNome      = $_SESSION[$strPdfId]["PDF_Nome"].".pdf";
    $strContent    = $_SESSION[$strPdfId]["PDF_Conteudo"];
    $strOrientacao = $_SESSION[$strPdfId]["PDF_Orientacao"];
    
    $objHtml2PDF = new HTML2PDF($strOrientacao,'A4','fr'); // L ou P
    $objHtml2PDF->WriteHTML($strContent);
    $objHtml2PDF->Output($novoNome);
    
    /*header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="'.$novoNome.'"');
    header('Content-Type: application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($novoNome));
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');

    // Envia o arquivo para o cliente
    readfile($novoNome);*/
?>

