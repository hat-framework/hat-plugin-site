<?php 
class site_confgrupoModel extends \classes\Model\Model{
    public $tabela = "site_confgrupo";
    public $pkey   = 'cod_confgrupo';
    
    public function genMenu(){
        $perm = $this->LoadModel('site/conffile', 'cf')->getPermissionArr();
        $p = "'".implode("','", $perm)."'";
        $this->db->Join($this->getTable(), $this->cf->getTable(), array($this->pkey), array('cod_confgrupo'), "LEFT");  
        $var  = $this->selecionar(array(), "visibilidade IN ($p)", "", "", "type ASC, name ASC");
        //print_rd($var);
        return $this->mountMenu($var);
    }
    private $cookiename = "site_cofgrupo";
    public function getGroupsOfUser($visibilidade = 'usuario'){
        $where = "";
        if($visibilidade !== ""){
            if(!is_array($visibilidade)){$visibilidade = array($visibilidade);}
            $visibilidade = implode("','", $visibilidade);
            $where        =  "visibilidade IN('$visibilidade')";
        }
        $this->LoadModel('site/conffile', 'cf');
        $this->db->Join($this->getTable(), $this->cf->getTable(), array('cod_confgrupo'), array('cod_confgrupo'), "LEFT");
        return $this->selecionar(array("DISTINCT $this->tabela.cod_confgrupo", "$this->tabela.name"),$where);
    }
    
    public function getWebmasterGroups($mountMenu = true, $dados = array()){
        return $this->getGroups('Webmaster', $mountMenu, $dados);
    }
    
    public function getUserGroups($mountMenu = true, $dados = array()){
        return $this->getGroups('usuario', $mountMenu, $dados);
    }
    
    private function getGroups($visibilidade, $mount = true){
        $this->LoadModel('site/conffile', 'cf');
        $this->db->Join($this->getTable(), $this->cf->getTable(), array('cod_confgrupo'), array('cod_confgrupo'), "LEFT");
        $var = $this->selecionar(array(), "visibilidade IN('$visibilidade')");
        if(!$mount){return $var;}
        $out = $this->mountMenu($var, false);
        return $out;
    }
    
    public function findNewGroups(){
        $this->LoadClassFromPlugin('site/configuracao/registerConfiguracao', 'rconf');
        if(!$this->findSiteConfiguration())      return false;
        if(!$this->findResourceConfigurations()) return false;
        return true;
    }
    
    private function findSiteConfiguration(){
        if(!$this->rconf->register('config', 'config')){
            $this->setMessages($this->rconf->getMessages());
            return false;
        }
        return true;
    }
    
    private function findResourceConfigurations(){
        $this->LoadResource('files/dir', 'dir');
        $resources = classes\Classes\Registered::getAllResourcesLocation(true);
        foreach($resources as $res){
            $files   = $this->dir->getArquivos("$res/src/config/");
            if(empty($files)) continue;
            foreach($files as $fl){
                if(false === strstr($fl, 'Configurations')){continue;}
                $f = str_replace(array('.php', 'Configurations'), '', $fl);
                if(!$this->rconf->register('resource', "$res/$f")){
                    $this->setMessages($this->rconf->getMessages());
                    return false;
                }
            }
            //print_r($files);echo RESOURCES . "$res/config"."<hr/>";
        }
        return true;
    }
    
    private function mountMenu($var, $categorize = true){
        if(empty($var)) return array();
        $this->LoadResource('html', 'Html');
        $names = array(
            'config'    => 'Configurações Gerais', 
            'plugin'    => 'Aplicativos Instalados', 
            'resource'  => 'Opções Avançadas',
            'jsplugins' => 'Plugins de Efeito',
            'template'  => 'Opções de Aparência',
        );
        $menu = array();
        foreach($var as $v){
            $link = $this->Html->getLink('site/configuracao/group/'. $v['cod_confgrupo']);
            if($categorize)$menu[$names[$v['type']]][$v['name']] = $link;
            else           $menu[$v['name']] = $link;
        }
        
        //print_rd($menu);
        return $menu;
    }
    
}