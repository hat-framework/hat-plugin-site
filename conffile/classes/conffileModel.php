<?php 
class site_conffileModel extends \classes\Model\Model{
    public $tabela = "site_conffile";
    public $pkey   = 'cod_cfile';
    
    public function paginate($page, $link = "", $cod_item = "", $campo = "", $qtd = 20, $campos = array(), $adwhere = "", $order = "") {
        $vis   = $this->getPermissionArr();
        $where = "visibilidade IN ('".implode("','", $vis)."')";
        $adwhere = ($adwhere == "")?"$where":"$adwhere AND ($where)";
        return parent::paginate($page, $link, $cod_item, $campo, $qtd, $campos, $adwhere, $order);
    }
    
    public function checkSavePermission($cod_item){
        $this->getPermissionArr();
        $item = $this->getItem($cod_item);
        $vis  = $this->getPermissionArr();
        if(empty($item)) return false;
        return (in_array($item['__visibilidade'], $vis));
    }
    
    public function getPermissionArr(){
        
        $this->LoadModel('usuario/login', 'uobj');
        if(!$this->uobj->IsLoged()) $this->uobj->needLogin();
        
        $vis   = array('usuario' => 'usuario');
        if($this->uobj->UserIsWebmaster()){
            $vis['admin'] = 'admin';
            $vis['webmaster'] = 'webmaster';
        }
        if($this->uobj->UserIsAdmin()){$vis['admin'] = 'admin';}
        return $vis;
    }
    
    public function loadFormValues($cod_item){
        
        //carrega o arquivo de configurações para verificar se a configuração é 
        //somente do usuário ou se é para o site todo
        $cod_item = $this->antinjection($cod_item);
        $file = $this->selecionar(array('visibilidade'), "cod_cfile = '$cod_item'");
        if(empty($file)) return array();
        $temp = array_shift($file);
        $vis  = $temp['visibilidade'];
        $out  = $var = array();
        
        $this->LoadModel('site/conf', 'conf');
        if($vis == 'usuario'){
            $cod_usuario = \usuario_loginModel::CodUsuario();
            $this->LoadModel('site/configuracao', 'sconf');
            $this->db->Join($this->sconf->getTable(),$this->conf->getTable());
            $var = $this->sconf->selecionar(
                    array('cod_conf', 'valor as value', 'type','name'), 
                    "file = '$cod_item' AND cod_usuario='$cod_usuario'"
            );
        }
        
        if(empty($var)) $var = $this->conf->selecionar(array('cod_conf', 'value', 'type', 'name'), "file = '$cod_item'");
        foreach($var as $v){
            $val = getConstantValue($v["name"]);
            if($val === ""){$val = $v['value'];}
            if(is_bool($val)){$val = ($val === true)?'true':'false';}
            if($v['type'] == 'enum'){
                $out["__".$v['cod_conf']] = $val;
            }
            $out[$v['cod_conf']] = $val;
            
        }
        return $out;
    }
    
    public function unstall($plugin){
        $where = "referencia LIKE '$plugin%' OR path LIKE '$plugin%'";
        if(!$this->db->Delete($this->tabela, $where)){
            $this->setErrorMessage($this->db->getErrorMessage());
            return false;
        }
        return true;
    }
    
    public function updateFile($item){
        $this->LoadClassFromPlugin('site/conffile/conffileRegister', 'cfr');
        if(!$this->cfr->createFolder($item)){
            $this->setMessages($this->cfr->getMessages());
            return false;
        }
        return true;
    }
    
}