<?php 
 use classes\Controller\CController;
class webserviceController extends CController{
    public $model_name = 'site/webservice';
    
    public function executeAll(){
        $webservices = $this->model->selecionar();
        $url         = $this->LoadResource('html', 'html')->getLink('site/webservice/execute', true, true);
        foreach($webservices as $webservice){
            $ws = str_replace("/", "|", $webservice['class']);
            simple_curl("$url/$ws&ajax=1");
        }
        $this->display('');
    }
    
    public function execute(){
        $class       = array_shift($this->vars);
        if($class == ""){die("Falha ao executar webservice! Não informado!");}
        if(is_numeric($class)){
            $item = $this->model->getItem($class);
            if(empty($item)){die("Falha ao executar webservice! Não informado!");}
            $class = $item['class'];
        }
        $bool = $this->executeService($class, $this->vars);
        $this->registerVar("status", ($bool)?"1":'0');
        $this->display('');
    }
    
            private function executeService($classe, $options){
                try{
                    $class = str_replace("|", "/", $classe);
                    $bool  = $this->LoadClassFromPlugin($class, 'cls')->execute($options);
                    $this->setVars($this->cls->getMessages());
                    return $bool;
                } catch (Exception $ex) {
                    $this->registerVar('erro', $ex->getMessage());
                    return false;
                }
            }
}