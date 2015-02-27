<?php

class indexFileManagerComponent extends classes\Component\Component{
    
    public function showMenu($array, $base_url){
        $this->LoadJsPlugin('menu/treeview', 'tv');
        ksort($array);
        echo "<div class='treeview'>";
        $this->displayMenu($array, $base_url);
        echo "</div>";
    }
    
    public function displayMenu($array, $base_url){
        if(empty($array)) {return "";}
        echo "<ul>";
        foreach($array as $folder => $file){
            if(!is_array($file)) {
                $url = $base_url . "/$file";
                echo "<li><a href='$url'>$file</a></li>";
                continue;
            }
            echo "<li>$folder<ul>";
            if(is_array(end($file))){krsort($file);}
            else{arsort($file);}
            $this->displayMenu($file, "$base_url/$folder");
            echo "</ul></li>";
        }
        echo "</ul>";
    }
}