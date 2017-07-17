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
        $page = current(Db::query("SELECT   title, header, general_content, additional_content
                                   FROM   page
                                   WHERE  id = $id and user_id = {$this->user['id']}"));
        $this->render('view', compact('page'), null);
    }

    /**
     * Метод отвечает за создание страницы
     */
    public function actionCreate()
    {
        if ($_POST) {
            Db::query("INSERT page(user_id, title, header, general_content, additional_content, created_at) 
                       SELECT {$this->user['id']}, '$_POST[title]', '$_POST[header]', '$_POST[general_content]', '$_POST[additional_content]', now()");
            $this->redirect($this->url('pages', 'view', [Db::getColumn("SELECT max(id) as id
                                                                        FROM   page
                                                                        WHERE  user_id = {$this->user['id']}", 'id')]));
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
            $this->redirect($this->url('pages', 'view', $id));
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
        $this->redirect($this->url('main'));
    }
}