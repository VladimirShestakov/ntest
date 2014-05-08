<?php
/**
 * Модель
 * Только самое необходимое для тестовой задачи
 * @author Vladimir Shestakov
 * @version 1.0
 */
namespace models;

use core\DB;
use PDO;

class Model
{
    protected $table = '';
    protected $is_loaded;
    protected $attribs = array(
        'id' => 0
    );

    function __construct($attribs = array(), $is_loaded = false)
    {
        $this->attribs = array_replace($this->attribs, $attribs);
        $this->is_loaded = $is_loaded;
    }

    /**
     * Получение атрибута по имени
     * @param $name
     * @return null
     */
    function __get($name)
    {
        if (!$this->is_loaded) $this->load();
        if (isset($this->attribs[$name])) return $this->attribs[$name];
        return null;
    }

    /**
     * Загрузка атрибутов объекта из базы
     */
    function load()
    {
        if (!empty($this->attribs['id']) && !empty($this->table)){
            $db = DB::connect();
            $q = $db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $q->execute(array($this->attribs['id']));
            if ($row = $q->fetch(PDO::FETCH_ASSOC)){
                $this->attribs = array_replace($this->attribs, $row);
            }
        }
        $this->is_loaded = true;
    }
}
 