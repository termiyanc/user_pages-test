<?php
if ($page) {
?>
<html>
<head>
    <title><?=$page['title']?></title>
    <link rel="stylesheet" type="text/css" href="<?=$this->asset('css/view.css')?>">
</head>
<body>
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