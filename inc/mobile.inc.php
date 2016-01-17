<?php
    require_once($strDir."/lib/Mobile-Detect-2.6.9/Mobile_Detect.php");
    
    $objDetect        = new Mobile_Detect;
    $strDeviceType    = ($objDetect->isMobile() ? ($objDetect->isTablet() ? 'tablet' : 'phone') : 'computer');
    $strScriptVersion = $objDetect->getScriptVersion();
    
    if(($strDeviceType == "tablet") || ($strDeviceType == "phone")){        
        header("Location: ".$strDir."/mobile/index.php");
        exit; // força parar todo código que venha posteriormente
    }
?>
