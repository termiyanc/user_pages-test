<style type="text/css">
    label input,
    label textarea{
        display: block;
        margin-bottom: 5px;
    }
    label textarea{
        width: 300px;
        height: 80px;
    }
</style>
<form method="post">
    <label>Заголовок: <input type="text" name="title"/></label>
    <label>Шапка: <textarea name="header"></textarea></label>
    <label>Основное содержимое: <textarea name="general_content"></textarea></label>
    <label>Дополнительное содержимое: <textarea name="additional_content"></textarea></label>
    <input type="submit" value="Создать"/>
</form>