<div class="sort">
    Сортировка по: <a class="sort__item <?=$v['order']=='vote'?'sort__item_active':''?>" href="<?=\core\F::url('',array('order'=>'vote'))?>">голосам</a> | <a class="sort__item <?=$v['order']=='created'?'sort__item_active':''?>" href="<?=\core\F::url('',array('order'=>'created'))?>">дате добавления</a>
</div>