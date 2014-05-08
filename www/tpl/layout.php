<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Фотки</title>
    <link rel="stylesheet" href="/tpl/style/style.css"/>
    <script src="/tpl/js/jquery-1.11.0.min.js"></script>
    <script src="/tpl/js/like.js"></script>
</head>
<body>
    <div class="layout">
        <div class="layout__sidebar">
            <?=\widgets\Widget::insert('Filter', 'filter.php')?>
        </div>
        <div class="layout__main">
            <?=\widgets\Widget::insert('Sorting', 'sorting.php')?>
            <?=\widgets\Widget::insert('Photos', 'photos.php')?>
            <?=\widgets\Widget::insert('PageNav', 'pagenav.php')?>
        </div>
    </div>
</body>
</html>