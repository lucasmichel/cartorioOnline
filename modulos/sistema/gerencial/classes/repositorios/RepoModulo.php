<?php
    // codificação utf-8
    class RepoModulo{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoModulo();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){             
            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strSQL  = "SELECT COUNT(*) AS Total FROM CAD_MOD_MODULOS AS M ";                
            }else{            
                $strSQL  = "SELECT M.*, MCT.* FROM CAD_MOD_MODULOS AS M "; 
                $strSQL .= "INNER JOIN CAD_MCT_MODULOS_CATEGORIAS AS MCT ON (MCT.MCT_ID = M.MCT_ID) ";

                // permissões
                if(!empty($arrStrFiltros["GRU_ID"]) && !empty($arrStrFiltros["USU_ID"])){                
                    $strSQL .= "INNER JOIN CAD_MFR_MODULOS_FORMULARIOS AS MF ON (MF.MOD_ID = M.MOD_ID) ";
                    $strSQL .= "INNER JOIN CAD_FRM_FORMULARIOS AS F ON (F.FRM_ID = MF.FRM_ID) ";
                    $strSQL .= "LEFT JOIN CAD_UPE_USUARIOS_PERMISSOES AS USU ON (USU.FRM_ID = F.FRM_ID) ";
                    $strSQL .= "LEFT JOIN CAD_GPE_GRUPOS_PERMISSOES AS GP ON (GP.FRM_ID = F.FRM_ID) ";
                }
            }
            
            $strSQL .= "WHERE M.MOD_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["MOD_ID"])){
                $strSQL .= " AND M.MOD_ID = ".$arrStrFiltros["MOD_ID"]." ";
            }

            if(!empty($arrStrFiltros["MCT_ID"])){
                $strSQL .= " AND M.MCT_ID = ".$arrStrFiltros["MCT_ID"]." ";
            }
            
            // utilizado para gerar a exibição dos módulos
            // que o usuário pode acessar dependendo de suas permissões
            if(!empty($arrStrFiltros["GRU_ID"]) && !empty($arrStrFiltros["USU_ID"])){
                $strSQL .= "AND (USU.USU_ID = ".$arrStrFiltros["USU_ID"]." OR GP.GRU_ID = ".trim($arrStrFiltros["GRU_ID"]).") ";
            }

            if(!empty($arrStrFiltros["MOD_Descricao"])){                
                $strSQL .= " AND M.MOD_Descricao LIKE '%".trim($arrStrFiltros["MOD_Descricao"])."%' ";
            }

            if(!empty($arrStrFiltros["MOD_Status"])){
                $strSQL .= "AND M.MOD_Status='".$arrStrFiltros["MOD_Status"]."' ";
            }
            
            if(empty($arrStrFiltros["TOT_Total"])){
                $strSQL.= "GROUP BY M.MOD_ID ORDER BY M.MOD_Descricao ASC ";
            }
           
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
    }
?>