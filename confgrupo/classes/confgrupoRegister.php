<?php

use classes\Classes\Object;
class confgrupoRegister extends classes\Classes\Object{
    
    public function __construct() {
        $this->LoadModel('site/confgrupo', 'cmodel');
    }
    
    public function insertConfgrupo($dados){
        if(empty($dados)) {
            $this->setErrorMessage('Os dados de inserção das configurações estão vazios!');
            return false;
        }
        
        $where = "name = '{$dados['name']}'";
        $count = $this->cmodel->getCount($where);
        if($count != 0) {
            $item = @array_shift($this->cmodel->selecionar(array('cod_confgrupo'), $where));
            return $item['cod_confgrupo'];
        }
        $bool = $this->cmodel->inserir($dados); 
        if($bool === true) {
            $item = @array_shift($this->cmodel->selecionar(array('cod_confgrupo'), $where));
            return $item['cod_confgrupo'];
        }
        $this->setMessages($this->cmodel->getMessages());
        return $bool;
    }
    
}