<?php
/**
 * Отображение фотографий с фильтром, сортировкой и постраничной навигацией
 * @version 1.0
 */
include 'config.php';
include 'functions.php';

$db = new PDO($config['db']['dsn'], $config['db']['user'], $config['db']['passw'], $config['db']['options']);

/** @var array $v Значения для шаблона */
$v = array();

// Для формирования SQL
$alias = 0;
$ln = "\n";
$join = '';
$where = '';
$binds = array();

// Фильтр по тегам
$selected = isset($_GET['sel']) && is_array($_GET['sel']) ? array_flip($_GET['sel']) : array();
$unselected = isset($_GET['unsel']) && is_array($_GET['unsel']) ? array_flip($_GET['unsel']) : array();
$v['tags'] = array();
$q = $db->prepare('SELECT * FROM tags ORDER BY cnt DESC LIMIT 0,6');
$q->execute();
while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
    $row['select'] = isset($selected[$row['id']]);
    $row['unselect'] = isset($unselected[$row['id']]);
    $v['tags'][] = $row;
    $alias++;
    if ($row['select']) {
        // Условие выборки
        $join .= 'LEFT JOIN photo_tags t' . $alias . ' ON t' . $alias . '.tag_id = ? AND t' . $alias . '.photo_id = photo.id' . $ln;
        if ($where) $where .= ' AND ';
        $where .= 't' . $alias . '.tag_id IS NOT NULL';
        $binds[] = $row['id'];
    }
    if ($row['unselect']) {
        // Условие выборки
        $join .= 'LEFT JOIN photo_tags t' . $alias . ' ON t' . $alias . '.tag_id = ? AND t' . $alias . '.photo_id = photo.id' . $ln;
        if ($where) $where .= ' AND ';
        $where .= 't' . $alias . '.tag_id IS NULL';
        $binds[] = $row['id'];
    }
}
if ($where) $where = ' WHERE ' . $where;

// Сортировка
if (isset($_GET['order'])) {
    $v['order'] = $_GET['order'] == 'vote' ? 'vote' : 'created';
} else {
    $v['order'] = 'created';
}

// Постраничная навигация
$q = $db->prepare('SELECT count(id) cnt FROM photo ' . $join . $where);
$q->execute($binds);
$v['page_show'] = 10;
if ($row = $q->fetch(PDO::FETCH_ASSOC)) {
    $v['pages_cnt'] = ceil($row['cnt'] / 20);
} else {
    $v['pages_cnt'] = 1;
}

if (isset($_GET['page'])) {
    $v['page_active'] = max(1, min($v['pages_cnt'], intval($_GET['page'])));
} else {
    $v['page_active'] = 1;
}
// С какой страницы начинать
$v['page_first'] = max(1, $v['page_active'] - $v['page_show']);
if ($v['page_first'] <= $v['page_show']) $v['page_first'] = 1;
// На какой странице закончить
$v['page_end'] = min($v['pages_cnt'], $v['page_active'] + $v['page_show']);
if ($v['page_end'] > ($v['pages_cnt'] - $v['page_show'])) $v['page_end'] = $v['pages_cnt'];
$v['pages_uri'] = '?order=' . $v['order'];

// Список фотографий
$start = ($v['page_active'] - 1) * 20;
$q = $db->prepare('SELECT * FROM photo ' . $join . $where . ' ORDER BY ' . $v['order'] . ' DESC LIMIT ' . $start . ',20');
$q->execute($binds);
$v['photos'] = $q->fetchAll(PDO::FETCH_ASSOC);

// Отображение
include('view/main.php');