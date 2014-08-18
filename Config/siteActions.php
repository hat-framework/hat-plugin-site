<?php 
use classes\Classes\Actions;
class siteActions extends Actions{
    protected $permissions = array(
        'siteGerenciarMenu' => array(
            'nome'      => "siteGerenciarMenu",
            'label'     => "Gerenciar Itens do menu",
            'descricao' => "Permite adicionar e remover itens do menu",
            'default'   => 'n',
        ),
        
        'siteGerenciarConfFiles' => array(
            'nome'      => "siteGerenciarConfFiles",
            'label'     => "Gerenciar Arquivos de Configurações",
            'descricao' => "Permite adicionar e remover Arquivos de configurações do sistema",
            'default'   => 'n',
        ),
        
        'siteAlterarConfiguracao' => array(
            'nome'      => "siteAlterarConfiguracao",
            'label'     => "Alterar as configurações do site",
            'descricao' => "Permite modificar as configurações do site de acordo com o tipo de acesso do usuário:
                webmaster, admin e usuário",
            'default'   => 'n',
        ),
    );
    protected $actions = array(
        
        'site/index/index' => array(
            'label' => 'Configurações do Site', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteAlterarConfiguracao',
            'menu' => array('site/index/index')
        ),
        
        
        
        'site/menu/index' => array(
            'label' => 'Itens do Menu', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarMenu',
            'breadscrumb' => array('site/configuracao/index','site/menu/index')
        ),
        'site/menu/formulario' => array(
            'label' => 'Adicionar Item ao Menu', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarMenu',
            'breadscrumb' => array('site/configuracao/index','site/menu/index', 'site/menu/formulario')
        ),
        'site/menu/edit' => array(
            'label' => 'Editar item', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarMenu', 'needcod' => true,
            'breadscrumb' => array('site/configuracao/index','site/menu/index', 'site/menu/edit')
        ),
        
        
        
        
        
        'site/confgrupo/index' => array(
            'label' => 'Todas os Grupos', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles',
            'menu' => array('site/index/index')
        ),
        
        'site/confgrupo/formulario' => array(
            'label' => 'Criar Grupo', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 
            'menu' => array('Voltar' => 'site/confgrupo/index')
        ),
        
        'site/confgrupo/edit' => array(
            'label' => 'Editar Grupo', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array('Voltar' => 'site/confgrupo/show')
        ),
        
        'site/confgrupo/apagar' => array(
            'label' => 'Apagar Grupo', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array('Voltar' => 'site/confgrupo/show')
        ),
        'site/confgrupo/show' => array(
            'label' => 'Visualizar Grupo', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array(
                'site/confgrupo/index',
                'Ações' => array(
                    'site/confgrupo/edit',
                    'site/confgrupo/apagar'
                )
             )
        ),
        
        
        
        'site/conffile/index' => array(
            'label' => 'Arquivos de Configuração', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles',
            'menu' => array(
                'Voltar'       => 'site/index/index',
                'Novo Arquivo' => 'site/conffile/formulario',
             )
        ),
        
        'site/conffile/formulario' => array(
            'label' => 'Criar Arquivo de Configurações', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 
            'menu' => array('Voltar' => 'site/confgrupo/show')
        ),
        
        'site/conffile/edit' => array(
            'label' => 'Editar Arquivo de Configurações', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array('Voltar' => 'site/conffile/show')
        ),
        
        'site/conffile/apagar' => array(
            'label' => 'Apagar Arquivo de Configurações', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array('Voltar' => 'site/conffile/show')
        ),
        'site/conffile/show' => array(
            'label' => 'Visualizar Arquivo de Configuração', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array(
                'site/confgrupo/show',
                'Ações' => array(
                    'site/conf/formulario',
                    'site/conffile/edit',
                    'site/conffile/apagar'
                )
             )
        ),
        
        
        
        
        
        'site/conf/index' => array(
            'label' => 'Todas as Configurações', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles',
            'menu' => array('site/index/index')
        ),
        
        'site/conf/formulario' => array(
            'label' => 'Criar Configuração', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 
            'menu' => array('Voltar' => 'site/conffile/index')
        ),
        
        'site/conf/edit' => array(
            'label' => 'Editar Configuração', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array('Voltar' => 'site/conffile/show')
        ),
        
        'site/conf/apagar' => array(
            'label' => 'Apagar Configuração', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array('Voltar' => 'site/conffile/show')
        ),
        'site/conf/show' => array(
            'label' => 'Visualizar Configuração', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array(
                'site/conffile/show',
                'Ações' => array(
                    'site/conf/edit',
                    'site/conf/apagar'
                )
             )
        ),
        
        
        
        'site/configuracao/index' => array(
            'label' => 'Todas as Configurações', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteAlterarConfiguracao', 'needcod' => true,
            'menu' => array(
                'Central de Aplicativos'     => 'plugins/plug',
                "Logs" => array(
                    'Arquivos de Log'          => 'site/index/log',
                    'Logs de Acesso'           => 'usuario/acesso/report',
                ),
                'Avançado' => array(
                    'Menu Superior'            => 'site/menu/index',
                    'Arquivos de Configuração' => 'site/conffile/index',
                    'Arquivos de Cache'        => 'site/index/cache',
                 )                     
             )
        ),
        
        'site/index/log' => array(
            'label' => 'Log do sistema', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array(
                'site/index/cache'
             ),
            'breadscrumb' => array('site/configuracao/index', 'site/index/log'),
        ),
        
        'site/index/cache' => array(
            'label' => 'Cache do sistema', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteGerenciarConfFiles', 'needcod' => true,
            'menu' => array(
                'site/index/log'
             ),
            'breadscrumb' => array('site/configuracao/index', 'site/index/cache'),
        ),
        
        'site/configuracao/group' => array(
            'label' => 'Grupo de Configurações', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => 'siteAlterarConfiguracao', 'needcod' => true,
            'menu' => array('Central de Aplicativos'     => 'plugins/plug'),
            'breadscrumb' => array('site/configuracao/index', 'site/configuracao/group'),
        ),
        
    );
}