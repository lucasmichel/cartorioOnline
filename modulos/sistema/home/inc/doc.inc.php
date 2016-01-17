<?php
    // utf-8 codificação
    // cabeçalho para documentos
    $strSQL = "SELECT * FROM CAD_PAR_PARAMETROS";
    $arrStrParametros = Db::getInstance()->select($strSQL);
    
    function getParametroValor($strParametro){
        global $arrStrParametros;
        
        
        foreach($arrStrParametros as $arrStr => $arrPar){            
            if(trim($arrPar["PAR_Descricao"]) == trim($strParametro)){
                return trim($arrPar["PAR_Valor"]);
            }            
        }
        
        return "";
    }
    
    $INST_NOME_FANTASIA = getParametroValor("INST_NOME_FANTASIA");
    $INST_RAZAO_SOCIAL = getParametroValor("INST_RAZAO_SOCIAL");
    $INST_CNPJ = getParametroValor("INST_CNPJ");
    $INST_ENDERECO_LOGRADOURO = getParametroValor("INST_ENDERECO_LOGRADOURO");
    $INST_ENDERECO_NUMERO = getParametroValor("INST_ENDERECO_NUMERO");
    $INST_ENDERECO_COMPLEMENTO = getParametroValor("INST_ENDERECO_COMPLEMENTO");
    
    if($INST_ENDERECO_COMPLEMENTO != ""){
        $INST_ENDERECO_COMPLEMENTO = ", ".$INST_ENDERECO_COMPLEMENTO;
    }
    
    $INST_ENDERECO_CIDADE = getParametroValor("INST_ENDERECO_CIDADE");
    $INST_ENDERECO_BAIRRO = getParametroValor("INST_ENDERECO_BAIRRO");
    $INST_ENDERECO_UF     = getParametroValor("INST_ENDERECO_UF");
    $INST_ENDERECO_CEP    = getParametroValor("INST_ENDERECO_CEP");
    $INST_EMAIL           = getParametroValor("INST_EMAIL");
    $INST_TELEFONE        = getParametroValor("INST_TELEFONE");
    $INST_IMAGEM          = getParametroValor("INST_IMAGEM");
    
    $strHtmlTopoDocumentoImpressao = '';
    
    $strLOGO_TAG = '<img  src="'.$INST_IMAGEM.'" width="300" height="80">';
    
    //$strHtmlTopoDocumentoImpressao  = '<center>'.$strLOGO_TAG.'</center>';    
    $strHtmlTopoDocumentoImpressao  = $strLOGO_TAG;        
    //$strHtmlTopoDocumentoImpressao .= '<hr />';    
    $strHtmlTopoDocumentoImpressao .= '<p style="font-size: 12px; text-align: left;">';
        $strHtmlTopoDocumentoImpressao .= $INST_ENDERECO_LOGRADOURO.", n&ordm;. ".$INST_ENDERECO_NUMERO.$INST_ENDERECO_COMPLEMENTO.'<br/>';
        $strHtmlTopoDocumentoImpressao .= $INST_ENDERECO_BAIRRO.", ".$INST_ENDERECO_CIDADE." - ".$INST_ENDERECO_UF."<br/>";
        $strHtmlTopoDocumentoImpressao .= "CEP: ".$INST_ENDERECO_CEP." Tel.: ".$INST_TELEFONE;
    $strHtmlTopoDocumentoImpressao .= '</p>';
?>