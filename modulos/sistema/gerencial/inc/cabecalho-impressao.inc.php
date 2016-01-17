<?php
    $arrObjs = FachadaGerencial::getInstance()->consultarParametro(null);
    
    if($arrObjs != null){
        $arrObjs = $arrObjs["objects"];        
?>
<strong><?php echo $arrObjs[0]->getRazaoSocial();?></strong><br/>
<?php echo $arrObjs[0]->getEnderecoLogradouro();?>, <?php echo $arrObjs[0]->getEnderecoNumero();?>

<?php
    // complemento
    if(trim($arrObjs[0]->getEnderecoComplemento()) != ""){
?>
,<?php echo $arrObjs[0]->getEnderecoComplemento();?><br/>
<?php
    }else{
?>
<br/>
<?php
    }
?>

<?php echo $arrObjs[0]->getEnderecoBairro();?> - <?php echo $arrObjs[0]->getEnderecoCidade();?> - <?php echo $arrObjs[0]->getEnderecoUf();?> - Cep: <?php echo $arrObjs[0]->getEnderecoCep();?><br/>

<?php
    // telefones
    $arrObjTelefones = FachadaGerencial::getInstance()->consultarTelefoneParametro();
    
    if($arrObjTelefones != null){
        if(count($arrObjTelefones)){
            $arrObjTelefones = $arrObjTelefones["objects"];
            
            $strHtmlTel = "Tel.: ";
            
            for($intI=0; $intI<count($arrObjTelefones); $intI++){
                $strHtmlTel .= $arrObjTelefones[$intI]->getFone();
                
                if($intI < count($arrObjTelefones) - 1){
                    $strHtmlTel .= ",";
                }
            }
            
            echo $strHtmlTel."<br/>";
        }
    }
?>

<?php
    // e-mails
    $arrObjEmails = FachadaGerencial::getInstance()->consultarEmailParametro();
    
    if($arrObjEmails != null){
        if(count($arrObjEmails)){
            $arrObjEmails = $arrObjEmails["objects"];
            
            $strHtmlEma = "E-mail: ";
            
            for($intI=0; $intI<count($arrObjEmails); $intI++){
                $strHtmlEma .= $arrObjEmails[$intI]->getEmail();
                
                if($intI < count($arrObjEmails) - 1){
                    $strHtmlEma .= ",";
                }
            }
            
            echo $strHtmlEma;
        }
    }
?>

<?php
    }
?>