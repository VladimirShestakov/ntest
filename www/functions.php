<?php
/**
 * Формировние URL
 * @param string $path Путь
 * @param array $args Аргументы адреса
 * @param bool $append Добавлять к существующим аргументам?
 * @return string
 */
function url($path, $args = array(), $append = true)
{
    if ($append) $args = array_merge($_GET, $args);
    if ($args && is_array($args)) {
        $path .= '?';
        foreach ($args as $name => $value) {
            $name = htmlspecialchars($name);
            if (is_array($value)) {
                foreach ($value as $v) {
                    $path .= $name . '[]=' . htmlspecialchars($v) . '&';
                }
            } else {
                $path .= $name . '=' . htmlspecialchars($value) . '&';
            }
        }
        $path = rtrim($path, '&');
    }
    return $path;
}