<?php
if ($page) {
?>
<style type="text/css">
    <?=$this->asset('css/page.css', true)?>
</style>
<form action="<?=$this->url('pages', 'change', $page['id'])?>" method="post">
    <label>Заголовок: <input type="text" name="title" value="<?=$page['title']?>"/></label>
    <label>Шапка: <textarea name="header"><?=$page['header']?></textarea></label>
    <label>Основное содержимое: <textarea name="general_content"><?=$page['general_content']?></textarea></label>
    <label>Дополнительное содержимое: <textarea name="additional_content"><?=$page['additional_content']?></textarea></label>
    <input type="submit" value="Сохранить"/>
</form>
<?
} else {
?>
Страница не найдена.
<?php
}