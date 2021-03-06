<?php

class site_conffileData extends \classes\Model\DataModel {

    public $dados = array(
        'cod_cfile' => array(
            'name' => 'Código',
            'type' => 'int',
            'size' => '11',
            'pkey' => true,
            'ai' => true,
            'grid' => true,
            'display' => true,
            'private' => true
        ),
        'title' => array(
            'name' => 'Título',
            'type' => 'varchar',
            'size' => '64',
            'title' => true,
            'unique' => array('model' => 'site/conffile'),
            'grid' => true,
            'display' => true,
        ),
        'descricao' => array(
            'name' => 'Descricao',
            'type' => 'text',
            'display' => true,
        ),
        'type' => array(
            'name' => 'Tipo',
            'type' => 'enum',
            'default' => 'config',
            'options' => array(
                'config' => 'config',
                'plugin' => 'plugin',
                'jsplugin' => 'jsplugin',
                'template' => 'template',
                'resource' => 'resource',
            ),
            'grid' => true,
            'display' => true,
            'subtitle' => true,
        ),
        'referencia' => array(
            'name' => 'Referência',
            'type' => 'varchar',
            'size' => '64',
            'display' => true,
            'dinamic' => array(
                'type' => 'hide',
                'target' => 'type',
                'option' => 'config'
            ),
            'description' => ''
        ),
        'path' => array(
            'name' => 'Diretório',
            'type' => 'varchar',
            'size' => '128',
        ),
        'cod_confgrupo' => array(
            'name' => 'Grupo',
            'type' => 'int',
            'notnull' => true,
            'grid' => true,
            'display' => true,
            'fkey' => array(
                'model' => 'site/confgrupo',
                'cardinalidade' => '1n',
                'keys' => array('cod_confgrupo', 'name'),
                'onupdate' => 'cascade',
                'ondelete' => 'restrict',
            )
        ),
        'visibilidade' => array(
            'name' => 'Visibilidade',
            'type' => 'enum',
            'default' => 'admin',
            'options' => array(
                'usuario' => 'Usuário',
                'permission' => 'Permissão',
                'admin' => 'Administrador',
                'webmaster' => 'Webmaster',
            ),
            'grid' => true,
            'display' => true,
        ),
        'permission' => array(
            'name' => 'Permissão',
            'type' => 'varchar',
            'size' => '32',
            'grid' => true,
            'display' => true,
        ),
        'updateplugins' => array(
            'name' => 'Atualizar Plugin',
            'type' => 'enum',
            'default' => 'false',
            'options' => array(
                'false' => 'Não',
                'true' => 'Sim',
            ),
            'grid' => true,
            'display' => true,
        ),
        'configs' => array(
            'name' => 'Configurações',
            'type' => 'int',
            'notnull' => true,
            'grid' => true,
            'display' => true,
            'display_in' => 'table',
            'fkey' => array(
                'refmodel' => 'site/conffile',
                'model' => 'site/conf',
                'cardinalidade' => 'n1',
                'keys' => array('file', 'name'),
                'sort' => 'cod_conf ASC',
            )
        ),
        'button' => array('button' => 'Gravar Arquivo'),
    );

}
