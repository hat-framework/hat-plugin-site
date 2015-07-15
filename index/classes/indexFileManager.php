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
        $pasta          = ($folder == "")?$this->dir:"$this->dir".DS.$folder;
        $current_folder = $pasta . filter_input(INPUT_GET, 'folder');
        getTrueDir($current_folder);
        return $this->dobj->getDirectoryTreeFolders($tree, $current_folder, $pasta);
    }

    public function show(){
        
    }
    
    public function drop($type){
        $action = filter_input(INPUT_GET, 'action');
        if($action != 'drop'){return;}
        
        $input  = filter_input(INPUT_GET, 'file');
        getTrueDir($input);
        if($input !== ""){
            $e      = explode(DS, $input);
            array_pop($e);
            $ff     = implode(DS, $e);
            $dir    = $this->dir.DS.$input;
            $this->dobj->remove($dir);
            return Redirect(URL."index.php?url=site/index/$type&folder=$ff");
        }
        
        $folder  = filter_input(INPUT_GET, 'folder');
        getTrueDir($folder);
        if($folder !== ""){
            $e      = explode(DS, $folder);
            array_pop($e);
            $ff     = implode(DS, $e);
            $dir    = $this->dir.DS.$folder;
            getTrueDir($dir);
            $this->dobj->remove($dir);
            return Redirect(URL."index.php?url=site/index/$type&folder=$ff");
        }
    }

    public function getUrls($type){
        $out   = array('drop' => '', 'base' => '', 'filesrc' => '');
        $input = filter_input(INPUT_GET, 'file');
        if($input != ""){
            $out['filesrc'] = $this->dir.DS.$input;
            $out['drop']    = $this->html->getLink("site/index/$type&file=$input&action=drop", true, true);
        }
        $out['base']        = $this->html->getLink("site/index/$type", true, true);
        getTrueDir($out['filesrc']);
        //print_r($out); die($this->dir);
        return $out;
    }
}