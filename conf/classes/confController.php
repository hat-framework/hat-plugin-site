<?php 
 use classes\Controller\CController;
class confController extends CController{
    
    public $model_name = 'site/conf';
    
    public function show($display = true, $link = "") {
        Redirect('site/conffile/show/'.$this->item['__file']);
        //parent::show($display, $link);
    }
    
    public function formulario($display = true, $link = "") {
        $this->prevent_redirect();
        parent::formulario($display, $link);
        $status = $this->getVar('status');
        if($status == '1'){
            $this->redirect('venda/conffile/show');
        }
        
    }
    
}