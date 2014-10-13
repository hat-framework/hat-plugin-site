<?php

class configMenuWidget extends \classes\Component\widget{
    public function widget() {
        $configuracoes = $this->LoadModel('site/confgrupo', 'gr')->genMenu();
        foreach($configuracoes as $gname => $confgrupo){
            echo "<h3>$gname</h3>";
            foreach($confgrupo as $nm => $link){
                $link = ($link !== "#")?"<a href='$link'>$nm</a>":$nm;
                $this->gui->infotitle($link);
            }
        }
    }
}