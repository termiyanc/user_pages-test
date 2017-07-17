<?php
namespace Engine;
/**
 * Базовый класс контроллера
 */
class Controller
{
    //  Пользователь
    protected $user;
    //  Должна ли быть авторизация при работе с контроллером
    protected $authorized;
    //  Действие по умолчанию
    public $defaultAction = 'actionIndex';

    /*
     * Метод-конструктор. Проверяет авторизацию
     */
    public function __construct()
    {
        //  Проверяю пользователя
        if ($sessionId = $_COOKIE[Config::get('session.cookie')]) {
            $this->user = Db::getRow("SELECT U.id, U.name
                                      FROM  user_session US
                                                inner join user U on US.user_id = U.id
                                      WHERE session_id = '$sessionId' and expires >= now()") ? : null;
        }
        //  Если должна быть авторизация и пользовтель не определен,
        //  перенаправляю на форму авторизации
        if ($this->authorized && !$this->user) {
            $this->render('Login/login', [], 'common', true);
        }
    }

    /**
     * Метод пытается отобразить представление при вызове несуществующего метода
     * @param string $name
     * @param array  $arguments
     */
    public function __call($name, $arguments)
    {
        $this->render($name);
    }

    /**
     * Метод инициирует вывод представления
     * @param string $view
     * @param array  $params
     * @param string $template
     * @param bool   $finally
     */
    public function render($view, $params = [], $template = 'common', $finally = false)
    {
        //  Пытаюсь найти представление, соответствующее контроллеру
        if (($viewPath = $this->findViewFile(Tools::getOwnClassName($this)."/$view")) === false) {
            //  Пытаюсь найти отдельное представление
            if (($viewPath = $this->findViewFile($view)) === false) {
                die('Представление не найдено!');
            }
        }
        if ($template) {
            if (($templatePath = $this->findViewFile($template)) === false) {
                die('Шаблон не найден!');
            }
        }
        extract($params);
        if ($template) {
            include $templatePath;
        } else {
            include $viewPath;
        }
        if ($finally) {
            exit();
        }
    }

    /**
     * Метод определяет, существует ли файл представления
     * @param string $name
     * @param array  $extensions
     * @param string $viewsDirectory
     * @return bool|string
     */
    public function findViewFile($view, $extensions = ['.php', '.html'], $viewsDirectory = 'views')
    {
        if ($extensions) {
            foreach ($extensions as $extension) {
                if (file_exists($filePath = ROOT."\\$viewsDirectory\\$view$extension")) {
                    return $filePath;
                }
            }
            return false;
        }
        return file_exists($filePath = ROOT."\\$viewsDirectory\\$view") ? $filePath : false;
    }

    /**
     * Метод выполняет перенаправление
     * @param $url
     */
    public function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    /**
     * Метод генерирует url
     * @param string $controller
     * @param string $action
     * @param array $params
     * @return string
     */
    public function url($controller, $action = '', $params = [])
    {
        $url = BASE_URL."?route=$controller/$action";
        if ($params) {
            foreach ((array)$params as $param) {
                $url .= '/'.rawurlencode($param);
            }
        }
        return $url;
    }

    public function setUser()
    {
        $this->user;
    }
}