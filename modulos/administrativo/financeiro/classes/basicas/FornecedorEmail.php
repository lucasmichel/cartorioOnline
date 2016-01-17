<?php
    // codificação utf-8
    class FornecedorEmail{
        private $id;
        private $fornecedor;
        private $email;
        
        public function getId() {
            return $this->id;
        }

        public function getFornecedor() {
            return $this->fornecedor;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setFornecedor($fornecedor) {
            $this->fornecedor = $fornecedor;
        }

        public function setEmail($email) {
            $this->email = $email;
        }


    }
?>