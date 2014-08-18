<?php 
class site_configuracaoModel extends \classes\Model\Model{
    public $tabela = "site_configuracao";
    public $pkey   = array('cod_usuario', 'cod_conf');
    
    public function __construct() {
        parent::__construct();
        $this->LoadModel('site/conffile', 'cf');
        $this->LoadModel('site/conf', 'conf');
    }
    
    public function LoadFiles($cod_grupo){
        $cod_grupo = $this->antinjection($cod_grupo);
        return $this->cf->selecionar(array('cod_cfile', 'title', 'descricao'), "cod_confgrupo = '$cod_grupo'");
    }
    
    public function LoadFileValue($cod_conffile){
        return $this->cf->loadFormValues($cod_conffile);
    }
    
    public function LoadFileForm($cod_conffile){
        $cod_conffile = $this->antinjection($cod_conffile);        
        $out = array();
        $var = $this->conf->selecionar(array(), "file = '$cod_conffile'");
        foreach ($var as $v){
            if($v['fieldset'] == "") unset($v['fieldset']);
            if($v['especial'] == "") unset($v['especial']);
            $v['name']           = $v['label'];
            $v['options']        = $this->str2array($v['options']);
            if($v['type'] === 'enum' && !isset($v['options'][$v['value']]) && in_array($v['value'], array(true,'1',1))){
                if(isset($v['options']['true'])){
                    $v['value']         = 'true';
                    $v['default']       = 'true';
                }
            }
            $out[$v['cod_conf']] = $v;
        }
        $out['button'] = array('button' => 'Salvar Configurações');
        return $out;
    }
    
    private function str2array($array){
        if(is_array($array)) return $array;
        if($array == "") return array();
        
        $array_ser = @unserialize($array);
        if(is_array($array_ser)) {
            return $array_ser;            
        }
        
        $temp = explode(',', $array);
        $out  = array();
        foreach($temp as $ar_s){
            $ar_s = str_replace(array("'", '"', "[", "]"), '', $ar_s);
            $exp = explode('=>', $ar_s);
            $out[trim($exp[0])] = trim($exp[1]);
        }
        return $out;
        
    }
    
    
    public function setDefaultConfig($cod){
        $cod = $this->antinjection($cod);
        $confs = $this->conf->selecionar(array(), "file = '$cod'");
        if(!empty($confs)){
            $dados = array();
            foreach($confs as $conf){
                $dados[$conf['cod_conf']] = $conf['value_default'];
            }
            if(!$this->saveConfig($cod, $dados)) return false;
        }
        $this->setSuccessMessage("Valores padrões restaurados corretamente!");
        return true;
    }
    
    
    public function saveConfig($cod, $dados){

        //verifica se o usuário tem permissão de modificar o arquivo de configurações
        $codfile = $this->antinjection($cod);
        if(!$this->cf->checkSavePermission($codfile)){
            $this->setErrorMessage('Você não tem permissão de acessar esta página!');
            return false;
        }
        
        //valida os dados enviados
        $fform   = $this->LoadFileForm($codfile);
        $this->LoadResource('formulario/validator', 'val');
        if(!$this->val->validate($fform, $dados)){
            $this->setMessages($this->val->getMessages());
            return false;
        }
        $dados = $this->val->getValidPost();
        if(isset($dados['enviar'])) unset($dados['enviar']);
        if(isset($dados['ajax']))   unset($dados['ajax']);
        
        //salva os dados de acordo com a visibilidade do dado
        $this->conffile = $this->cf->getItem($codfile);
        $method = "save".ucfirst($this->conffile['__visibilidade']);
        return $this->$method($dados, $codfile);
    }
    
    //salva as configurações do usuário
    private function saveUsuario($dados, $codfile){
        if(!$this->check($dados)) return false;
        $cod_usuario = \usuario_loginModel::CodUsuario();
        $save        = array('cod_usuario' => $cod_usuario);
        foreach ($dados as $cod_conf => $var){
            $save['cod_conf'] = $this->antinjection($cod_conf);
            $save['valor']    = $this->antinjection($var);
            if($this->getCount("cod_usuario = '$cod_usuario' AND cod_conf = '$cod_conf'") == 0){
                if(!$this->inserir($save)) return false;
            }elseif(!$this->editar(array($cod_usuario, $cod_conf), array('valor' => $var))) return false;
        }
        $this->setSuccessMessage("Configurações salvas Corretamente!");
        return true;
    }
    
    private function saveAdmin($dados, $cod_conffile){
        //salva as configuracoes no banco de dados
        if(!$this->check($dados)) return false;
        foreach ($dados as $cod_conf => $var){
            $save['value'] = $this->antinjection($var);
            if(!$this->conf->editar($cod_conf, $save)) {
                $this->setMessages($this->conf->getMessages());
                return false;
            }
        }
        
        //cria o diretório do arquivo
        $this->LoadClassFromPlugin('site/conffile/conffileRegister', 'cfreg');
        if(!$this->cfreg->createFolder($this->conffile)){
            $this->setMessages($this->cfr->getMessages());
            return false;
        }
        
        //cria o arquivo
        if(!$this->cfreg->createFile($cod_conffile, $dados)){
            $this->setMessages($this->cfreg->getMessages());
            return false;
        }
        
        if(isset($this->conffile['__updateplugins']) && $this->conffile['__updateplugins'] === 'true'){
            $plugin = $this->LoadModel('plugins/plug', 'plug')->getPluginByName($this->conffile['referencia'], array('cod_plugin'));
            if(!empty($plugin)){
                simple_curl(URL . "/index.php?url=plugins/plug/api_update/{$plugin['cod_plugin']}");
            }
        }
        
        $this->setSuccessMessage("Configurações salvas Corretamente!");
        return true;
    }
    
    private function saveWebmaster($dados, $codfile){
        return $this->saveAdmin($dados, $codfile);
    }
    
    private function check($dados){
        $keys  = array_keys($dados);
        $imp   = "'".implode("','", $keys)."'";
        $all   = $this->conf->selecionar(array('cod_conf'), "cod_conf IN ($imp)");
        $check = array();
        foreach($all as $a) $check[] = $a['cod_conf'];
        if(empty($check)) {
            $this->setErrorMessage('As configurações que você está tentando salvar não existem!');
            return false;
        }
        return true;
    }
    
}