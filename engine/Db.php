<?php
namespace Engine;
/**
 * Класс базы данных
 */
class Db
{
    private static $connection;

    /**
     * Метод инициализирует соединение с базой данных
     */
    public static function init()
    {
        self::$connection = new \PDO('mysql:host=' . Config::get('db.host') . ';dbname=' . Config::get('db.db_name'), Config::get('db.user'), Config::get('db.password'));
    }

    /**
     * Метод выполняет запрос
     * @param  string $query
     * @param  bool   $fetch
     * @return mixed
     */
    public static function query($query, $fetch = true)
    {
        if (!self::$connection) {
            self::init();
        }
        $result = self::$connection->query($query);
        if ($fetch) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $result;
        }
    }

    /**
     * Метод выполняет запрос и возвращает определенный столбец
     * @param  string $query
     * @param  string $column
     * @return mixed
     */
    public static function getColumn($query, $column)
    {
        $row = self::getRow($query);
        return $row[$column];
    }

    /**
     * Метод выполняет запрос и возвращает одну строку результата
     * @param  string $query
     * @return mixed
     */
    public static function getRow($query)
    {
        return self::query($query, false)->fetch(\PDO::FETCH_ASSOC);
    }
}