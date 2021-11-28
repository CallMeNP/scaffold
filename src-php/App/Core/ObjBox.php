<?php


namespace App\Core;

use ReflectionClass;
use ReflectionException;

trait ObjBox
{
    //public static $nameSpace = "\\"; // 需要在实际的 Class 中定义此属性
    public static $objList = [];

    public static function set($name, $obj)
    {
        self::$objList[$name] = $obj;
    }

    public static function unset($name)
    {
        unset(self::$objList[$name]);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed|object
     * @throws ReflectionException
     */
    public static function __callStatic($name, $arguments = [])
    {
        $key = $name . ($arguments ? json_encode($arguments) : '');
        if (isset(self::$objList[$key])) {
            return self::$objList[$key];

        }
        $className = self::$nameSpace . str_replace('_', '\\', $name);
        $nrc = new ReflectionClass($className);

        $obj = $nrc->newInstanceArgs($arguments);
        self::$objList[$key] = $obj;
        return $obj;

    }
}