<?php
    //require_once 'PHPWord/PHPWord.php';
    require_once('tcpdf/tcpdf.php');
    require_once('CSVWrite/CSV_Writer.php');

    define ('BATIK_PATH', 'exporting-server/batik-rasterizer.jar');
    define ('TEMP_PATH', 'exporting-server/temp/');

    if(isset($_POST['type']) && isset($_POST['oreientecaoPagina']) && isset($_POST['nomeArquivo']) && isset($_POST['title1']) && isset($_POST['title2']) && isset($_POST['title3']) && isset($_POST['header']) && isset($_POST['footer']) && isset($_POST['data'])  && isset($_POST['nomeIgreja']) ){    
        $nomeIgreja=urldecode($_POST['nomeIgreja']);
        $nomeArquivo=urldecode($_POST['nomeArquivo']);
        $oreientecaoPagina=urldecode($_POST['oreientecaoPagina']);
        $title1=urldecode($_POST['title1']);
        $title2=urldecode($_POST['title2']);
        $title3=urldecode($_POST['title3']);
        $header=urldecode($_POST['header']);//tabela com html a ser impresso 
        $footer=urldecode($_POST['footer']);    
        $type=urldecode($_POST['type']);
        $data=json_decode(urldecode($_POST['data']));

        $items=array();
        if($data[0]->svg != null){
            for($i=0; $i < count($data); $i++){
                $items[]=svgToJpg($data[$i]);
            }
        }


        if($type=='pdf'){
          doPDF($oreientecaoPagina, $nomeArquivo, $nomeIgreja, $title1, $title2, $title3, $header,$footer,$items);
        }elseif($type=='doc'){
          doDoc($nomeIgreja, $title,$header,$footer,$items);  
        }
        if($data[0]->svg != null){
            foreach($items as $item){
              unlink($item->filename);
            }
        }
        exit;

    }else{    
        print 'ERROR docgen.php: faltando algum campo!';
    }


    function svgToJpg($item){
      /*CONVERTS SVG TO JPG*/

      ///////////////////////////////////////////////////////////////////////////////
      ini_set('magic_quotes_gpc', 'off');


      $filename =  isset($_POST['filename']) ? $_POST['filename'] : 'chart';
      //$width =  isset($_POST['width']) ? $_POST['width'] : 800;

      $svg=$item->svg;
      if (get_magic_quotes_gpc()) {
        $svg = stripslashes($svg);  
      }



      $tempName = md5(rand());
      $typeString = ' -m image/jpeg ';
      $ext = '.jpg';
      $outfile = TEMP_PATH.$tempName.$ext;

      if (isset($typeString)) {

        // size
       $width = " -w 700 ";

       //echo 	"java -jar ". BATIK_PATH ." ".$typeString." -q 0.99 ".$outfile." ".$width." ".TEMP_PATH.$tempName.".svg";
      //die();
        // generate the temporary file
        if (!file_put_contents(TEMP_PATH.$tempName.".svg", $svg)) { 
          die("Couldn't create temporary file. Check that the directory permissions for
            the /temp directory are set to 777.");
        }

        // do the conversion
        shell_exec("chmod 777 ".TEMP_PATH.$tempName.".svg");
        $output = shell_exec("java -jar ". BATIK_PATH ." $typeString -d $outfile $width ".TEMP_PATH.$tempName.".svg");        
        // catch error
        if (!is_file($outfile) || filesize($outfile) < 10) {
          echo "<pre>$output</pre>";
          echo "Error while converting SVG. ";

          if (strpos($output, 'SVGConverter.error.while.rasterizing.file') !== false) {
            echo "SVG code for debugging: <hr/>";
            echo htmlentities($svg);
          }
        } 

        // stream it
        else {
          unlink(TEMP_PATH.$tempName.".svg");
          $item->filename=$outfile;
          return $item;
        }

        // delete it

        unlink($outfile);

      // SVG can be streamed directly back
      } else {
        echo "Invalid type";
      }
    }
    exit;




    function doDoc($title,$headertext,$footertext,$items){

      // New Word Document
      $PHPWord = new PHPWord();
      // New portrait section
      $section = $PHPWord->createSection();

      // Add header
      $header = $section->createHeader();
      $table = $header->addTable();
      $table->addRow();
      $table->addCell(4500)->addText($headertext);

      // Add footer
      $footer = $section->createFooter();
      //$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align'=>'center'));
      $footer->addPreserveText($footertext, array('align'=>'center'));

      // Title styles
      $PHPWord->addTitleStyle(1, array('size'=>20, 'color'=>'333333', 'bold'=>true));
      $PHPWord->addTitleStyle(2, array('size'=>16, 'color'=>'666666'));

      $section->addTitle($title, 1);

      foreach($items as $item){
        $section->addTitle($item->title, 2);
        $section->addTextBreak(1);
        $section->addText($item->text);
        $section->addTextBreak(1);
        $section->addImage($item->filename);
        $section->addTextBreak(1);
      }


      $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
      header('Content-Type: application/vnd.ms-word');
      header('Content-Disposition: attachment;filename="'.$title.'.docx"');
      header('Cache-Control: max-age=0');
      // At least write the document to webspace:
      $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
      $objWriter->save('php://output');

    }


    function doPDF($oreientecaoPagina, $nomeArquivo, $nomeIgreja, $title1, $title2, $title3, $headertext, $footertext,$items){  

      require_once('tcpdf/config/lang/eng.php');  
      require_once('tcpdf/tcpdf.php');

      class MYPDF extends TCPDF {

      private $txtNomeIgreja;
      private $txtTitulo1;
      private $txtTitulo2;
      private $txtTitulo3;
      private $txtFooter;

      public function getTxtNomeIgreja() {
          return $this->txtNomeIgreja;
      }

      public function getTxtTitulo1() {
          return $this->txtTitulo1;
      }

      public function getTxtTitulo2() {
          return $this->txtTitulo2;
      }

      public function getTxtTitulo3() {
          return $this->txtTitulo3;
      }

      public function getTxtFooter() {
          return $this->txtFooter;
      }

      public function setTxtNomeIgreja($txtNomeIgreja) {
          $this->txtNomeIgreja = $txtNomeIgreja;
      }

      public function setTxtTitulo1($txtTitulo1) {
          $this->txtTitulo1 = $txtTitulo1;
      }

      public function setTxtTitulo2($txtTitulo2) {
          $this->txtTitulo2 = $txtTitulo2;
      }

      public function setTxtTitulo3($txtTitulo3) {
          $this->txtTitulo3 = $txtTitulo3;
      }

      public function setTxtFooter($txtFooter) {
          $this->txtFooter = $txtFooter;
      }


      //Page header
            public function Header() {
                // Logo
                //$image_file = K_PATH_IMAGES.'logo_example.jpg';
                //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                // Set font
                $this->SetFont('helvetica', ' ', 18);
                // Title
                $this->Cell(0, 0, $this->getTxtNomeIgreja(), 0, true, 'C', 0, '', 1, false);

                $this->SetFont('helvetica', ' ', 10);
                // Title
                $this->Cell(0, 0, $this->getTxtTitulo1(), 0, true, 'C', 0, '', 1, false);
                $this->Cell(0, 0, $this->getTxtTitulo2(), 0, true, 'C', 0, '', 1, false);
                $this->Cell(0, 0, $this->getTxtTitulo3(), 0, true, 'C', 0, '', 1, false);

            }

            // Page footer
            public function Footer() {
                // Position at 15 mm from bottom
                $this->SetY(-15);
                // Set font
                $this->SetFont('helvetica', 'I', 8);
                // Page number
                $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages().' '.$this->getTxtFooter(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            }
        }



      // create new PDF document
      //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf = new MYPDF($oreientecaoPagina, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


      $pdf->setTxtNomeIgreja($nomeIgreja);
      $pdf->setTxtTitulo1($title1);
      $pdf->setTxtTitulo2($title2);
      $pdf->setTxtTitulo3($title3);
      $pdf->setTxtFooter($footertext);

      // set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('MS_INFORMATICA');
      //$pdf->SetTitle('TCPDF Example 006');
      //$pdf->SetSubject('TCPDF Tutorial');
      //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

      // set default header data
      $pdf->SetHeaderData(NULL, NULL, "Igreja Conectada", NULL); 


      // set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      //set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

      //set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      //set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      //set some language-dependent strings
      $pdf->setLanguageArray($l);



      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+8, PDF_MARGIN_RIGHT);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM+8);


      // ---------------------------------------------------------

      // set font
      $pdf->SetFont('helvetica', '', 10);

      // add a page
      $pdf->AddPage();
      $html = '<table cellpadding="0" cellspacing="0" width="100%"  >';
        $html .= '<tr>';
            $html .= '<td align="center" >';
            foreach($items as $item){
              //$html .= '<h2>'.$item->title.'</h2>';
              //$html .= '<p>'.$item->text.'</p>';
              $html .= '<img src="'.$item->filename.'" />';
            }
        $html .= '</td>';
      $html .= '</tr>';
      $html .= '<tr>';
        $html .= '<td>';
            $html .= $headertext ;
        $html .= '</td>';
      $html .= '</tr>';
      $html .= '</table>';

      $pdf->writeHTML($html, true, false, true, false, '');

      //Close and output PDF document
      $pdf->Output($nomeArquivo.'.pdf', 'D');
    }
?>