<?php
$url_fundamentalista = "http://finance-e.com/blog/categoria/show/1-analise-fundamentalista";
$url_curso           = "";

die(json_encode(array(
    'mrgrana' => array(
        'title'   => '',
        'text'    => 'Olá, eu sou o <b>Mr. Grana</b> Serei seu consultor de investimento Finance-e, Qual o seu nível de investidor?',
        'options' => array(
            array('classe' => 'btn-danger' , 'title' => 'Iniciante', 'target' => 'iniciante'),
            array('classe' => 'btn-warning', 'title' => 'Novato'   , 'target' => 'novato'),
            array('classe' => 'btn-primary', 'title' => 'Médio'    , 'target' => 'medio'),
            array('classe' => 'btn-success', 'title' => 'Expert'   , 'target' => 'expert'),
         )
    ),
    
    'iniciante' => array(
        'title'   => 'Iniciante',
        'text'    => 'Se você nunca investiu, fique tranquilo, a finance-e é o lugar certo para você! Sobre o que você gostaria de aprender primeiro?',
        'options' => array(
            array('classe' => 'btn-danger' , 'title' => 'O que preciso aprender para investir com segurança?'    , 'target' => 'aprender'),
            array('classe' => 'btn-warning', 'title' => 'Eu conseguirei ficar rico investindo e em quanto tempo?', 'target' => 'ficar_rico'),
            array('classe' => 'btn-primary', 'title' => 'Quero Comprar minha primeira ação Agora!'               , 'target' => 'comprar_agora'),
         )
    ),
        'aprender' => array(
            'title'   => 'O que preciso aprender?',
            'text'    => 'Para investir com segurança, recomendamos a leitura sobre <a href="" target="_BLANK"><b>análise fundamentalista</b></a> no nosso blog<hr/>'
            . 'Uma outra forma de aprendizado é fazer <a href=""><b>Este curso</b></a> sobre investimentos<hr/>',
            'options' => array(
                array('classe' => 'btn-primary' , 'title' => 'Ler o Blog'    , 'target' => 'blog'),
                array('classe' => 'btn-success' , 'title' => 'Fazer o curso' , 'target' => 'curso'),
            )
        ),
    
        'ficar_rico' => array(
            'title'   => 'É possível enriquecer?',
            'text'    => 'Sim, é possível enriquecer através do mercado de ações! '
            . 'É relativamente simples: compre ações de <a target="_Blank" href="http://www.finance-e.com/blog/artigo/show/1/boas-empresas"><b>boas empresas</b></a><hr/>'
            . 'Seja consistente em seus investimentos: todo mês invista um bom, e ao longo dos anos você irá enriquecer naturalmente<hr/>',
            'options' => array(
                array('classe' => 'btn-danger' , 'title' => 'Quero viver apenas de investimentos', 'target' => 'aprender'),
            )
        ),
    
            'blog'  => array('redirect' => $url_fundamentalista),
            'curso' => array('redirect' => $url_curso),
    
    'novato' => array(
        'title'   => 'Novato',
        'text'    => 'Em desenvolvimento',
        'options' => array()
    ),
    
    'medio' => array(
        'title'   => 'Médio',
        'text'    => 'Em desenvolvimento',
        'options' => array()
    ),
    
    'expert' => array(
        'title'   => 'Expert',
        'text'    => 'Em desenvolvimento',
        'options' => array()
    ),
), JSON_HEX_QUOT | JSON_HEX_TAG));
