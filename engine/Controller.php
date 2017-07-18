<?php
namespace Engine;

/**
 * Базовый класс контроллера
 */
class Controller
{
    //  Директория представлений
    const VIEWS_DIR = 'views';
    //  Директория подключаемых ресурсов
    const ASSETS_DIR = 'assets';

    //  Пользователь
    public $user;
    //  Данные в сессии
    public $sessionData;
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
            if ($this->user = Db::getRow("SELECT U.id, U.name
                                          FROM   user_session US
                                                     inner join user U on US.user_id = U.id
                                          WHERE  session_id = '$sessionId' and expires >= now()") ? : null) {
                //  Проверяю данные в сессии
                if ($sessionData = Db::getColumn("SELECT data
                                                  FROM   user_session
                                                  WHERE  user_id = {$this->user['id']}", 'data')) {
                    $this->sessionData = unserialize($sessionData);
                    //  Удаляю данные в сессии
                    Db::query("UPDATE user_session
                               SET    data = null
                               WHERE  user_id = {$this->user['id']}");
                }
            }
        }
        //  Если должна быть авторизация и пользовтель не определен,
        //  перенаправляю на форму авторизации
        if ($this->authorized && !$this->user) {
            $this->redirect($this->url('Login'));
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
     * Метод устанавливает данные в сессии
     * @param mixed $data
     */
    public function setSessionData($data)
    {
        Db::query("UPDATE user_session
                   SET    data = '".serialize($data)."'
                   WHERE  user_id = {$this->user['id']}");
    }

    /**
     * Метод выводит представление
     * @param string $view
     * @param array  $vars
     * @param string $template
     * @param bool   $finally
     */
    public function render($view, $vars = [], $template = 'common', $finally = false)
    {
        //  Нахожу представление
        if (($viewPath = $this->findViewFile($view)) === false) {
            die('Представление не найдено!');
        }
        //  Нахожу шаблон, если нужно
        if ($template) {
            if (($templatePath = $this->findViewFile($template)) === false) {
                die('Шаблон не найден!');
            }
        }
        extract($vars);
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
     * Метод подключает элемент
     * @param  string $element
     * @param  array  $vars
     * @return bool|mixed
     */
    public function element($element, $vars = [])
    {
        if ($elementPath = $this->findViewFile($element)) {
            extract($vars);
            return include $elementPath;
        }
        return false;
    }

    /**
     * Метод определяет, существует ли файл представления, элемент,
     * допуская, что файл может быть с различными расширениями
     * @param  string $view
     * @param  array  $extensions
     * @return bool|string
     */
    public function findViewFile($view, $extensions = ['.php', '.html'])
    {
        $viewsDirWithRoot = ROOT . '/' . self::VIEWS_DIR . '/';
        if ($extensions) {
            foreach ($extensions as $extension) {
                if (file_exists($filePath = $viewsDirWithRoot . Tools::getOwnClassName($this) . '/' . "$view$extension")) {
                    return $filePath;
                }
                if (file_exists($filePath = $viewsDirWithRoot . "$view$extension")) {
                    return $filePath;
                }
            }
            return false;
        }
        return file_exists($filePath = $viewsDirWithRoot . "$view") ? $filePath : false;
    }

    /**
     * Метод возвращает путь или содержимое подключаемого ресурса
     * @param  string $asset
     * @param  bool   $getContent
     * @return bool|string
     */
    public function asset($asset, $getContent = false)
    {
        if (file_exists($assetPath = ROOT . '/' . self::ASSETS_DIR . '/' . $asset)) {
            if ($getContent) {
                return file_get_contents($assetPath);
            }
            return BASE_URL . '/' . self::ASSETS_DIR . '/' . $asset;
        }
        return false;
    }

    /**
     * Метод выполняет перенаправление
     * @param $url
     * Если адрес не указан, произодится перенаправление на основной адрес
     */
    public function redirect($url = BASE_URL)
    {
        header("Location: $url");
        exit();
    }

    /**
     * Метод генерирует url
     * @param  string $controller
     * @param  string $action
     * @param  array  $params
     * @return string
     */
    public function url($controller, $action = '', $params = [])
    {
        $url = BASE_URL . "?route=$controller/$action";
        if ($params) {
            foreach ((array)$params as $param) {
                $url .= '/'.rawurlencode($param);
            }
        }
        return $url;
    }
}