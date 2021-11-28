<?php


namespace App\Core;


use Monolog\Logger;
use Noodlehaus\Config;

/**
 * Class RegBox
 * @package App\Core
 * @method static Config Config()
 * @method static Logger Logger()
 * @method static DB DB()
 * @method static Tpl Tpl()
 */
class Core
{
    use ObjBox;
    public static $nameSpace = "\\App\\Core\\";
}