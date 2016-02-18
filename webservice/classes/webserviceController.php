<?php 
 use classes\Controller\CController;
class webserviceController extends CController{
    public $model_name = 'site/webservice';
    
    public function execute(){
        $webservices = array();
        $class       = array_shift($this->vars);
        if($class != ""){
            $bool = $this->executeService($class, $this->vars);
            $this->registerVar("status", ($bool)?"1":'0');
        }
        else{$this->executeAllWebServices($class, $webservices);}
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
    
            private function executeAllWebServices($webservices){
                $url = $this->LoadResouce('html', 'html')->getLink('site/webservice/execute');
                foreach($webservices as $webservice){
                    $webservice = str_replace("/", "|", $webservice);
                    simple_curl("$url/$webservice");
                }
                return true;
            }
}