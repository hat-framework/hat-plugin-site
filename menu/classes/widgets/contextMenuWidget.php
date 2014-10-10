<?php

class contextMenuWidget extends \classes\Component\widget{
        
    protected function getItens(){
        return $this->LoadModel('plugins/action', 'act')->geraMenu(CURRENT_MODULE, CURRENT_PAGE, false);
    }
    
    protected function draw($itens){
        if(empty($itens)) {return '';}
        $this->LoadJsPlugin('menu/menu', 'mn')
                ->setLiClass('sublink')
                ->draw($itens, 'nav nav-pills submenu');
    }
}