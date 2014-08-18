<?php
namespace plugins\site\Config;
class reportWidget extends \classes\Component\widget{    
     protected $modelname  = "";
     protected $typegrafic = "LineChart";
     protected $title      = "";
     protected $subtitle   = "Total";
     protected $date       = "data"; //coluna que possui as datas do gráfico (geralmente Timestamp)
     protected $titlegrafic   = "Cadastros por data";
     
      
    public function widget(){
        $this->LoadModel($this->modelname, 'model');
        $id = ($this->id == "")?"widget_".  str_replace("/", "_", $this->modelname):$this->id;
        $this->gui->opendiv($id, $this->class);
            $this->gui->subtitle($this->title);
            $this->total();
            $this->graf();         
        $this->gui->closediv();
    }
    
    public function total(){
        $total  = $this->model->getCount();
        echo "$this->subtitle: $total";
    }
    
    public function graf(){
        $array = array();
        $array = $this->getItemGrafic();
        if($array == array())return;
        echo $this->LoadResource('charts', 'ch')
                    ->init($this->typegrafic)
                    ->load($array)
                    ->draw('',  array('title' => $this->titlegrafic));
    }
    
    public function getItemGrafic(){
        return $this->model->selecionar(array("DATE($this->date) as data", "count(*) as total"), "1 GROUP BY data", "", "", "data ASC");
    }
    
    public function setGrafic($typegrafic){
        $this->typegrafic = $typegrafic;
        return $this;
    }
    
    public function setSubtitle($subtitle){
        $this->subtitle = $subtitle;
        return $this;
    }
    
    public function setDate($date){
        $this->date = $date;
        return $this;
    }
    
    
    
}