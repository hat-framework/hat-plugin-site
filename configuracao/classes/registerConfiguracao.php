<?php

use classes\Classes\Object;
class registerConfiguracao extends classes\Classes\Object{
    
    private $obj   = null;
    private $files = array();
    private $sufixo_class = "Configurations";
    public function __construct() {
        //inicializa os objetos a serem usados pela classe
        $this->LoadClassFromPlugin('site/conffile/conffileRegister', 'cfile');
        
    }
    
    public function register($type, $plugin, $cod_plugin = ""){
        if(!$this->LoadConfigClass($type, $plugin)) {return true;}
        if(!$this->init($type, $cod_plugin)) { return false;}
        if($type == 'plugin') $this->cfile->initPlugin($plugin, $cod_plugin);
        $bool = true;
        foreach($this->files as $path => $arr){
            if(!$this->cfile->insertConffile($arr, $path)){
                $this->setMessages($this->cfile->getMessages());
                $bool = false;
            }
        }
        $this->cfile->reset();
        return $bool;
    }
    
            private function init($type, $cod_plugin){
                $this->type       = $type;
                $this->cod_plugin = $cod_plugin;
                $this->files      = $this->obj->getFiles();
                return true;
            }
    
            private function LoadConfigClass($type, $plugin){

                //carrega arquivos de configuração
                if($type === "resource"){$this->LoadConfigFromResource($plugin);}
                elseif($type === 'plugin'){$this->LoadConfigFromPlugin($plugin);}

                //recupera as informações do arquivo
                $file = $class = "";
                $this->getFileName($plugin, $type, $class, $file);

                //carrega o arquivo
                if(!file_exists($file)) {return false;}
                require_once $file;

                //carrega a classe
                if(!class_exists($class)) {return false;}

                $this->obj = new $class();
                if(!$this->obj instanceof \classes\Classes\Options) {
                    $this->setErrorMessage("A classe $class não é uma instância da classe Options.");
                    return false;
                }
                return true;
            }

                    private function getFileName($plugin, $type, &$class, &$file){
                        $sufixo = $this->sufixo_class;
                        switch ($type){
                            case 'config':
                                $class = "config{$sufixo}";
                                $file  = CONFIG . "$class.php";
                                break;
                            case 'jsplugin':
                                $exp      = explode('/', $plugin);
                                $recurso  = $exp[0];
                                $jsplugin = $exp[1];
                                $class    = "{$jsplugin}{$sufixo}";
                                $file     = classes\Classes\Registered::getResourceLocation($recurso, true)."/src/jsplugin/$jsplugin/config/{$class}.php";
                                break;
                            case 'resource':
                                $exp      = explode('/', $plugin);
                                $recurso  = str_replace('hat-resource-', "", $exp[0]);
                                $recname  = (isset($exp[1])? $exp[1]:$exp[0]);
                                $class = "{$recname}{$sufixo}";
                                $file  = classes\Classes\Registered::getResourceLocation($recurso, true). "/src/config/{$class}.php";
                                //die("($plugin) - ($sufixo) - ($file) - ($class)");
                                break;
                            case 'plugin': /*vazio*/
                            case 'template':
                                $class  = "{$plugin}{$sufixo}";
                                $file = \classes\Classes\Registered::getTemplateLocation($plugin, true) . "/Config/{$class}.php";
                                break;          
                        }
                        getTrueDir($file);
                    }

}