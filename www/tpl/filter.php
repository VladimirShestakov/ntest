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