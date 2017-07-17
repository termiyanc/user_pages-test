<?php
namespace Engine;
/**
 * Класс маршрутизации
 * @package Engine
 */
class Router
{
    //  Контроллер по умолчанию
    private static $defaultController = 'Main';

    /**
     * Метод выполняет маршрутизацию
     */
    public static function run()
    {
        //  Работаю с переданным маршрутом ...
        if ($_REQUEST['route']) {
            $parts = explode('/', trim($_REQUEST['route'], '/'));
            $controllerNameWithNs = '\\Controllers\\'. ($controllerName = ucfirst(array_shift($parts)));
            if ($controller = new $controllerNameWithNs) {
                $actionName = $parts ? 'action' . ucfirst(array_shift($parts)) : $controller->defaultAction;
                call_user_func_array([$controller, $actionName], $parts);
            }
        }
        //  ... или действую по умолчанию
          else {
            $controllerName = '\\Controllers\\'.self::$defaultController;
            $controller = new $controllerName;
            $controller->{$controller->defaultAction}();
        }
    }
}