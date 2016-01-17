<?php
    // codificação utf-8
    class UploadHelper{
        private static $objInstance;
               
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new UploadHelper();                
            }
            
            return self::$objInstance;
        }
        
        /*
         * $arrStrInformacoesArquivo é equivalente ao FILES
         * 
         */
        public function upload($arrStrInformacoesArquivo, $strDiretorio, $arrStrTipos = null, $strNome = null){
            $arrStrRetorno = array();
            $arrStrRetorno["sucesso"] = false;
            
            if(isset($arrStrInformacoesArquivo)){
                if(count($arrStrInformacoesArquivo) > 0){
                    if(isset($arrStrInformacoesArquivo["name"])){
                        $arrStrInfos     = explode(".", $arrStrInformacoesArquivo["name"]);
                        $strNomeOriginal = "";
                                                
                        if(!$strNome){
                            for($intI = 0; $intI < count($arrStrInfos) - 1; $intI++){
                                $strNomeOriginal = $strNomeOriginal . $arrStrInfos[$intI] . ".";
                            }
                        }else{
                            $strNomeOriginal = $strNome . ".";
                        }
                        
                        $strTipoArquivo    = $arrStrInfos[count($arrStrInfos) - 1];
                        $boolTipoPermitido = false;
                        $strTipo           = null;
                        
                        if($arrStrTipos != null){
                            foreach($arrStrTipos as $strTipo){
                                if(strtolower($strTipoArquivo) == strtolower($strTipo)){
                                    $boolTipoPermitido = true;
                                }
                            }
                        }else{
                            // permite a liberação quando pretende anexar todos os tipos de arquivo
                            $boolTipoPermitido = true;
                        }
                        
                        
                        /*var_dump($strNomeOriginal);
                        die();*/
                        
                        if(!$boolTipoPermitido){
                            $arrStrRetorno["erro"] = "Tipo nao permitido";
                        }else{
                            if(move_uploaded_file($arrStrInformacoesArquivo['tmp_name'], $strDiretorio . $strNomeOriginal . $strTipoArquivo)){
                                $arrStrRetorno["caminho"] = $strDiretorio . $strNomeOriginal . $strTipoArquivo;
                                $arrStrRetorno["sucesso"] = true;
                                $arrStrRetorno["arquivo"] = $strNomeOriginal . $strTipoArquivo;
                            }else{
                                $arrStrRetorno["erro"] = "Erro ao fazer upload";
                            }
                        }
                    }
                }else{
                    $arrStrRetorno["erro"] = "Arquivo vazio";
                }
            }else{
                $arrStrRetorno["erro"] = "Arquivo nao inicializado";
            }
            
            return $arrStrRetorno;
        } 
        
        public function multipleUpload($arquivo, $pasta, $tipos, $nome = null){
            $arrStrRetorno = array();
            $arrStrRetorno["sucesso"] = false;
            
            if(isset($arquivo)){
		if(is_array( $arquivo["name"])){
                    for($intI = 0; $intI<count($arquivo["name"])  ;$intI++){
                        $infos = explode(".", $arquivo["name"][$intI]);
                        $nomeOriginal = null;
                        if(!$nome){
                            for($i = 0; $i < count($infos) - 1; $i++){
                                    $nomeOriginal = $nomeOriginal . $infos[$i] . ".";
                            }
                        }
                        else{
                            $nomeOriginal = $nome . ".";
                        }

                        $tipoArquivo = $infos[count($infos) - 1];
                        $tipoPermitido = false;

                        foreach($tipos as $tipo){
                            if(strtolower($tipoArquivo) == strtolower($tipo)){
                                $tipoPermitido = true;
                            }
                        }
                        if(!$tipoPermitido){
                            $arrStrRetorno["erro"][] = "Tipo não permitido";
                        }
                        else{
                            if(move_uploaded_file($arquivo['tmp_name'][$intI], $pasta . $nomeOriginal . $tipoArquivo)){
                                $retorno["caminho"][] = $pasta . $nomeOriginal . $tipoArquivo;
                                $arrStrRetorno["caminho"][] = $pasta . DIRECTORY_SEPARATOR . $nomeOriginal . $tipoArquivo;
                                $arrStrRetorno["sucesso"][] = true;
                                $arrStrRetorno["arquivo"][] = $nomeOriginal . $tipoArquivo;
                            }
                            else{
                                $arrStrRetorno["erro"] = "Erro ao fazer upload";
                            }
                        }
                    }
		}
            }
            else{
                $arrStrRetorno["erro"] = "Arquivo nao inicializado";
            }
            return $arrStrRetorno;
        }
    }
?>