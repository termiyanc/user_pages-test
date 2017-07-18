<style type="text/css">
    <?=$this->asset('css/page.css', true)?>
</style>
<form method="post">
    <label>Заголовок: <input type="text" name="title"></label>
    <label>Шапка: <textarea name="header"></textarea></label>
    <label>Основное содержимое: <textarea name="general_content"></textarea></label>
    <label>Дополнительное содержимое: <textarea name="additional_content"></textarea></label>
    <input type="submit" value="Создать">
</form>