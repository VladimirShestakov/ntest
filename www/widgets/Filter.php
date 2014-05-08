<?php
/**
 * Виджет выбора фильтра
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace widgets;

use core\DB;

class Filter extends Widget
{
    function show($v = array())
    {
        $db = DB::connect();
        // Фильтр по тегам
        $selected = isset($_GET['sel']) && is_array($_GET['sel']) ? array_flip($_GET['sel']) : array();
        $unselected = isset($_GET['unsel']) && is_array($_GET['unsel']) ? array_flip($_GET['unsel']) : array();
        $v['tags'] = array();
        $q = $db->prepare('SELECT * FROM tags ORDER BY cnt DESC LIMIT 0,6');
        $q->execute();
        while ($row = $q->fetch(\PDO::FETCH_ASSOC)) {
            $row['select'] = isset($selected[$row['id']]);
            $row['unselect'] = isset($unselected[$row['id']]);
            $v['tags'][] = $row;
        }
        // С учётом сортировки
        if (isset($_GET['order'])) {
            $v['order'] = $_GET['order'] == 'vote' ? 'vote' : 'created';
        } else {
            $v['order'] = 'created';
        }
        return parent::show($v);
    }
}