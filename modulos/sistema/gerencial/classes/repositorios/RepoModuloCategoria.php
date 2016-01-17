<?php
    // codificação utf-8
    class RepoModuloCategoria{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoModuloCategoria();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strSQL  = "SELECT COUNT(*) AS Total FROM CAD_MCT_MODULOS_CATEGORIAS AS MC ";                
            }else{            
                $strSQL  = "SELECT MC.* FROM CAD_MCT_MODULOS_CATEGORIAS AS MC ";

                // permissões
                if(!empty($arrStrFiltros["GRU_ID"]) && !empty($arrStrFiltros["USU_ID"])){
                    $strSQL .= "INNER JOIN CAD_MOD_MODULOS AS M ON (M.MCT_ID = MC.MCT_ID) ";
                    $strSQL .= "INNER JOIN CAD_MFR_MODULOS_FORMULARIOS AS MF ON (MF.MOD_ID = M.MOD_ID) ";
                    $strSQL .= "INNER JOIN CAD_FRM_FORMULARIOS AS F ON (F.FRM_ID = MF.FRM_ID) ";
                    $strSQL .= "LEFT JOIN CAD_UPE_USUARIOS_PERMISSOES AS USU ON (USU.FRM_ID = F.FRM_ID) ";
                    $strSQL .= "LEFT JOIN CAD_GPE_GRUPOS_PERMISSOES AS GP ON (GP.FRM_ID = F.FRM_ID) ";
                }
            }
                
            $strSQL .= "WHERE MC.MCT_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["MCT_ID"])){
                $strSQL .= "AND MC.MCT_ID = ".$arrStrFiltros["MCT_ID"]." ";
            }
            
            // utilizado para gerar a exibição dos módulos
            // que o usuário pode acessar dependendo de suas permissões
            if(!empty($arrStrFiltros["GRU_ID"]) && !empty($arrStrFiltros["USU_ID"])){
                $strSQL .= "AND (USU.USU_ID = ".$arrStrFiltros["USU_ID"]." OR GP.GRU_ID = ".trim($arrStrFiltros["GRU_ID"]).") ";
            }

            if(!empty($arrStrFiltros["MCT_Descricao"])){
                $strSQL .= " AND MC.MCT_Descricao LIKE '%".trim($arrStrFiltros["MCT_Descricao"])."%' ";
            }

            if(!empty($arrStrFiltros["MCT_Status"])){
                $strSQL .= "AND MC.MCT_Status='".$arrStrFiltros["MCT_Status"]."' ";
            }
            
            if(empty($arrStrFiltros["TOT_Total"])){
                $strSQL .= "GROUP BY MC.MCT_ID ORDER BY MC.MCT_Ordem ASC";  
            }                      
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                 $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }  
    }
?>