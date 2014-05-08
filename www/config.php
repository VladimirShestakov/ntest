<?php
/** @cont string Полный путь директории сайта на сервере. Без слеша на конце. */
define('DOCUMENT_ROOT', get_root_dir());

/** @cont string Директория сайта относительно домена (там, где файл index.php). Слеш в начале и конце обязателен! */
define('DIR_WEB', get_web_dir());

/** @cont string Директория сайта на сервере. Слеш в конце обязателен! */
define('DIR_SERVER', DOCUMENT_ROOT.DIR_WEB);

/**
 * Определение корневой директории сервера
 * @return string
 */
function get_root_dir()
{
    if (empty($_SERVER['DOCUMENT_ROOT'])){
        // Если переменной окружения нет, то вычисляем из пути на исполняемый файл
        $_SERVER['DOCUMENT_ROOT'] = dirname($_SERVER['SCRIPT_FILENAME']);
    }
    return rtrim($_SERVER['DOCUMENT_ROOT'],'/\\');
}

/**
 * Определение корневой директории относительно домена сайта
 * @return string
 */
function get_web_dir()
{
    preg_match('|^'.preg_quote(DOCUMENT_ROOT,'|').'(.*)index\.php$|', $_SERVER['SCRIPT_FILENAME'], $find);
    if ($find[1] == null) {
        $find[1] = "/";
    }
    return $find[1];
}