<?php
    // codificação utf-8
    class PessoaEmail{
        private $id;
        private $pessoa;
        private $email;
        
        public function getId() {
            return $this->id;
        }

        public function getPessoa() {
            return $this->pessoa;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setPessoa($pessoa) {
            $this->pessoa = $pessoa;
        }

        public function setEmail($email) {
            $this->email = $email;
        }
        
    }
?>