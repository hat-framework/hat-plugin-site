<?php 
 use classes\Controller\CController;
class menuController extends CController{
    public $model_name = 'site/menu';
    
    public function show($display = true, $link = "") {
        Redirect(LINK);
    }
    
    public function reorder(){
        if(!isset($_POST['order'])) return;
        $bool = $this->model->reordernar($_POST['order']);
        $var = $this->model->getMessages();
        $var['status'] = ($bool)?"1":"0";
        die(json_encode($var));
    }
    
    public function load(){
        if(!isset($_POST['post'])) return;
        $bool = $this->model->LoadItem($_POST['post']);
        $var = $this->model->getMessages();
        $var['status'] = ($bool)?"1":"0";
        die(json_encode($var));
    }
}