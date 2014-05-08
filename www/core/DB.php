<?php
/**
 * Обертка для подключения к базе данных
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace core;

use PDO;

class DB
{
    private static $default_config_file = 'config.db.php';
    private static $default_config;
    private static $connects = array();
    /**
     * Подключение к СУБД
     * Если соединение с указаной конфигурацией уже есть, то повторно не создаётся
     * @param array $config
     * @return PDO
     */
    static function connect($config = array())
    {
        if (empty($config)) $config = self::getDefaultConfig();
        // Ключ подключения
        $key = $config['dsn'].'-'.$config['user'].'-'.$config['password'];
        if (!empty($config['options'])){
            $key.= serialize($config['options']);
        }
        // Если подключения нет, то создаём
        if (!isset(self::$connects[$key])){
            self::$connects[$key] = new PDO($config['dsn'], $config['user'], $config['password'], $config['options']);
            self::$connects[$key]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connects[$key];
    }
    /**
     * Конфигурация подключения поумолчанию
     * @return mixed
     */
    static function getDefaultConfig()
    {
        if (!isset(self::$default_config)){
            include DIR_SERVER.self::$default_config_file;
            if (isset($config)) self::$default_config = $config;
        }
        return self::$default_config;
    }
}
 