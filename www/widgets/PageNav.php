<?php
/**
 * Виджет выбора фильтра
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace widgets;

use core\DB;

class PageNav extends Widget
{
    function show($v = array())
    {
        // Постраничная навигация
        $v['page_show'] = 10;
        if (isset($_GET['pages_cnt'])) {
            $v['pages_cnt'] = intval($_GET['pages_cnt']);
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

        return parent::show($v);
    }
}