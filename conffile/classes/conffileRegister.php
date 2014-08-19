<?php

use classes\Classes\Object;
class conffileRegister extends classes\Classes\Object{
    
    public function __construct() {
        $this->LoadClassFromPlugin('site/confgrupo/confgrupoRegister', 'confgrupo');
        $this->LoadClassFromPlugin('site/conf/confRegister', 'cf');
        $this->LoadModel('site/conffile', 'cfmodel');
    }
    
    private $cod_plugin, $plugin, $type = "";
    public function initPlugin($plugin, $cod_plugin){
        $this->plugin     = $plugin;
        $this->cod_plugin = $cod_plugin;
        $this->type       = 'plugin';
    }
    
    public function insertConffile($dados, $path){
        if(empty($dados)) {
            $this->setErrorMessage('Os dados de inserção das configurações estão vazios!');
            return false;
        }
        
        if(!isset($dados['grupo'])){
            print_r($dados);
            die("A variável grupo não foi configurada corretamente no arquivo de configurações: \"{$dados['title']}\"");
        }
        
        $cod_grupo = $this->confgrupo->insertConfgrupo(array('name' => $dados['grupo']));
        if($cod_grupo === false) {
            $this->setMessages($this->confgrupo->getMessages());
            return false;
        }

        $configs = array();
        if(isset($dados['configs'])){
            $configs = $dados['configs'];
            unset($dados['configs']);
        }
        
        $cod_conffile = $this->getCod($dados, $cod_grupo, $path);
        if($cod_conffile === false) return false;
        
        //insere as entradas das configurações
        foreach($configs as &$conf){
            if(!$this->cf->insertData($conf, $cod_conffile)){
                $this->setMessages($this->cf->getMessages());
                return false;
            }
        }
        if(!$this->createFile($cod_conffile, $configs)) return false;
        
        
        return true;
    }
    
    public function reset(){
        $this->plugin = "";
    }
    
    /**
     * Retorna o código do arquivo de configurações
     */
    private function getCod($dados, $cod_confgrupo, $path){
        
        //filtra os dados de acordo com o tipo de configuração
        $method = $this->type;
        $dados['cod_confgrupo'] = $cod_confgrupo;
        $dados['path']          = $path;
        if(method_exists($this, $method))$this->$method($dados);
        
        //verifica se já existe um dado com o título passado, insere caso não exista
        //edita caso exista
        $title = $dados['title'];
        $item = $this->cfmodel->getItem($title,"title");
        if(empty($item)){
            $bool = $this->cfmodel->inserir($dados);
            if($bool === false){
                $this->setMessages($this->cfmodel->getMessages());
                return false;
            }
        }else{
            if(!$this->cfmodel->editar($item['cod_cfile'], $dados)){
                $this->setMessages($this->cfmodel->getMessages());
                return false;
            }
            $bool = $item['cod_cfile'];
        }
        if($bool !== false){
            $item = $this->cfmodel->getItem($title,"title",true);
            $this->createFolder($item);
            return $item['cod_cfile'];
        }else {
            print_r($dados);
            die("Erro ao criar arquivo de configuração $title ");
        }
        
        return $bool;
    }
    
    private function plugin(&$dados){
        $dados['cod_plugin'] = $this->cod_plugin;
        $dados['referencia'] = $this->plugin;
        $dados['type']       = $this->type;
    }
    
    public function createFolder($dados){
        if($dados['visibilidade'] == 'usuario') return true;
        $exp      = explode("/", $dados['path']);
        $subdir   = array_shift($exp);
        //$filename = end($exp);
        $location = DIR_CONFIG_SUBDOMAIN . $dados['type']."/";
        getTrueDir($location);
        $this->LoadResource('files/dir', 'dobj');
        //die($location);
        if(!$this->dobj->create($location, $subdir, 0777)){
            die(__CLASS__. "<hr/>".$this->dobj->getErrorMessage());
            $this->setMessages($this->dobj->getMessages());
            return false;
        }
        return true;
    }
    
    public function createFile($cod_conffile, $configs){
        $this->LoadResource('files/file', 'fobj');
        $dados    = $this->cfmodel->getItem($cod_conffile);
        $exp      = explode("/", $dados['path']);
        $subdir   = array_shift($exp);
        $filename = end($exp);
        $location = DIR_CONFIG_SUBDOMAIN . $dados['type']."/$subdir/$filename.php";
        $str      = $this->getStr($configs, $dados);
        if(false === $this->fobj->savefile($location, $str)){
            $this->setMessages($this->fobj->getMessages());
            return false;
        }
        return true;
    }
    
    private function getStr($configs, $dados){
        $str     = "<?php\n\n";
        foreach($configs as $codc => $conff){
            $const_name = $const_value = "";
            $this->detectData($conff, $codc, $dados, $const_name,$const_value);
            if($const_name == "") {die("Variável constname não pode ser vazia!");}
            //if(CURRENT_ACTION === "" && defined($const_name)){$const_value = constant($const_name);}
            if($const_value == 'true' || $const_value == 'false'){
                  $str .= "\t if(!defined('$const_name')) define('$const_name', $const_value); \n";
            }else{ $str .= "\t if(!defined('$const_name')) define('$const_name', '$const_value'); \n";}
        }
        return $str;
    }
    
            private function detectData($conff, $codc, &$dados, &$const_name,&$const_value){
                if(is_array($conff) && array_key_exists('name',$conff)) {
                    $const_name  = $conff['name'];
                    $const_value = isset($conff['value'])?$conff['value']:"";
                    return;
                }
                
                foreach($dados['configs'] as $t => $data){
                    if($codc != $data['cod_conf']) {continue;}
                    $const_name = $data['name'];
                    $const_value = $conff;
                    unset($dados[$t]);
                    break;
                }
            }
    
}