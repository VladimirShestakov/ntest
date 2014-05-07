<?php
/** @var array $config Параметры подключения к базе */
$config = array(
    'db' => array(
        'dsn' => 'mysql:dbname=nevesta;host=127.0.0.1',
        'user' => 'root',
        'passw' => '',
        'options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8" COLLATE "utf8_bin"'
        )
    )
);