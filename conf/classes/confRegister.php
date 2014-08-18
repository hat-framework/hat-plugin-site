<?php

use classes\Classes\Object;
class confRegister extends classes\Classes\Object{
    
    public function __construct() {
        $this->LoadModel('site/conf', 'cmodel');
    }
    
    public function insertData(&$dados, $cod_conffile){
        
        if(empty($dados)) {
            $this->setErrorMessage('Os dados de inserção das configurações estão vazios!');
            return false;
        }
        
        if($dados['type'] === 'enum' && is_array($dados['options'])){
            $out = "";
            foreach($dados['options'] as $key => $value){
                $out .= "'$key'=>'$value',";
            }
            $dados['options'] = $out;
        }
        $dados['file']  = $cod_conffile;
        $name           = $dados['name'];
        $this->getValue($dados);
        $item           = $this->cmodel->getItem($name,"name");
        if(empty($item)){
            $bool = $this->cmodel->inserir($dados);
            if($bool === false){
                $this->setMessages($this->cmodel->getMessages());
                return false;
            }
        }else{
            //if que não deveria entrar nunca!
            if(!isset($item['cod_conf'])){
                return $this->setErrorMessage('O grupo da configuração não foi setado! A configuração não será registrada!');
            }
            if(!$this->cmodel->editar($item['cod_conf'], $dados)){
                $this->setMessages($this->cmodel->getMessages());
                return false;
            }
            $bool = $item['cod_conf'];
        }
       
        if($bool === true){
            $item = $this->cmodel->getItem($name,"name");
            return $item['cod_conf'];
        }
        
        return ($bool !== false);
    }
    
    private function getValue(&$dados){
        $name = $dados['name'];
        if(!isset($dados['value']) || $dados['value_default'] === ""){
            $dados['value'] = isset($dados['value_default'])?$dados['value_default']:"";
        }
        $value          = getConstantValue($name);
        $value          = ($value === true)?'true':$value;
        $value          = ($value === false)?'false':$value;
        $dados['value'] = ($value === "")?$dados['value']:$value;
        $dados['value'] = ($dados['value'] === "" && isset($dados['default']))?$dados['default']:$dados['value'];
        $dados['value'] = ($dados['value'] === true)?'true':$dados['value'];
        $dados['value'] = ($dados['value'] === false)?'false':$dados['value'];
        //echoBr("{$dados['name']}-{$dados['value']}-$value");
    }
    
}