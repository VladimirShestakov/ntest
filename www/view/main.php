<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Фотки</title>
    <link rel="stylesheet" href="/view/style.css"/>
    <script src="/view/jquery-1.11.0.min.js"></script>
    <script src="/view/like.js"></script>
</head>
<body>
    <div class="layout">
        <div class="layout__sidebar">
            <div class="filter">
                <form method="get" enctype="application/x-www-form-urlencoded">
                    <input type="hidden" name="order" value="<?=$v['order']?>">
                    <h4>Выбрать</h4>
                    <?php foreach($v['tags'] as $key => $tag):?>
                        <div class="item">
                            <input id="sel<?=$key?>" type="checkbox" name="sel[]" value="<?=$tag['id']?>" <?=$tag['select']?'checked':''?>/>
                            <label for="sel<?=$key?>"><?=$tag['name']?></label>
                        </div>
                    <?php endforeach; ?>
                    <h4>Исключить</h4>
                    <?php foreach($v['tags'] as $key => $tag):?>
                        <div class="item">
                            <input id="unsel<?=$key?>" type="checkbox" name="unsel[]" value="<?=$tag['id']?>" <?=$tag['unselect']?'checked':''?>/>
                            <label for="unsel<?=$key?>"><?=$tag['name']?></label>
                        </div>
                    <?php endforeach; ?>
                    <br/>
                    <input type="submit" value="Показать">
                </form>
            </div>
        </div>
        <div class="layout__main">
            <div class="sort">
                Сортировка по: <a class="sort__item <?=$v['order']=='vote'?'sort__item_active':''?>" href="<?=url('',array('order'=>'vote'))?>">голосам</a> | <a class="sort__item <?=$v['order']=='created'?'sort__item_active':''?>" href="<?=url('',array('order'=>'created'))?>">дате добавления</a>
            </div>
            <div class="photos">
                <?php foreach ($v['photos'] as $photo):?>
                <div class="photo">
                    <img src="<?=$photo['file']?>" alt="" height="200"/>
                    <div class="photo__info">
                        <div class="photo__tags"></div>
                        <div class="photo__like"><span class="photo__like-link" data-id="<?=$photo['id']?>">Like</span> (<span class="photo__like-value"><?=($photo['vote']>0?'+':'').$photo['vote']?></span>)</div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <div class="pagenav">
                <ul class="pagenav__list cf">
                    <li class="pagenav__item pagenav__info">Страницы с 1 до <?php echo $v['pages_cnt']?></li>
                    <?php
                    if ($v['page_active'] > 1) echo '<li class="pagenav__item"><a href="'.url('',array('page'=>$v['page_active']-1)).'">←</a></li>';

                    if ($v['page_first'] > $v['page_show']){
                        echo '<li class="pagenav__item"><a href="'.url('',array('page'=>1)).'">1</a></li>';
                        echo '<li class="pagenav__item">...</li>';
                    }
                    for ($i = $v['page_first']; $i <= $v['page_end']; $i++){
                        echo '<li class="pagenav__item'.($i==$v['page_active']?' pagenav__item_active':'').'"><a href="'.url('',array('page'=>$i)).'">'.$i.'</a></li>';
                    }
                    if ($v['page_end'] <= ($v['pages_cnt'] - $v['page_show'])){
                        echo '<li class="pagenav__item">...</li>';
                        echo '<li class="pagenav__item"><a href="'.url('',array('page'=>$v['pages_cnt'])).'">'.$v['pages_cnt'].'</a></li>';
                    }

                    if ($v['page_active'] < $v['pages_cnt']) echo '<li class="pagenav__item"><a href="'.url('',array('page'=>$v['page_active']+1)).'">→</a></li>';
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>