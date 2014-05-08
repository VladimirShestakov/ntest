<div class="pagenav">
    <ul class="pagenav__list cf">
        <li class="pagenav__item pagenav__info">Страницы с 1 до <?php echo $v['pages_cnt']?></li>
        <?php
        if ($v['page_active'] > 1) echo '<li class="pagenav__item"><a href="'.\core\F::url('',array('page'=>$v['page_active']-1)).'">←</a></li>';

        if ($v['page_first'] > $v['page_show']){
            echo '<li class="pagenav__item"><a href="'.\core\F::url('',array('page'=>1)).'">1</a></li>';
            echo '<li class="pagenav__item">...</li>';
        }
        for ($i = $v['page_first']; $i <= $v['page_end']; $i++){
            echo '<li class="pagenav__item'.($i==$v['page_active']?' pagenav__item_active':'').'"><a href="'.\core\F::url('',array('page'=>$i)).'">'.$i.'</a></li>';
        }
        if ($v['page_end'] <= ($v['pages_cnt'] - $v['page_show'])){
            echo '<li class="pagenav__item">...</li>';
            echo '<li class="pagenav__item"><a href="'.\core\F::url('',array('page'=>$v['pages_cnt'])).'">'.$v['pages_cnt'].'</a></li>';
        }

        if ($v['page_active'] < $v['pages_cnt']) echo '<li class="pagenav__item"><a href="'.\core\F::url('',array('page'=>$v['page_active']+1)).'">→</a></li>';
        ?>
    </ul>
</div>