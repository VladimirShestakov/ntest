<?php
/**
 * Виджет фотографий
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace widgets;

use core\DB;

class Photos extends Widget
{
    function show($v = array())
    {
        $db = DB::connect();
        // Для формирования SQL
        $alias = 0;
        $ln = "\n";
        $join = '';
        $where = '';
        $binds = array();

        // Фильтр по тегам
        $selected = isset($_GET['sel']) && is_array($_GET['sel']) ? $_GET['sel'] : array();
        $unselected = isset($_GET['unsel']) && is_array($_GET['unsel']) ? $_GET['unsel'] : array();
        foreach ($selected as $s){
            $alias++;
            // Условие выборки
            $join .= 'LEFT JOIN photo_tags t' . $alias . ' ON t' . $alias . '.tag_id = ? AND t' . $alias . '.photo_id = photo.id' . $ln;
            if ($where) $where .= ' AND ';
            $where .= 't' . $alias . '.tag_id IS NOT NULL';
            $binds[] = $s;
        }
        foreach ($unselected as $s){
            $alias++;
            // Условие выборки
            $join .= 'LEFT JOIN photo_tags t' . $alias . ' ON t' . $alias . '.tag_id = ? AND t' . $alias . '.photo_id = photo.id' . $ln;
            if ($where) $where .= ' AND ';
            $where .= 't' . $alias . '.tag_id IS NULL';
            $binds[] = $s;
        }
        if ($where) $where = ' WHERE ' . $where;

        // Сортировка
        if (isset($_GET['order'])) {
            $order = $_GET['order'] == 'vote' ? 'vote' : 'created';
        } else {
            $order = 'created';
        }
        // Общее число фотографий, попадающих под условие фильтра
        $q = $db->prepare('SELECT count(id) cnt FROM photo ' . $join . $where);
        $q->execute($binds);
        $v['page_show'] = 10;
        if ($row = $q->fetch(\PDO::FETCH_ASSOC)) {
            $_GET['pages_cnt'] = ceil($row['cnt'] / 20);
        } else {
            $_GET['pages_cnt'] = 1;
        }

        if (isset($_GET['page'])) {
            $page_active = max(1, min($_GET['pages_cnt'], intval($_GET['page'])));
        } else {
            $page_active = 1;
        }

        // Выбор фотографий
        $start = ($page_active - 1) * 20;
        $q = $db->prepare('SELECT * FROM photo ' . $join . $where . ' ORDER BY ' . $order . ' DESC, id DESC LIMIT ' . $start . ',20');
        $q->execute($binds);
        $v['photos'] = $q->fetchAll(\PDO::FETCH_ASSOC);

        return parent::show($v);
    }
}