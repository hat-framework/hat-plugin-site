<?php

class site_confData extends \classes\Model\DataModel {

    public $dados = array(
        'cod_conf' => array(
            'name' => 'Código',
            'type' => 'int',
            'size' => '11',
            'pkey' => true,
            'ai' => true,
            'grid' => true,
            'display' => true,
            'private' => true
        ),
        'fieldset' => array(
            'name' => 'Fieldset',
            'type' => 'varchar',
            'size' => '64',
            'grid' => true,
            'display' => true,
            'description' => 'O fieldset permite que o usuário veja o formulário com esta configuração organizado por fieldset'
        ),
        'name' => array(
            'name' => 'Name',
            'type' => 'varchar',
            'size' => '64',
            'unique' => array('model' => 'site/conf'),
            'grid' => true,
            'display' => true,
            'description' => 'O nome não deve conter espaços e deve ser único no sistema. 
                Nenhuma outra configuração pode conter o mesmo nome'
        ),
        'label' => array(
            'name' => 'Label',
            'type' => 'varchar',
            'size' => '128',
            'grid' => true,
            'display' => true,
            'description' => 'Este é o nome que aparecerá no formulário para o usuário final'
        ),
        'type' => array(
            'name' => 'Type',
            'type' => 'enum',
            'default' => 'varchar',
            'options' => array(
                'int' => 'Número Inteiro',
                'date' => 'Data',
                'decimal' => 'Decimal',
                'varchar' => 'Texto',
                'text' => 'Parágrafo',
                'enum' => 'Lista'
            ),
            'grid' => true,
            'display' => true,
            'description' => 'Tipo de dado que aparecerá no formulário'
        ),
        'especial' => array(
            'name' => 'Tipo Especial',
            'type' => 'varchar',
            'size' => '64',
            'description' => 'Tipo de dado especial que aparecerá no formulário'
        ),
        'options' => array(
            'name' => 'Options',
            'type' => 'text',
            'dinamic' => array(
                'type' => 'show',
                'target' => 'type',
                'option' => 'enum'
            ),
            'description' => 'Se o tipo enum foi marcado insira novas options usando o formato:
                "OptionValue" => "OptionLabel" separados por ponto e vírgula, sendo que nem OptionLabel e nem OptionValue podem
                conter ponto e vírgula'
        ),
        'default' => array(
            'name' => 'Padrão',
            'type' => 'varchar',
            'size' => '64',
            'grid' => true,
            'dinamic' => array(
                'type' => 'show',
                'target' => 'type',
                'option' => 'enum'
            ),
            'description' => "O valor padrão deve ser uma referência para 'OptionValue' do campo Options"
        ),
        'description' => array(
            'name' => 'Descrição',
            'type' => 'text',
        ),
        'value' => array(
            'name' => 'Valor',
            'type' => 'text',
            //'size'     => '256',
            'grid' => true,
            'display' => true,
        ),
        'value_default' => array(
            'name' => 'Valor Default',
            'type' => 'text',
            //'size'     => '256',
            'private' => true,
        ),
        'file' => array(
            'name' => 'Arquivo',
            'type' => 'int',
            'notnull' => true,
            'grid' => true,
            'display' => true,
            'fkey' => array(
                'model' => 'site/conffile',
                'cardinalidade' => '1n',
                'keys' => array('cod_cfile', 'title'),
                'onupdate' => 'cascade',
                'ondelete' => 'cascade',
            )
        ),
        'button' => array('button' => 'Gravar Configuração'),
    );

}
