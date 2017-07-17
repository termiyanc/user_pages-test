<?php
namespace Engine;
/**
 * Класс конфигурации
 */
class Config
{
    private static $config;

    /**
     * Метод инициализирует конфигуратор
     * @param string $configDir
     */
    public static function init($configDir)
    {
        self::$config = include $configDir;
    }

    /**
     * Метод получает параметр конфигурации
     * @param  string $path
     * @return mixed
     */
    public static function get($path)
    {
        $parts = explode('.', $path);
        $return = self::$config[array_shift($parts)];
        foreach ($parts as $part) {
            $return = $return[$part];
        }
        return $return;
    }
}