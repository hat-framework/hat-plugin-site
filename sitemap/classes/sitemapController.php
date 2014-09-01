<?php 
class sitemapController extends \classes\Controller\Controller{
    public $model_name = LINK;    
    public function index() {
        $this->LoadModel($this->model_name, 'model')->createMap();
        $this->setVars($this->model->getMessages());
        $this->display('');
    }
}