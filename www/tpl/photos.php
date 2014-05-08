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