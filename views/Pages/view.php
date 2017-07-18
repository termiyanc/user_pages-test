<?php
if ($page) {
?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=$page['title']?></title>
    <link rel="stylesheet" type="text/css" href="<?=$this->asset('css/common.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=$this->asset('css/view.css')?>">
</head>
<body>
    <div class="block with-underline">
        <a href="<?=$this->url('Pages', 'change', $page['id'])?>">Изменить</a>
        <a href="<?=$this->url('Pages', 'delete', $page['id'])?>">Удалить</a>
        <a href="<?=$this->url('Main')?>">На главную</a>
    </div>
    <div class="header"><?=$page['header']?></div>
    <div class="general-content"><?=$page['general_content']?></div>
    <div class="additional-content"><?=$page['additional_content']?></div>
</body>
</html>
<?
} else {
?>
    Страница не найдена.
<?php
}