<?php 
class site_sitemapModel extends \classes\Model\Model {
    public $model_name = LINK;    
    public function createMap() {
        $this->LoadResource('html', 'html');
        $this->LoadModel('plugins/plug', 'plug');
        $plugins  = \classes\Classes\Registered::getAllPluginsLocation(true);
        foreach($plugins as $plugname => $plugfolder){
            $item    = $this->plug->getPluginByName($plugname);
            if($item['__status'] !== 'instalado'){continue;}
            $class   = "{$plugname}Actions";
            $arquivo = $plugfolder . "/Config/$class.php";
            if(!file_exists($arquivo)){continue;}
            require_once $arquivo;
            $obj = new $class();
            $actions = $obj->getActions();
            if(empty($actions)){continue;}
            $this->mapActions($actions);
        }
        $this->LoadResource("files/file", 'fobj');
        $this->fobj->savefile(BASE_DIR. "/sitemap.xml", "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>$this->str</urlset>");
        $this->setMessages($this->fobj->getMessages());
    }
    
    private function mapActions($actions){
        foreach($actions as $url => $action){
            if(!isset($action['publico']) || $action['publico'] === 'n'){continue;}
            if(isset($action['noindex'])  && $action['noindex'] === 's'){continue;}
            if(!isset($action['needcod']) || $action['needcod'] === false){
                $this->addAction($url);
            }
        }
    }
    
    private $str = '';
    private function addAction($url){
        $url = $this->html->getLink($url);
        $this->str .= "<url><loc>$url</loc><changefreq>monthly</changefreq><priority>0.9</priority></url>";
    }
    
}
/*
This XML file does not appear to have any style information associated with it. The document tree is shown below.
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
<loc>http://institucional.webmotors.com.br/quem-somos</loc>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>http://institucional.webmotors.com.br/imprensa</loc>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>
http://institucional.webmotors.com.br/como-anunciar
</loc>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>
http://institucional.webmotors.com.br/porque-anunciar
</loc>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>
http://institucional.webmotors.com.br/quem-pode-anunciar
</loc>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>http://institucional.webmotors.com.br/formatos</loc>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>
http://institucional.webmotors.com.br/perfil-de-audiencia
</loc>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>http://institucional.webmotors.com.br/contato</loc>
<changefreq>monthly</changefreq>
<priority>0.8</priority>
</url>
</urlset>
 * 
 * 
 *  */