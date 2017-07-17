<?php
if ($page) {
?>
<html>
<head>
    <title><?=$page['title']?></title>
    <style type="text/css">
        *{
            color: #000;
            font-family: Verdana;
        }
        .header{
            font-size: 16pt;
        }
        .general-content,
        .additional-content{
            font-size: 12pt;
        }
        .additional-content{
            color: #8c8c8c;
        }
    </style>
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