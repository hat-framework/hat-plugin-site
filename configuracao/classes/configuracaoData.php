<?php

class site_configuracaoData extends \classes\Model\DataModel{
   public $dados  = array(
         'cod_usuario' => array(
	    'name'     => 'Usuário',
	    'type'     => 'int',
	    'size'     => '11',
	    'pkey'    => true,
	    'grid'    => true,
	    'display' => true,
            'especial' => 'autentication',
            'autentication' => array(
                'needlogin' => true
             ),
	    'fkey' => array(
	        'model' => 'usuario/login',
	        'cardinalidade' => '1n',
	        'keys' => array('cod_usuario', 'user_name', 'user_cargo'),
	    ),
        ),
        'cod_conf' => array(
	    'name'     => 'Configuração',
	    'type'     => 'int',
	    'size'     => '11',
	    'pkey'    => true,
	    'grid'    => true,
	    'display' => true,
	    'fkey' => array(
	        'model' => 'site/conf',
	        'cardinalidade' => '1n',
	        'keys' => array('cod_conf', 'label'),
	    ),
        ),
        
        'valor' => array(
	    'name'    => 'Valor',
	    'type'    => 'varchar',
            'size'    => '64',
	    'display' => true,
        ),
        
        'button'     => array('button' => 'Gravar Arquivo'),
    );
}

?>