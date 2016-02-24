<?php 
 use classes\Controller\CController;
class webserviceController extends CController{
    public $model_name = 'site/webservice';
    public $logname    = 'webservice/executeAll';
    public function executeAll(){
        classes\Utils\Log::save($this->logname, "Executando lista de webservices");
        $webservices = $this->model->selecionar();
        $url         = $this->LoadResource('html', 'html')->getLink('site/webservice/execute', true, true);
        foreach($webservices as $webservice){
            $this->run($webservice, $url);
        }
        classes\Utils\Log::save($this->logname, "Execussão de webservices concluída com sucesso!");
        $this->display('');
    }
    
            private function run($webservice, $url){
                classes\Utils\Log::save($this->logname, "Executando {$webservice['class']}");
                $ws  = str_replace("/", "|", $webservice['class']);
                $val = simple_curl("$url/$ws&ajax=1");
                $var = json_decode($val, true);
                if(!$var){
                    return classes\Utils\Log::save($this->logname, "Ocorreu algum erro no webservice <br/> Detalhes: $val");
                }
                if($var['status'] == 0){
                    $erro = isset($var['erro'])?$var['erro']:"O webservice retornou status erro mas não especificou uma mensagem de erro!";
                    return classes\Utils\Log::save($this->logname, "O webservice encontrou alguns erros <br/> $erro");
                }

                $success = isset($var['erro'])?$var['erro']:"O webservice retornou status success mas não especificou uma mensagem de sucesso!";
                classes\Utils\Log::save($this->logname, "O webservice executou corretamente <br/> $success");
            }
    
    public function execute(){
        $class       = array_shift($this->vars);
        if($class == ""){
            $this->registerVar('erro'  , "Falha ao executar webservice! Não informado!");
            $this->registerVar('status', "0");
            return $this->display('');
        }
        if(is_numeric($class)){
            $item = $this->model->getItem($class);
            if(empty($item)){
                $this->registerVar('erro'  , "Falha ao executar webservice! Não informado!");
                $this->registerVar('status', "0");
                return $this->display('');
            }
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