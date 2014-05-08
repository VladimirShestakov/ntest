<?php
/**
 * Виджет выбора типа сортировки
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace widgets;

class Sorting extends Widget
{
    function show($v = array())
    {
        if (isset($_GET['order'])) {
            $v['order'] = $_GET['order'] == 'vote' ? 'vote' : 'created';
        } else {
            $v['order'] = 'created';
        }
        return parent::show($v);
    }
}