<?php
    // codificação utf-8
    interface InterfaceDatabase{
        public function select($strSQL);
        public function executar($strSQL);
        public function getLastId();
    }
?>