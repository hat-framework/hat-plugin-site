<?php
class menuComponent extends classes\Component\Component{
    public $list_in_table = true;
    protected $listActions = array('Editar' => "edit", 'Excluir' => "apagar");
    
    public function listInTable($model, $itens, $title = "", $class = '', $drawHeaders = false, $header = array()) {
        $this->LoadJsPlugin('jqueryui/jqueryui', 'jui');
        $url  = $this->Html->getLink('site/menu/load');
        $url2 = $this->Html->getLink('site/menu/reorder');
        $this->Html->LoadJqueryFunction("
            $('#menu-dropdown:first .action_perm').click(function(event){
                event.preventDefault();
                var post = $(this).parent().attr('id');
                $.ajax({
                    url: '$url',
                    type: 'POST',
                    data: {post: post},
                    dataType: 'json',
                    success: function(json) {
                        if(json.status == '0'){
                            alert(json.erro);
                            return;
                        }
                    },
                    error: function(erro){
                        alert('erro');
                    }
                });
            }); 
            
            $('#menu-dropdown:first' ).sortable({
                update: function(event, ui) {
                    var fruitOrder = $(this).sortable('toArray').toString();
                    $.ajax({
                        url: '$url2',
                        type: 'POST',
                        data: {order: fruitOrder},
                        dataType: 'json',
                        success: function(json) {
                            if(json.status == '0'){
                                alert(json.erro);
                            }
                        },
                        error: function(erro){
                            alert('erro');
                        }
                    });
                }
            });
        ");
        
        parent::form($model);
        parent::listInTable($model, $itens, $title, $class, $drawHeaders, $header);
    }
    
}
?>