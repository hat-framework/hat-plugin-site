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
        echo "<ul>";
        foreach($array as $folder => $file){
            if(!is_array($file)) {
                $url = "$base_url&folder=$folderr&file=$folderr/$file";
                $dropfolderlink = URL."index.php?url=site/index/log&file=$folderr/$file&action=drop";
                echo "<li><a href='$url'>$file</a>"
                      . " <a href='$dropfolderlink' onclick='return confirm(\"Deseja apagar este arquivo?\")'><i class='fa fa-times'></i></a>"
                      . "</li>";
                continue;
            }
            
            $urlfolder = $base_url . "&folder=$folderr/$folder";
            $dropfolderlink = URL."index.php?url=site/index/log&file=&folder=$folderr/$folder&action=drop";
            echo "<li><a href='$urlfolder'>$folder</a>"
                    . "<a href='$dropfolderlink' onclick='return confirm(\"Deseja apagar esta pasta?\")'><i class='fa fa-times'></i></a>"
                    . "<ul>";
            if(is_array(end($file))){krsort($file);}
            else{arsort($file);}
            $this->displayMenu($file, $base_url, "$folderr/$folder");
            echo "</ul></li>";
        }
        echo "</ul>";
    }
}