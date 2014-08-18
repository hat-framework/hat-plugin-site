<?php

use classes\Classes\EventTube;
use classes\Classes\cookie;
class site_menuModel extends \classes\Model\Model {

    public $tabela = "site_menu";
    public $pkey   = "cod_menu";

    public function inserir($dados) {
        cookie::destroy($this->cookiename);
        if(isset($dados['menu'])) {$dados['menuid'] = GetPlainName($dados['menu']);}
        return parent::inserir($dados);
    }
    
    public function editar($id, $post, $camp = "") {
        cookie::destroy($this->cookiename);
        if((!isset($post['menuid']) || trim($post['menuid']) === "") && isset($post['menu'])){
            $post['menuid'] = GetPlainName($post['menu']);
        }
        return parent::editar($id, $post, $camp);
    }
    
    public function getDados() {
        $var = parent::getDados();
        if(CURRENT_ACTION == 'index' && LINK == 'site/menu'){
            $this->LoadModel('usuario/login', 'uobj');
            if($this->uobj->UserIsWebmaster()) $var['plugin']['private'] = true;
            else $var['url']['private'] = true;
            $var['pai']['private']    = true;
            $var['menuid']['private'] = true;
        }
        return $var;
    }
    
    private $cookiename = 'menu_superior';
     public function getMenu(){
        //$this->LoadComponent('notificacao/notifica', 'not')->not->ajaxCheck();
        
        $this->LoadModel('usuario/login', 'uobj');
        $is = $this->uobj->UserIsWebmaster();
        if(!$is){
            if(cookie::cookieExists($this->cookiename)){
                $var = cookie::getVar($this->cookiename);
                if(!empty($var)) return $var;
            }
        }
        $menu_db = $this->selecionar(array('menu', 'url', 'menuid', 'pai'), '', '','', "ordem ASC");
        $mn = new \classes\Component\menuBuilder($menu_db);
        $mn->setNomePai('pai');
        $mn->setMenuId('menuid');
        $var = $mn->geraMenu();
        if(!$is) cookie::setVar($this->cookiename, $var);
        return $var;
    }
    
    public function paginate($page, $link = "", $cod_item = "", $campo = "", $qtd = 20, $campos = array(), $adwhere = "", $order = "") {
        $order = "site_menu_1.menu ASC, site_menu.menu ASC";
        return parent::paginate($page, $link, $cod_item, $campo, $qtd, $campos, $adwhere, $order);
    }
    
    public function unstall($plugin){
        $where = "url LIKE '$plugin/%'";
        if(!$this->db->Delete($this->tabela, $where)){
            $this->setErrorMessage($this->db->getErrorMessage());
            return false;
        }
        return true;
    }
    
    private function prepareAll(){
        $all = $this->selecionar(array('menuid'), "ISNULL(pai)");
        $out = array();
        foreach($all as $a){
            $name = GetPlainName($a["menuid"]);
            $out[$name] = $a["menuid"];
        }
        return $out;
    }
    
    public function reordernar($elementos){
        $all = $this->prepareAll();
        $elementos = explode(',', $elementos);
        foreach($elementos as $ord => $el){
            if(!$this->editar($all[$el], array('ordem' => $ord), 'menuid')) return false;
        }
        return true;
    }
    
    public function LoadItem($item){
        $all = $this->prepareAll();
        if(!array_key_exists($item,$all)) {
            $this->setErrorMessage("Este item não existe no menu");
            return false;
        }
        $this->setMessages($this->getItem($item, 'menuid'));
        return true;
    }
    
    public function setBreadscrumb(){
        $class = CURRENT_MODULE."Actions";
        $file = classes\Classes\Registered::getPluginLocation(CURRENT_MODULE, true).DS."Config".DS."$class.php";
        if(!file_exists($file)) {return;}
        require_once $file;
        $obj         = new $class();
        $act         = CURRENT_MODULE . "/". CURRENT_CONTROLLER . "/" . CURRENT_ACTION;
        $action      = $obj->getAction($act);
        if(!isset($action['breadscrumb'])) return;
        
        $prepared    = $this->mountBreadscrumb($action['breadscrumb'], $obj);
        
        $breadscrumb = \classes\Component\Component::displayPathLinks($prepared, false);
        EventTube::addEvent('body-top', $breadscrumb);
    }
    
    private function mountBreadscrumb($breadscrumb, $obj){
        $prepared = array();
        foreach($breadscrumb as $i => $bs){
            $arr   = $obj->getAction($bs);
            if(empty($arr)) continue;
            $this->discoverModel($bs);
            $label = $this->getLabel($arr, $i, $bs);
            $url   = $this->getUrl($arr, $bs);
            $prepared[ucfirst($label)] = $url;
        }
        return $prepared;
    }
    
    private $curModel = "";
    private function getUrl($arr, $bs){
        if(!isset($arr['needcod']) || !$arr['needcod']) return $bs;
        $val = (isset($_SESSION[$this->curModel]))?"/{$_SESSION[$this->curModel]}":"";
        return $bs . $val;
    }
    
    private function getLabel($arr, $i, $bs){
        $e     = explode('/', $bs);
        if($e[2] != "show" || !isset($_SESSION["{$this->curModel}_title"])) return is_numeric($i)?$arr['label']:$i;
        $label = $_SESSION["{$this->curModel}_title"];
        return (is_array($label)? array_shift($label) : $label);
    }
    
    private function discoverModel($bs){
        $e = explode('/', $bs);
        while(count($e) > 2)  array_pop($e);
        $this->curModel = implode("/", $e);
    }

}