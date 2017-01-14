<?php

class contextMenuWidget extends \classes\Component\widget{
        
    protected function getItens(){
        if(!defined('CURRENT_MODULE') || !defined('CURRENT_PAGE')){return array();}
		$menu = classes\Classes\EventTube::getMenuArray('body-top');
		if(!empty($menu)){return $menu;}
        return $this->LoadModel('plugins/action', 'act')->geraMenu(CURRENT_MODULE, CURRENT_PAGE, false);
    }
    
    protected function draw($itens){
        if(empty($itens)) {return '';}
        $cid   = 'contextmenu_container';
        $class = 'nav nav-pills submenu';
        $li    = 'sublink dropdown';
        $lione = 'levelone';
        $id    = $this->id;
        $data = classes\Classes\Template::getClass('contextmenu');
        if($this->id !== ""){$id = $this->id;}
        if($data !== "" && is_array($data)){extract($data);}
        echo "<div id='container_btn_ctxmenu'>"
                . "<button type='button' class='navbar-toggle collapsed btn btn-default col-xs-12' data-toggle='collapse' data-target='#$cid'>"
                    . "<i class='fa fa-gear fa-2x'></i> Opções <i class='caret'></i>"
                . "</button>"
            . "</div>";
        echo "<div id='$cid' class='collapse navbar-collapse'>";
        $this->LoadJsPlugin('menu/menu', 'mn')
                ->setLiClass($li)
                ->setLiOneClass($lione)
                ->draw($itens, $class, $id);
        echo "</div>";
    }
    
//    protected function draw($itens){
//        if(empty($itens)) {return '';}
//        $class = 'nav nav-pills submenu';
//        $li    = 'sublink dropdown';
//        $lione = 'levelone';
//        $id    = $this->id;
//        $data = classes\Classes\Template::getClass('contextmenu');
//        if($this->id !== ""){$id = $this->id;}
//        if($data !== "" && is_array($data)){extract($data);}
//        $this->LoadJsPlugin('menu/menu', 'mn')
//                ->setLiClass($li)
//                ->setLiOneClass($lione)
//                ->draw($itens, $class, $id);
//    }
}