<?php
/**
 * Модель фотографии
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace models;

use core\Auth;
use core\DB;

class Photo extends Model
{
    protected $table = 'photo';
    protected $attribs = array(
        'id' => 0,
        'file' => '',
        'created' => 0,
        'vote' => 0,
        'user' => 0
    );

    /**
     * Лайк фотографии
     */
    function like()
    {
        if (!empty($this->attribs['id'])){
            $db = DB::connect();
            $id = $this->attribs['id'];
            $user_id = Auth::getUserId();
            // Добавление отношения между фоткой и юзером.
            $q = $db->prepare('INSERT IGNORE INTO votes(photo_id, user_id) VALUES (?,?)');
            $q->execute(array($id, $user_id));
            if ($q->rowCount() == 0) {
                // Отношение есть, поэтому отменяем лайк
                $q = $db->prepare('DELETE FROM votes WHERE photo_id =? AND user_id = ?');
                $q->execute(array($id, $user_id));
                $like = -1;
            } else {
                $like = 1;
            }
            $q = $db->prepare('UPDATE photo SET vote = vote + ? WHERE id = ?');
            $q->execute(array($like, $id));
            $this->attribs['vote'] += $like;
        }
    }
}