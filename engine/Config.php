<?php
namespace Engine;
/**
 * Класс конфигурации
 */
class Config
{
    private static $config;

    /**
     * Метод определяет конфигурацию
     * @param string $configPath
     */
    public static function init($configPath)
    {
        if (file_exists($configPath)) {
            self::$config = include $configPath;
        } else {
            die('Не определен файл конфигурации!');
        }
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