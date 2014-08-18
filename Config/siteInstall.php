<?php

class siteInstall extends classes\Classes\InstallPlugin{
    
    protected $dados = array(
        'pluglabel' => 'Configurações do Site',
        'isdefault' => 'n',
        'system'    => 's',
    );
    
    public function install(){
        
        if(!$this->findGeralConfigurations()) return false;
        if(!$this->findPluginConfigurations()) return false;
        return true;
        
    }
    
    private function findGeralConfigurations(){
        $this->LoadModel('site/confgrupo', 'cg');
        if(!$this->cg->findNewGroups()){
            $this->setMessages($this->cg->getMessages());
            return false;
        }
        return true;
    }
    
    private function findPluginConfigurations(){
        //neste ponto as tabelas do plugin site já foram adicionadas ao banco de dados, então vamos
        //forçar o registro das configurações do site
        $this->LoadClassFromPlugin("plugins/plug/inclasses/registerConfigurations", 'rconf');
        $this->rconf->forceRegister();
        
        //procura pelos plugins já instalados
        $this->LoadModel('plugins/plug', 'pl');
        $plugin = $this->pl->paginate(0, CURRENT_PAGE, '', '', 10000);
        foreach($plugin as $plug){
            
            //só queremos os plugins instalados
            if($plug['status'] != 'instalado') continue;
            if(!$this->rconf->register($plug['plugnome'], $plug['cod_plugin'])){
                $this->setMessages($this->rconf->getMessages());
                return false;
            }
 
        }
        return true;
    }
    
    public function unstall(){
        return true;
    }
}