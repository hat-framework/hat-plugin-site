<?php

class site_confgrupoData extends \classes\Model\DataModel{
   public $dados  = array(
         'cod_confgrupo' => array(
	    'name'     => 'Código',
	    'type'     => 'int',
	    'size'     => '11',
	    'pkey'    => true,
	    'ai'      => true,
	    'grid'    => true,
	    'display' => true,
	    'private' => true
        ),
        'name' => array(
	    'name'     => 'Nome',
	    'type'     => 'varchar',
	    'size'     => '64',
            'title'    => true,
	    'unique'  => array('model' => 'site/conffile'),
	    'grid'    => true,
	    'display' => true,
        ),
       
       'model' => array(
            'name'    => 'Configuração Externa',
            'type'    => 'varchar',
            'size'    => '64',
        ),
       
        'files_of_grupo' => array(
            'name'          => 'Arquivos do Grupo',
            //'private'       => true,    
            'especial'      => 'hide',
            'display'       => true,
            'display_in'    => 'table',
            'fkey'      => array(
                'refmodel'      => 'site/confgrupo',
                'sort'          => 'title ASC',
                'limit'         => 1000,
                'model'         => 'site/conffile',
                'keys'          => array('cod_confgrupo', 'grupo'),
                'cardinalidade' => 'n1'//nn 1n 11
            )
         ),
        'button'     => array('button' => 'Gravar Grupo'),
    );
}

?>