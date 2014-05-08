<?php
/**
 * Отображение фотографий с фильтром, сортировкой и постраничной навигацией
 * @version 1.0
 */
// Подключение конфигурации
include 'config.php';
// Подключение автозагрузчика и его инициализация
include 'core/Autoload.php';
// Примитивный роутинг запроса
if (isset($_POST['call'], $_POST['photo_id']) &&  $_POST['call'] == 'like'){
    // Голосование
    $photo = new models\Photo(array('id'=>$_POST['photo_id']));
    $photo->like();
    // Возвращется новое количество лайков
    echo $photo->vote;
}else{
    // Отображение страниц
    echo widgets\Widget::insert('Layout', 'layout.php');
}