<?php
/**
 * Автозагрузчик php классов
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace core;

class Autoload
{
    static function activate($class_name = ''){
        if (empty($class_name)){
            // Актвация самого себя
            spl_autoload_register(array('\core\Autoload', 'activate'));
        }else{
            $class_path = DIR_SERVER.str_replace('\\', '/', ltrim($class_name, '\\')).'.php';
            if (is_file($class_path)){
                include_once($class_path);
            }
        }
        return true;
    }
}
// Инициализация автозагрузчика
Autoload::activate();
 