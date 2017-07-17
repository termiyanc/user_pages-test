<style type="text/css">
    label input{
        display: block;
        margin-bottom: 5px;
    }
</style>
<form action='<?=$this->url('login')?>' method="post">
    <label>Имя пользователя: <input type="text" name="name"/></label>
    <label>Пароль: <input type="text" name="password"/></label>
    <input type="submit" value="Войти"/>
</form>