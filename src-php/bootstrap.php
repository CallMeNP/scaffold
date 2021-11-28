<?php
require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('PRC');
ini_set('default_charset', 'utf-8');

define("DS", DIRECTORY_SEPARATOR);
define("ENV", "dev");
define("APP_PATH", realpath(__DIR__ . DS . ".."));
define("SRC_PATH", __DIR__);

$config = new \Noodlehaus\Config(__DIR__ . DS . "config" . DS . ENV . "/");
\App\Core\Core::set('Config', $config);

$logger = new \Monolog\Logger($config->get("log.name"));
$fileHandler = new \Monolog\Handler\StreamHandler($config->get("log.file_path"), $config->get("log.level"));
$logger->pushHandler($fileHandler);
\App\Core\Core::set('Logger', $logger);
