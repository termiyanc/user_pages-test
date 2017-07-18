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
        Db::query("DELETE 
                   FROM   page
                   WHERE  id = $id and user_id = {$this->user['id']}");
        //  Произвожу перенаправление на основной адрес
        $this->redirect();
    }

    /**
     * Метод отвечает за поиск по страницам
     */
    public function actionSearch()
    {
        //  Произвожу поиск,
        //  записываю в сессию данные поиска
        $this->setSessionData(['searchValue' => $_POST['search_value'], 'searchResults' => Db::query("SELECT id, title, header, general_content, additional_content
                                                                                                      FROM   page
                                                                                                      WHERE  user_id = {$this->user['id']} and 
                                                                                                             (title like '%$_POST[search_value]%' or 
                                                                                                              header like '%$_POST[search_value]%' or 
                                                                                                              general_content like '%$_POST[search_value]%' or 
                                                                                                              additional_content like '%$_POST[search_value]%')")]);
        //  Произвожу перенаправление на основной адрес
        $this->redirect();
    }
}