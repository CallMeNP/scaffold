<?php


namespace App\Core;

use App\Service\Converter\Json2Native;
use App\Service\Converter\Native2Json;
use App\Service\Mock;
use App\Service\XML2IES;
use App\Service\外字;

/**
 * Class SrvBox
 * @package App\Core
 * @method static Mock Mock()
 */
class Service
{
    use ObjBox;
    public static $nameSpace = "\\App\\Service\\";

}
