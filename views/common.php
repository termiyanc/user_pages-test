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
        table.pages{
            border-collapse: collapse;
            background: #f5f5f5;
            margin: 10px 0;
        }
        table.pages td{
            padding: 5px;
        }
        a{
            text-decoration: none;
            border-bottom: 1px solid #000;
        }
        a:hover{
            border-bottom: none;
        }
        .page-link{
            border-bottom-style: dotted;
        }
        .page-action{
            font-style: italic;
        }
        div.block{
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
include $viewPath;
?>
</body>
</html>