<?php

class site_webserviceData extends \classes\Model\DataModel{
   protected $dados  = array(
        
        'cod' => array(
            'name'    => "Código",
            'pkey'    => true,
            'ai'      => true,
            'type'    => 'int',
            'size'    => '11',
            'grid'    => true,
            'notnull' => true,
            'display' => true,
            'private' => true,
         ),
        
        'name' => array(
            'name'    => 'Nome',
            'type'    => 'varchar',
            'size'    => '20', 
            'grid'    => true,
            'notnull' => true,
            'display' => true,
       	),
        
       'class' => array(
            'name'    => 'Classe',
            'type'    => 'varchar',
            'size'    => '256', 
            'grid'    => true,
            'notnull' => true,
            'display' => true,
            'description' => "Insira o nome da classe a ser executada e os parâmetros a serem enviados separados por barras"
       	),
        
    );
   
   
}