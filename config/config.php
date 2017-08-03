<?php
return [
    //  Параметры для соединения с базой данных
    'db' => [
        'host' => 'localhost',
        'port' => null,
        'user' => 'root',
        'password' => 'root',
        'db_name' => 'user_pages_test'
    ],
    //  Параметры сессии
    'session' => [
        //  Название куки сессии
        'cookie' => 'USER_PAGES_SESSID',
        //  Продолжительность сессии в секундах
        'expires' => 1800
    ],
    //  Протоколирование
    'debug' => false
];