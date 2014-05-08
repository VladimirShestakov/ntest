<?php
/**
 * Авторизация
 * Только для получения текущего пользователя и
 * автоматической авторизации под случайного пользователя при первом посещении
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace core;

class Auth
{
    static private $user;

    static function getUserId()
    {
        if (!isset(self::$user)){
            $db = DB::connect();
            // Текущий пользователь. Авторизации нет, чисто для создания отношений в базе
            if (isset($_COOKIE['user_id'])) {
                $q = $db->prepare('SELECT id FROM users WHERE id =?');
                $q->execute(array($_COOKIE['user_id']));
                if ($row = $q->fetch(\PDO::FETCH_ASSOC)) {
                    self::$user = $row['id'];
                }
            }
            // Случайный выбор пользователя
            if (!isset($user_id)) {
                $q = $db->query('SELECT id FROM users LIMIT ' . rand(0, 9000) . ',1');
                if ($row = $q->fetch(\PDO::FETCH_ASSOC)) {
                    self::$user = $row['id'];
                } else {
                    self::$user = 0;
                }
            }
            setcookie('user_id', self::$user, 0, '/');
        }
        return self::$user;
    }
}
 