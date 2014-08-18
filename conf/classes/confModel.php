<?php 
class site_confModel extends \classes\Model\Model{
    public $tabela = "site_conf";
    public $pkey   = 'cod_conf';
    public function inserir($dados) {
        if(!isset($dados['value'])) {$dados['value'] = "";}
        $dados['value_default'] = $dados['value'];
        return parent::inserir($dados);
    }
}