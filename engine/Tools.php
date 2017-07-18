<?php
namespace Engine;

/**
 * Служебный класс
 */
class Tools
{
    /**
     * Метод определяет непосредственное имя класса
     * @param  string $object
     * @return string
     */
    public static function getOwnClassName($object)
    {
        return preg_replace('/.*([^\\\\]+$)/U', '$1', get_class($object));
    }
}