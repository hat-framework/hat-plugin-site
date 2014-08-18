<?php

class indexFileManager extends classes\Classes\Object{
    
    private $dir = "";
    public function __construct() {
        $this->LoadResource('files/dir', 'dobj');
        $this->LoadResource('html', 'html');
    }
    
    public function setDir($dir){
        getTrueDir($dir);
        $this->dir = $dir;
        return $this;
    }
    
    public function getFiles(&$tree, $folder = ""){
        $pasta   = ($folder == "")?$this->dir:"$this->dir".DS.$folder;
        return $this->dobj->getDirectoryTree($tree, $pasta);
    }

    public function show(){
        
    }
    
    public function drop($type){
        $input  = filter_input(INPUT_GET, 'file');
        $action = filter_input(INPUT_GET, 'action');
        if($action != 'drop'){return;}
        $dir    = $this->dir.DS.$input;
        $this->dobj->remove($dir);
        Redirect("site/index/$type");
    }

    public function getUrls($type){
        $out   = array('drop' => '', 'base' => '', 'filesrc' => '');
        $input = filter_input(INPUT_GET, 'file');
        if($input != ""){
            $out['filesrc'] = $this->dir.DS.$input;
            $out['drop']    = $this->html->getLink("site/index/$type&file=$input&action=drop", true, true);
        }
        $out['base']        = $this->html->getLink("site/index/$type&file=", true, true);
        getTrueDir($out['filesrc']);
        //print_r($out); die($this->dir);
        return $out;
    }
}