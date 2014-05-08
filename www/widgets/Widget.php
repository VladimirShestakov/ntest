<?php
/**
 * Виджет
 * Базовый класс для всех виджетов
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace widgets;

class Widget
{
    /** @var string Файл шаблон виджета */
    protected $tpl;

    /**
     * Создание и отображение виджета по имени
     * Используется в шаблонах
     * @param string $name Класс виджета относительно widgtes\
     * @param string $tpl Файл шаблона. Путь относительно tpl/
     * @return string Результат отображения
     */
    static function insert($name, $tpl)
    {
        $class = '\\widgets\\'.$name;
        if (class_exists($class)){
            $widget = new $class($tpl);
        }else{
            $widget = new self($tpl);
        }
        return $widget->show();
    }

    function __construct($tpl)
    {
        $this->tpl = $tpl;
    }

    /**
     * Отображение виджета
     * @param array $v Значения для шаблона
     * @return string
     */
    function show($v = array())
    {
        ob_start();
        // Выполнение своей работы
        $file = DIR_SERVER.'tpl/'.$this->tpl;
        if (is_file($file)){
            include $file;
        }else{
            echo 'Шаблон '.htmlspecialchars($this->tpl).' не найден';
        }
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}