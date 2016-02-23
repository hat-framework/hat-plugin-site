<?php

class indexController extends \classes\Controller\Controller{
    public $model_name = "";
    public function index() {
        Redirect('site/configuracao');
    }
    
    public function test(){
        $this->display(LINK ."/test");
    }
    
    public function cache(){
        $this->listFiles(__FUNCTION__);
    }
    
    public function log(){
        $this->listFiles(__FUNCTION__);
    }
    
    private function listFiles($type){
        if(!usuario_loginModel::IsWebmaster()){
            if(!usuario_loginModel::isLogged()){$this->LoadModel('usuario/login', 'uobj')->needLogin();}
            else SRedirect (URL);
        }
        $tree    = array();
        $dir     = ($type == "log")?DIR_LOG:DIR_CACHE;
        $url     = $this->LoadClassFromPlugin('site/index/indexFileManager', 'ifman')->setDir($dir)->getUrls($type);
        $this->ifman->drop($type);
        $this->ifman->getFiles($tree);
        $this->registerVar("base_url", $url['base']);
        $this->registerVar("dropUrl" , $url['drop']);
        $this->registerVar("title"   , ucfirst($type));
        $this->registerVar("files"   , $tree);
        $this->registerVar("filesrc" , $url['filesrc']);
        
        getTrueDir($dir);
        $this->display(LINK.'/listFiles');
    }
    
    public function rdct(){
        $out = array();
        foreach($_GET as $name => $val){
            if($name == 'link' || $name == 'url' ){continue;}
            $out[] = "$name=$val";
        }
        $str = implode("&", $out);
        $url = (isset($_GET['link']))?$_GET['link']:URL;
        $var = ($str != "")?"$str":"";
        $full = "{$url}?{$var}";
        SRedirect("http://$full");
    }
}