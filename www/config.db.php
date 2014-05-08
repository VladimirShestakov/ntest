<?php
/**
 * Параметры подключения к базе по умолчанию
 * @author Vladimir Shestakov
 * @version 1.0
 */
$config = array(
    'dsn' => 'mysql:dbname=nevesta;host=127.0.0.1',
    'user' => 'root',
    'password' => '',
    'options' => array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8" COLLATE "utf8_bin"'
    )
);