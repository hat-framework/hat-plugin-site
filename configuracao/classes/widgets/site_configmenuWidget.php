<?php

class site_configmenuWidget extends \classes\Component\widget{
    public function widget() {
        $this->LoadModel('site/configuracao', 'model');
        $this->LoadModel('site/confgrupo', 'gr');
        $this->LoadJsPlugin('menu/treeview', 'mt');
        $this->mt->setUlClass('nav nav-tabs nav-stacked main-menu');
        $arr = $this->gr->genMenu();
        $this->mt->imprime();
        $var = (!empty ($arr))?$this->mt->draw($arr, 'nav-collapse sidebar-nav'):
            "<b>Caro usuário</b>, não existe nenhum grupo de configurações no qual você tenha sido registrado";

        $title = 'Minhas Configurações';
        echo "<h3>$title</h3>$var";
    }
}
/*
<div class="nav-collapse sidebar-nav">
        <ul class="nav nav-tabs nav-stacked main-menu">
                <li class="nav-header hidden-tablet">Navigation</li>
                <li class="active"><a href="index.html"><i class="icon-home"></i><span class="hidden-tablet"> Dashboard</span></a></li>
                <li><a href="ui.html"><i class="icon-eye-open"></i><span class="hidden-tablet"> UI Features</span></a></li>
                <li><a href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
                <li><a href="chart.html"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
                <li><a href="typography.html"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
                <li><a href="gallery.html"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
                <li><a href="table.html"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
                <li><a href="calendar.html"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
                <li><a href="grid.html"><i class="icon-th"></i><span class="hidden-tablet"> Grid</span></a></li>
                <li><a href="file-manager.html"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
                <li><a href="icon.html"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
                <li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li>
        </ul>
</div><!--/.well -->
*/