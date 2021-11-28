<?php


namespace App\Core;


use App\Service\Helper\File;
use FilesystemIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;

class NamespaceCommandLoader implements CommandLoaderInterface
{
    static private string $baseNS;
    const NS_SEPARATOR = ':';
    const WORD_SEPARATOR = '-';

    public function __construct($baseNameSpace = '\\App\\Command')
    {
        self::$baseNS = $baseNameSpace;
    }

    public static function cmdName2className($cmdName)
    {
        $arr = explode(self::NS_SEPARATOR, $cmdName);
        array_walk($arr, function (&$item) {
            $item = str_replace(self::WORD_SEPARATOR, '', ucwords($item, self::WORD_SEPARATOR));
        });
        $arr = implode('\\', $arr);
        return self::$baseNS . '\\' . $arr;
    }

    public static function classname2cmdName($classname)
    {
        $classname = File::trimBasePath($classname, self::$baseNS . '\\');
        $arr = explode('\\', $classname);
        array_walk($arr, function (&$item) {
            $sep = preg_replace('/([^A-Z24])([A-Z])(.)/', '\1-\2\3', $item);
            $item = strtolower($sep);
        });
        $arr = implode(self::NS_SEPARATOR, $arr);
        return $arr;
    }

    public function get(string $name)
    {
        $className = NamespaceCommandLoader::cmdName2className($name);
        /**
         * @var $obj Command
         */
        $obj=new $className();
        $obj->setName($name);
        return $obj;
    }

    public function has(string $name)
    {
        return class_exists(NamespaceCommandLoader::cmdName2className($name));
    }

    public function getNames()
    {
        $rdi = new \RecursiveDirectoryIterator(SRC_PATH . DS . str_replace('\\', DS, self::$baseNS), FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_FILEINFO);
        new class($rdi) extends \RecursiveFilterIterator
        {
            public function accept()
            {
                if ($this->current()->isFile() and $this->current()->getExtension() != 'php') {
                    return false;
                }
                return true;
            }
        };
        $rii = new \RecursiveIteratorIterator($rdi);
        $names = iterator_to_array($rii, false);
        return array_map(function ($name) {
            return NamespaceCommandLoader::classname2cmdName(File::filepath2className($name));
        }, $names);
    }

}
