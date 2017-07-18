<?php
namespace Controllers;
use Engine\Controller;
use Engine\Db;
/**
 * Контроллер работы со страницами
 */
class Pages extends Controller
{
    protected $authorized = true;
    /**
     * Метод отвечает за просмотр страницы
     * @param integer $id
     */
    public function actionView($id)
    {
        //  Вывожу страницу вне рамок общего шаблона
        $this->render('view', ['page' => Db::getRow("SELECT title, header, general_content, additional_content
                                                     FROM   page
                                                     WHERE  id = $id and user_id = {$this->user['id']}")], null);
    }

    /**
     * Метод отвечает за создание страницы
     */
    public function actionCreate()
    {
        if ($_POST) {
            //  Добавляю страницу
            Db::query("INSERT page(user_id, title, header, general_content, additional_content, created_at) 
                       SELECT {$this->user['id']}, '$_POST[title]', '$_POST[header]', '$_POST[general_content]', '$_POST[additional_content]', now()");
            //  Произвожу перенаправление на основной адрес
            $this->redirect();
        } else {
            $this->render('create');
        }
    }

    /**
     * Метод отвечает за изменение страницы
     * @param integer $id
     */
    public function actionChange($id)
    {
        if ($_POST) {
            //  Обновляю страницу
            Db::query("UPDATE page
                       SET    title = '$_POST[title]', 
                              header = '$_POST[header]', 
                              general_content = '$_POST[general_content]', 
                              additional_content = '$_POST[additional_content]', 
                              updated_at = now()
                       WHERE  id = $id and user_id = {$this->user['id']}");
            //  Произвожу перенаправление на основной адрес
            $this->redirect();
        } else {
            $this->render('change', ['page' => Db::getRow("SELECT id, title, header, general_content, additional_content
                                                           FROM   page
                                                           WHERE  id = $id and user_id = {$this->user['id']}")]);
        }
    }

    /**
     * Метод отвечает за удаление страницы
     * @param integer $id
     */
    public function actionDelete($id)
    {
        //  Удаляю страницу
        Db::query("DELETE 
                   FROM   page
                   WHERE  id = $id and user_id = {$this->user['id']}");
        //  Произвожу перенаправление на основной адрес
        $this->redirect();
    }
}