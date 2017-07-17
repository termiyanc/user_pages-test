<?php
namespace Controllers;

use Engine\Controller;
use Engine\Db;

/**
 * Основной контроллер
 */
class Main extends Controller
{
    protected $authorized = true;

    /**
     * Метод выводит основную страницу интерфейса
     */
    public function actionIndex()
    {
        $this->render('main', ['pages' => Db::query("SELECT id, title, header, general_content, additional_content
                                                     FROM   page
                                                     WHERE  user_id = {$this->user['id']}
                                                     ORDER
                                                     BY     created_at")]);
    }
}