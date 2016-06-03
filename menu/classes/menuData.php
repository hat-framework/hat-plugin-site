<?php

class site_menuData extends \classes\Model\DataModel{
   protected $dados  = array(
        
        'cod_menu' => array(
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
        
        'menu' => array(
            'name'    => 'Nome',
            'type'    => 'varchar',
            'size'    => '64', 
            'grid'    => true,
            'notnull' => true,
            'display' => true,
       	),
        
        'pai' => array(
            'name'    => 'Pai',
            'grid'    => true,
            'fkey'    => array(
                'model'         => 'site/menu',
                'cardinalidade' => '1n', //nn 1n 11
                'keys'          => array('menuid', 'menu'),
                'onupdate'      => 'cascade',
                'ondelete'      => 'cascade'
            ),
            'display' => true,
        ),
 
        'menuid' => array(
            'name'    => 'Id',
            'type'    => 'varchar',
            'unique' => array('model'=>'site/menu'),
            'size'    => '64', 
            'grid'    => true,
            'display' => true,
         ),
         
        'url' => array(
            'name' => 'Url',
            'type' => 'varchar',
            'size' => '128',
            'notnull' => 'true',
            'grid' => true,
            'display' => true,
         ),
       
         'plugin' => array(
            'name' => 'Plugin',
            'type' => 'varchar',
            'size' => '64',
            'grid' => true,
            'display' => true,
         ),
       
        'icon' => array(
            'name'    => 'Ícone',
            'type'    => 'varchar',
            'size'    => '32',
            'grid'    => true,
            'display' => true,
         ),
        
         'ordem' => array(
            'name'  => 'Ordem',
            'type'  => 'int',
            'size'  => '5',
            'grid'  => true,
            'display' => true,
         )
        
    );
   
   
}