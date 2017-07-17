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
        //  Определяю пользователя
        if ($this->user = Db::getRow("SELECT id, name
                                      FROM   user
                                      WHERE  name = '$_POST[name]' and password = md5('$_POST[password]')")) {

            $sessionId = md5($this->user['name']);

            setcookie(Config::get('session.cookie'), $sessionId);
            //  Удаляю сессии входящего пользователя
            $this->deleteUserSessions($this->user['id']);
            //  Создаю сессию пользователя
            Db::query("INSERT user_session(user_id, session_id, started, expires)
                       SELECT {$this->user['id']}, '$sessionId', now(), date_add(now(), INTERVAL ".Config::get('session.expires')." SECOND)");
            //  Определяю страницы пользователя

            $this->render('Main/main', ['pages' => Db::query("SELECT id, title
                                                              FROM   page
                                                              WHERE  user_id = {$this->user['id']}
                                                              ORDER 
                                                              BY     created_at")]);

        } else {
            $this->render('login');
        }
    }

    /**
     * Метод обрабатывает выход пользователя
     */
    public function actionLogout()
    {
        setcookie(Config::get('session.cookie'));
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
            //  Удаляю строки сессий, связанные с пользователем
            Db::query("DELETE 
                       FROM   user_session
                       WHERE  user_id = $userId");
        }
    }
}