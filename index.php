<?php
define('ROOT', dirname(__FILE__));
define('BASE_URL', preg_replace('/(.+)(?:\?.*)/', '$1', $_SERVER['REQUEST_URI']));

function __autoload($name)
{
    if (file_exists($filename = ROOT."\\$name.php")) {
        include $filename;
    }
}

//  Инициализирую конфигурацию
Engine\Config::init(ROOT.'/config/config.php');
//  Определяю уровень протоколирования
if (Engine\Config::get('debug')) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}

//  Инициализирую соединение с базой данных
Engine\Db::init();
//  Запускаю маршрутизацию
Engine\Router::run();
