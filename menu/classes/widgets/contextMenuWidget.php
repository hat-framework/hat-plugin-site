<?php

class contextMenuWidget extends \classes\Component\widget{
        
    protected function getItens(){
        return $this->LoadModel('plugins/action', 'act')->geraMenu(CURRENT_MODULE, CURRENT_PAGE, false);
    }
    
    protected function draw($itens){
        if(empty($itens)) {return '';}
        $class = 'nav nav-pills submenu';
        $id    = '';
        $data = classes\Classes\Template::getClass('contextmenu');
        if($data !== "" && is_array($data)){extract($data);}
        $this->LoadJsPlugin('menu/menu', 'mn')
                ->setLiClass('sublink dropdown')
                ->draw($itens, $class, $id);
    }
}