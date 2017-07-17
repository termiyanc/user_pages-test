<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Интерфейс для работы со страницами</title>
    <style type="text/css">
        *{
            font-size: 10pt;
            font-family: Verdana;
            color: #000;
        }
        body{
            margin-top: 10px;
        }
        table{
            border-collapse: collapse;
        }
        tr:first-child{
            padding: 0;
        }
        .page-action *{
            font-style: italic;
            color: #8c8c8c;
        }
        div.block{
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<?php
include $viewPath;
?>
</body>
</html>