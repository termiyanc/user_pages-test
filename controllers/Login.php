<?php
namespace Controllers;

use Engine\Config;
use Engine\Controller;
use Engine\Db;

/**
 * Контроллер авторизации
 */
class Login extends Controller
{
    public $defaultAction = 'actionLogin';
    /**
     * Метод обрабатывает авторизацию пользователя
     */
    public function actionLogin()
    {
        //  Если есть определенный пользователь, удаляю его сессии
        if ($this->user) {
            $this->deleteUserSessions();
        }
        if ($_POST) {
            //  Определяю пользователя
            $this->user = Db::getRow("SELECT id, name
                                      FROM   user
                                      WHERE  name = '$_POST[name]' and password = md5('$_POST[password]')");
            //  Генерирую идентификатор сессии по имени пользователя и id
            //  и устанавливаю соответствующую куку
            $sessionId = md5($this->user['name'].$this->user['id']);
            setcookie(Config::get('session.cookie'), $sessionId);
            //  Удаляю сессии входящего пользователя
            $this->deleteUserSessions($this->user['id']);
            //  Создаю сессию пользователя
            Db::query("INSERT user_session(user_id, session_id, started, expires)
                       SELECT {$this->user['id']}, '$sessionId', now(), date_add(now(), INTERVAL ".Config::get('session.expires')." SECOND)");
            //  Произвожу перенаправление на основной адрес
            $this->redirect();
        } else {
            $this->render('login');
        }
    }

    /**
     * Метод обрабатывает выход пользователя
     */
    public function actionLogout()
    {
        //  Обнуляю куку
        setcookie(Config::get('session.cookie'));
        //  Удаляю сессии выходящего пользователя
        $this->deleteUserSessions();
        $this->render('login');
    }

    /**
     * Метод удаляет сессии пользователя
     * @param integer $userId
     */
    private function deleteUserSessions($userId = null)
    {
        if ($userId = $userId ? : $this->user['id']) {
            //  Удаляю строки сессий пользователя
            Db::query("DELETE 
                       FROM   user_session
                       WHERE  user_id = $userId");
        }
    }
}
