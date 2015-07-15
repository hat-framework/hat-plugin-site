<?php

class indexFileManagerComponent extends classes\Component\Component{
    
    public function showMenu($array, $base_url){
        $this->LoadJsPlugin('menu/treeview', 'tv');
        ksort($array);
        echo "<div class='treeview'>";
        $this->displayMenu($array, $base_url);
        echo "</div>";
    }
    
    public function displayMenu($array, $base_url, $folderr = ''){
        if(empty($array)) {return "";}
        $current_folder = filter_input(INPUT_GET, 'folder');
        $current_file   = filter_input(INPUT_GET, 'file');
        echo "<ul>";
        foreach($array as $folder => $file){
            if(!is_array($file)) {
                if($current_folder!= "$folderr" && $current_file != "$folderr/$file"){continue;}
                $url = $base_url . "$folderr/$file";
                echo "<li><a href='$url'>$file</a></li>";
                continue;
            }
            $url = $base_url . "&folder=$folderr/$folder";
            echo "<li><a href='$url'>$folder</a><ul>";
            if(is_array(end($file))){krsort($file);}
            else{arsort($file);}
            $this->displayMenu($file, $base_url, "$folderr/$folder");
            echo "</ul></li>";
        }
        echo "</ul>";
    }
}