<?php
return [
    "log" => [
        "name" => "php-app.log",
        "file_path" => APP_PATH . DS . ".." . DS . "tmp" . DS . "php-app.log",
        "level" => \Monolog\Logger::DEBUG,
    ]
];
