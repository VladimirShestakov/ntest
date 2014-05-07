<?php
/**
 * Добавление или отмена лайка на фотку.
 * Обработка AJAX запросов. Клиенту возвращает новое количество лайков за фотку
 * Пользователь выбирается случайно или из куки
 *
 * @version 1.0
 */
include 'config.php';

if (isset($_POST['photo_id'])) {
    $db = new PDO($config['db']['dsn'], $config['db']['user'], $config['db']['passw'], $config['db']['options']);
    // Текущий пользователь. Авторизации нет, чисто для создания отношений в базе
    if (isset($_COOKIE['user_id'])) {
        $q = $db->prepare('SELECT id FROM users WHERE id =?');
        $q->execute(array($_COOKIE['user_id']));
        if ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $row['id'];
        }
    }
    // Случайный выбор пользователя
    if (!isset($user_id)) {
        $q = $db->query('SELECT id FROM users LIMIT ' . rand(0, 9000) . ',1');
        if ($row = $q->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $row['id'];
        } else {
            $user_id = 0;
        }
    }
    setcookie('user_id', $user_id, 0, '/');
    // Добавление отношения между фоткой и юзером.
    $q = $db->prepare('INSERT IGNORE INTO votes(photo_id, user_id) VALUES (?,?)');
    $q->execute(array($_POST['photo_id'], $user_id));
    if ($q->rowCount() == 0) {
        // Отношение есть, поэтому отменяем лайк
        $q = $db->prepare('DELETE FROM votes WHERE photo_id =? AND user_id = ?');
        $q->execute(array($_POST['photo_id'], $user_id));
        $like = -1;
    } else {
        $like = 1;
    }
    $q = $db->prepare('UPDATE photo SET vote = vote + ? WHERE id = ?');
    $q->execute(array($like, $_POST['photo_id']));
}
// Выбор нового значения
$q = $db->prepare('SELECT vote FROM photo WHERE id =?');
$q->execute(array($_POST['photo_id']));
if ($row = $q->fetch(PDO::FETCH_ASSOC)) {
    echo $row['vote'];
} else {
    echo 0;
}