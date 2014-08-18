<?php 
use classes\Classes\EventTube;
class configuracaoAdmin extends \classes\Controller\Controller{
    public $model_name = LINK;
    
    public function AfterLoad() {
        $this->LoadModel($this->model_name, 'model');
        $this->LoadModel('site/confgrupo', 'gr');
        $arr = $this->gr->genMenu();
        
        $this->LoadJsPlugin('menu/multiple', 'mt');
        $this->mt->imprime();
        $var = (!empty ($arr))?$this->mt->draw($arr):
            "<b>Caro usuário</b>, não existe nenhum grupo de configurações no qual você tenha sido registrado";

        $title = 'Minhas Configurações';
        EventTube::addEvent('menu-lateral', "<h3>$title</h3>$var");
    }
    
    public function index() {
        $this->display('');
    }
    
    public function group(){
        if(!isset($this->vars[0]) || empty($this->vars[0])) Redirect (LINK);
        $cod = $this->vars[0];
        $this->registerVar('grupo', $this->gr->getItem($cod));
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

}
?>