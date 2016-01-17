<?php


    // codificação utf-8
    class StringHelper{
        
        /*CONSTANTES PARA NORMALIZACAO DO NOME*/
        const NN_PONTO = '\.';
        const NN_PONTO_ESPACO = '. ';
        const NN_ESPACO = ' ';
        const NN_REGEX_MULTIPLOS_ESPACOS = '\s+';
        const NN_REGEX_NUMERO_ROMANO =
          '^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$';
        
        private static $objInstance;
               
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new StringHelper();                
            }
            
            return self::$objInstance;
        }
        
        public function toUpper($strTexto){
            $strTexto = str_replace("'", "", $strTexto);
            return mb_strtoupper(trim($strTexto), 'UTF-8');
        }
        
        public function removerAcentos($strString){
            $strString = htmlentities($strString, ENT_QUOTES, 'UTF-8');
            
            $arrStrPadrao = array (
                // vogais
                '/&agrave;/' => 'a',
                '/&egrave;/' => 'e',
                '/&igrave;/' => 'i',
                '/&ograve;/' => 'o',
                '/&ugrave;/' => 'u',
                
                // vogais
                '/&Agrave;/' => 'A',
                '/&Egrave;/' => 'E',
                '/&Igrave;/' => 'I',
                '/&Ograve;/' => 'O',
                '/&Ugrave;/' => 'U',

                '/&aacute;/' => 'a',
                '/&eacute;/' => 'e',
                '/&iacute;/' => 'i',
                '/&oacute;/' => 'o',
                '/&uacute;/' => 'u',
                
                '/&Aacute;/' => 'A',
                '/&Eacute;/' => 'E',
                '/&Iacute;/' => 'I',
                '/&Oacute;/' => 'O',
                '/&Uacute;/' => 'U',

                '/&acirc;/' => 'a',
                '/&ecirc;/' => 'e',
                '/&icirc;/' => 'i',
                '/&ocirc;/' => 'o',
                '/&ucirc;/' => 'u',
                
                '/&Acirc;/' => 'A',
                '/&Ecirc;/' => 'E',
                '/&Icirc;/' => 'I',
                '/&Ocirc;/' => 'O',
                '/&Ucirc;/' => 'U',

                '/&atilde;/' => 'a',
                '/&etilde;/' => 'e',
                '/&itilde;/' => 'i',
                '/&otilde;/' => 'o',
                '/&utilde;/' => 'u',
                
                '/&Atilde;/' => 'A',
                '/&Etilde;/' => 'E',
                '/&Itilde;/' => 'I',
                '/&Otilde;/' => 'O',
                '/&Utilde;/' => 'U',

                '/&auml;/' => 'a',
                '/&euml;/' => 'e',
                '/&iuml;/' => 'i',
                '/&ouml;/' => 'o',
                '/&uuml;/' => 'u',
                
                '/&Auml;/' => 'A',
                '/&Euml;/' => 'E',
                '/&Iuml;/' => 'I',
                '/&Ouml;/' => 'O',
                '/&Uuml;/' => 'U',

                '/&auml;/' => 'a',
                '/&euml;/' => 'e',
                '/&iuml;/' => 'i',
                '/&ouml;/' => 'o',
                '/&uuml;/' => 'u',
                
                '/&Auml;/' => 'A',
                '/&Euml;/' => 'E',
                '/&Iuml;/' => 'I',
                '/&Ouml;/' => 'O',
                '/&Uuml;/' => 'U',

                // outras letras e caracteres especiais
                '/&aring;/'  => 'a',
                '/&ntilde;/' => 'n',
                '/&ccedil;/' => 'c',
                '/&Ccedil;/' => 'C',
                '/&acute;/'  => '',
                '/&ordm;/'   => '',
                '/&ordf;/'   => ''
                
                // agregar mais caracteres se necessario
            );
 
            $strString = preg_replace(array_keys($arrStrPadrao), array_values($arrStrPadrao), $strString);
            return $strString;
        }
        
        public function removerTodaPontuacao($strTexto){
            $strTexto = str_replace(".", "", $strTexto);
            $strTexto = str_replace(",", "", $strTexto);
            $strTexto = str_replace("-", "", $strTexto);
            $strTexto = str_replace("/", "", $strTexto);
            $strTexto = str_replace(":", "", $strTexto);
            return $strTexto;
        }
        
        public function formatarTelefone($strTelefone){
            if(trim($strTelefone) != ""){
                $strPattern = '/(\d{2})(\d{4})(\d*)/';	
                return preg_replace($strPattern, '($1)$2.$3', $strTelefone);
            } else {
                return "";
            }
        }
        
        public function removerCaracteresParaBanco($strTexto){
            $strTexto = str_replace(" ", "", $strTexto);
            $strTexto = str_replace(".", "", $strTexto);
            $strTexto = str_replace(",", "", $strTexto);
            $strTexto = str_replace("(", "", $strTexto);
            $strTexto = str_replace(")", "", $strTexto);            
            $strTexto = str_replace("-", "", $strTexto);
            $strTexto = str_replace("/", "", $strTexto);
            
            return trim($strTexto);
        }
        
        public function formatarCPFouCNPJ($strCampo, $booFormatado = true){
            //retira formato
            $strCodigoLimpo = @ereg_replace("[' '-./ t]", '', $strCampo);
            
            // pega o tamanho da string menos os digitos verificadores
            $intTamanho = (strlen($strCodigoLimpo) - 2);
            
            //verifica se o tamanho do código informado é válido
            if ($intTamanho != 9 && $intTamanho != 12){
                return "00.000.000/0000-00"; 
            }

            if ($booFormatado){ 
                // seleciona a máscara para cpf ou cnpj
                $strMascara = ($intTamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 

                $intIndice = -1;
                
                for ($intI=0; $intI < strlen($strMascara); $intI++) {
                    if ($strMascara[$intI] == '#') $strMascara[$intI] = $strCodigoLimpo[++$intIndice];
                }
                
                //retorna o campo formatado
                $strRetorno = $strMascara;
            }else{
                //se não quer formatado, retorna o campo limpo
                $strRetorno = $strCodigoLimpo;
            }

            return $strRetorno;
        }
        
        public function formatarCEP($strCep){
            $strCepFormatado = "";
            
            if(trim($strCep) != ""){
                for($intI=0; $intI<strlen($strCep); $intI++){
                    $strCepFormatado .= $strCep[$intI];
                    
                    if($intI == 4){
                        $strCepFormatado .= "-";
                    }
                }
            }
            
            return $strCepFormatado;
        }
        
        public function substituirEspacoPorUnderline($strTexto){
            return str_replace(" ", "_", $strTexto);
        }
        
        // retira quebra de linha de componentes de texto (Ex.: Textarea)
        public function br2nl($strTexto){           
            return strip_tags($strTexto);
        }
        
        
        
        
        
        
        

        /*
        *    function str_reduce (str $str, int $max_length [, str $append [, int $position [, bool $remove_extra_spaces ]]])
        *
        *    @return string
        *
        *    Reduz uma string sem cortar palavras ao meio. Pode-se reduzir a string pela
        *    extremidade direita (padrão da função), esquerda, ambas ou pelo centro. Por
        *    padrão, serão adicionados três pontos (...) à parte reduzida da string, mas
        *    pode-se configurar isto através do parâmetro $append.
        *    Mantenha os créditos da função.
        *
        *    @autor: Carlos Reche
        *    @data:  Jan 21, 2005
        */
        /*
        define("STR_REDUCE_LEFT", 1);
        define("STR_REDUCE_RIGHT", 2);
        define("STR_REDUCE_CENTER", 4);
        */
        
        function str_reduce($str, $max_length, $append = NULL, $position = 2, $remove_extra_spaces = true)
        {
            
            $STR_REDUCE_LEFT = 1;
            $STR_REDUCE_RIGHT = 2;
            $STR_REDUCE_CENTER = 4;
            
            if (!is_string($str))
            {
                echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "() expects parameter 1 to be string.";
                return false;
            }
            else if (!is_int($max_length))
            {
                echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "() expects parameter 2 to be integer.";
                return false;
            }
            else if (!is_string($append)  &&  $append !== NULL)
            {
                echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "() expects optional parameter 3 to be string.";
                return false;
            }
            else if (!is_int($position))
            {
                echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "() expects optional parameter 4 to be integer.";
                return false;
            }
            else if (($position != $STR_REDUCE_LEFT)  &&  ($position != $STR_REDUCE_RIGHT)  &&
                     ($position != $STR_REDUCE_CENTER)  &&  ($position != ($STR_REDUCE_LEFT | $STR_REDUCE_RIGHT)))
            {
                echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "(): The specified parameter '" . $position . "' is invalid.";
                return false;
            }


            if ($append === NULL)
            {
                $append = "...";
            }


            $str = html_entity_decode($str);


            if ((bool)$remove_extra_spaces)
            {
                $str = preg_replace("/\s+/s", " ", trim($str));
            }


            if (strlen($str) <= $max_length)
            {
                return htmlentities($str);
            }


            if ($position == $STR_REDUCE_LEFT)
            {
                $str_reduced = preg_replace("/^.*?(\s.{0," . $max_length . "})$/s", "\\1", $str);

                while ((strlen($str_reduced) + strlen($append)) > $max_length)
                {
                    $str_reduced = preg_replace("/^\s?[^\s]+(\s.*)$/s", "\\1", $str_reduced);
                }

                $str_reduced = $append . $str_reduced;
            }


            else if ($position == $STR_REDUCE_RIGHT)
            {
                $str_reduced = preg_replace("/^(.{0," . $max_length . "}\s).*?$/s", "\\1", $str);

                while ((strlen($str_reduced) + strlen($append)) > $max_length)
                {
                    $str_reduced = preg_replace("/^(.*?\s)[^\s]+\s?$/s", "\\1", $str_reduced);
                }

                $str_reduced .= $append;
            }


            else if ($position == ($STR_REDUCE_LEFT | $STR_REDUCE_RIGHT))
            {
                $offset = ceil((strlen($str) - $max_length) / 2);

                $str_reduced = preg_replace("/^.{0," . $offset . "}|.{0," . $offset . "}$/s", "", $str);
                $str_reduced = preg_replace("/^[^\s]+|[^\s]+$/s", "", $str_reduced);

                while ((strlen($str_reduced) + (2 * strlen($append))) > $max_length)
                {
                    $str_reduced = preg_replace("/^(.*?\s)[^\s]+\s?$/s", "\\1", $str_reduced);

                    if ((strlen($str_reduced) + (2 * strlen($append))) > $max_length)
                    {
                        $str_reduced = preg_replace("/^\s?[^\s]+(\s.*)$/s", "\\1", $str_reduced);
                    }
                }

                $str_reduced = $append . $str_reduced . $append;
            }


            else if ($position == $STR_REDUCE_CENTER)
            {
                $pattern = "/^(.{0," . floor($max_length / 2) . "}\s)|(\s.{0," . floor($max_length / 2) . "})$/s";

                preg_match_all($pattern, $str, $matches);

                $begin_chunk = $matches[0][0];
                $end_chunk   = $matches[0][1];

                while ((strlen($begin_chunk) + strlen($append) + strlen($end_chunk)) > $max_length)
                {
                    $end_chunk = preg_replace("/^\s?[^\s]+(\s.*)$/s", "\\1", $end_chunk);

                    if ((strlen($begin_chunk) + strlen($append) + strlen($end_chunk)) > $max_length)
                    {
                        $begin_chunk = preg_replace("/^(.*?\s)[^\s]+\s?$/s", "\\1", $begin_chunk);
                    }
                }

                $str_reduced = $begin_chunk . $append . $end_chunk;
            }


            return htmlentities($str_reduced);
        }
        
        
        
        
        
        
        
        /*
        *    function normalizarNome (str $nome)
        *
        *    @return string
        *
        *    Transforma um nome pessoal em um nome com  as primeiras palavras maiúsculas        
        *
        *    @autor: Lucas Michel
        *    @data:  Jan 25, 2015
        */
        
        /**
        * Normaliza o nome próprio dado, aplicando a capitalização correta de acordo
        * com as regras e exceções definidas no código.
        * POR UMA DECISÃO DE PROJETO, FORAM UTILIZADAS FUNÇÕES MULTIBYTE (MB_) SEMPRE
        * QUE POSSÍVEL, PARA GARANTIR SUA USABILIDADE EM STRINGS UNICODE.
        * @param string $nome O nome a ser normalizado
        * @return string O nome devidamente normalizado
        */
        
        function normalizarNome($nome){
            
               /*
                * A primeira tarefa da normalização é lidar com partes do nome que
                * porventura estejam abreviadas,considerando-se para tanto a existência de
                * pontos finais (p. ex. JOÃO A. DA SILVA, onde "A." é uma parte abreviada).
                * Dado que mais à frente dividiremos o nome em partes tomando em
                * consideração o caracter de espaço (" "), precisamos garantir que haja um
                * espaço após o ponto. Fazemos isso substituindo todas as ocorrências do
                * ponto por uma sequência de ponto e espaço.
                */
               $nome = mb_ereg_replace(self::NN_PONTO, self::NN_PONTO_ESPACO, $nome);

               /*
                * O procedimento anterior, ou mesmo a digitação errônea, podem ter
                * introduzido espaços múltiplos entre as partes do nome, o que é totalmente
                * indesejado. Para corrigir essa questão, utilizamos uma substituição
                * baseada em expressão regular, a qual trocará todas as ocorrências de
                * espaços múltiplos por espaços simples.
                */
               $nome = mb_ereg_replace(self::NN_REGEX_MULTIPLOS_ESPACOS, self::NN_ESPACO,
                 $nome);

               /*
                * Isso feito, podemos fazer a capitalização "bruta", deixando cada parte do
                * nome com a primeira letra maiúscula e as demais minúsculas. Assim,
                * JOÃO DA SILVA => João Da Silva.
                */
               $nome = mb_convert_case($nome, MB_CASE_TITLE, mb_detect_encoding($nome));

               /*
                * Nesse ponto, dividimos o nome em partes, para trabalhar com cada uma
                * delas separadamente.
                */
               $partesNome = mb_split(self::NN_ESPACO, $nome);

               /*
                * A seguir, são definidas as exceções à regra de capitalização. Como
                * sabemos, alguns conectivos e preposições da língua portuguesa e de outras
                * línguas jamais são utilizadas com a primeira letra maiúscula.
                * Essa lista de exceções baseia-se na minha experiência pessoal, e pode ser
                * adaptada, expandida ou mesmo reduzida conforme as necessidades de cada
                * caso.
                */
               $excecoes = array(
                 'de', 'di', 'do', 'da', 'dos', 'das', 'dello', 'della',
                 'dalla', 'dal', 'del', 'e', 'em', 'na', 'no', 'nas', 'nos', 'van', 'von',
                 'y'
               );

               for($i = 0; $i < count($partesNome); ++$i) {

                 /*
                  * Verificamos cada parte do nome contra a lista de exceções. Caso haja
                  * correspondência, a parte do nome em questão é convertida para letras
                  * minúsculas.
                  */
                 foreach($excecoes as $excecao)
                   if(mb_strtolower($partesNome[$i]) == mb_strtolower($excecao))
                     $partesNome[$i] = $excecao;

                 /*
                  * Uma situação rara em nomes de pessoas, mas bastante comum em nomes de
                  * logradouros, é a presença de numerais romanos, os quais, como é sabido,
                  * são utilizados em letras MAIÚSCULAS.
                  * No site
                  * http://htmlcoderhelper.com/how-do-you-match-only-valid-roman-numerals-with-a-regular-expression/,
                  * encontrei uma expressão regular para a identificação dos ditos
                  * numerais. Com isso, basta testar se há uma correspondência e, em caso
                  * positivo, passar a parte do nome para MAIÚSCULAS. Assim, o que antes
                  * era "Av. Papa João Xxiii" passa para "Av. Papa João XXIII".
                  */
                 if(mb_ereg_match(self::NN_REGEX_NUMERO_ROMANO,
                   mb_strtoupper($partesNome[$i])))
                   $partesNome[$i] = mb_strtoupper($partesNome[$i]);
               }

               /*
                * Finalmente, basta juntar novamente todas as partes do nome, colocando um
                * espaço entre elas.
                */
               return implode(self::NN_ESPACO, $partesNome);

        }
             
        public function imprimeTextoVertical($texto){
            $strRetorno = "";
            $arrPalavras = explode(" ", trim($texto));
            
            foreach ($arrPalavras as $palavra){
                $palavraSemAcento = $this->removerAcentos($palavra);                
                
                $n_caracteres = strlen($palavraSemAcento);                                
                for( $i=0; $i < $n_caracteres ; $i++ ){                    
                    //$letra = mb_strtoupper($palavra[$i], "UTF-8");
                    //$strRetorno .= $letra."<br/>";
                    $strRetorno .= $palavraSemAcento[$i]."<br>";
                }
                /*if(count($arrPalavras) > 1){
                    $strRetorno .= "<br/>";                    
                }*/
            }            
            return $strRetorno;
        }
             
    }
    
    
?>