<?php 
use classes\Classes\EventTube;
class configuracaoController extends \classes\Controller\Controller{
    public $model_name = LINK;
    
    public function AfterLoad() {
        $this->LoadModel($this->model_name, 'model');
        $this->menu = $this->LoadModel('site/confgrupo', 'gr')->genMenu();
    }
    
    public function index() {
        if(usuario_loginModel::IsWebmaster()){$this->gr->findNewGroups();}
        $this->registerVar('configuracoes', $this->menu);
        $this->display(LINK . "/allgroups");
    }
    
    public function group(){
        if(!isset($this->vars[0]) || empty($this->vars[0])) Redirect (LINK);
        $cod = $this->vars[0];
        $item = $this->gr->getItem($cod);
        if(empty($item)) Redirect (LINK);
        $this->registerVar('grupo', $item);
        $this->registerVar('files', $this->model->LoadFiles($cod));
        $this->display(LINK ."/group");
    }
    
    public function configure(){
        if(!isset($this->vars[0]) || empty($this->vars[0])) Redirect (LINK);
        $cod = $this->vars[0];
        if(!empty($_POST)){
            $bool = $this->model->saveConfig($cod, $_POST);
            $arr = $this->model->getMessages();
            $arr['status'] = ($bool === false)?'0':'1';
        }else{
            $arr['status'] = '0';
            $arr['Erro']   = 'Nenhum dado enviado!';
        }
        $arr['is_editing'] = '1';
        die(json_encode($arr));
    }
    
    
    public function restore(){
        if(!isset($this->vars[0]) || empty($this->vars[0])) Redirect (LINK);
        $cod = $this->vars[0];
        $bool = $this->model->setDefaultConfig($cod);
        $arr = $this->model->getMessages();
        $arr['status'] = ($bool === false)?'0':'1';
        die(json_encode($arr));
    }
    
}
