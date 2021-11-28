<?php


namespace App\Service\Helper;


class File
{
    static public function lsFile($basePath, $reg, $maxDepth = 0, $dirReg = '//')
    {
        $result = [];
        // 列出目录下文件
        $arr = scandir($basePath);
        foreach ($arr as $item) {
            if ($item == '.' or $item == '..') {
                continue;
            }
            if (preg_match($reg, $item) and is_file($basePath . DS . $item)) {
                $result[] = $item;
            }
            if ($maxDepth > 0 and is_dir($basePath . DS . $item) and preg_match($dirReg, $item)) {
                $subResult = self::lsFile($basePath . DS . $item, $reg, $maxDepth - 1);
                // 参数集应为数组形式，并拼装前缀路径
                $subResult = array_map(function ($f) use ($item) {
                    return $item . DS . $f;
                }, $subResult);
                $result = array_merge($result, $subResult);
            }
        }
//        $arr = array_filter($arr, function ($f) use ($reg) {
//            return preg_match($reg, $f);
//        });
//        return array_values($arr);
        return $result;
    }

    static public function lsDir($basePath, $reg = '//', $maxDepth = 0, $dirReg = '//')
    {
        $result = [];
        // 列出目录下文件
        $arr = scandir($basePath);
        foreach ($arr as $item) {
            if ($item == '.' or $item == '..') {
                continue;
            }
            if (preg_match($reg, $item) and is_dir($basePath . DS . $item)) {
                $result[] = $item;
            }
            if ($maxDepth > 0 and is_dir($basePath . DS . $item) and preg_match($dirReg, $item)) {
                $subResult = self::lsDir($basePath . DS . $item, $reg, $maxDepth - 1);
                // 参数集应为数组形式，并拼装前缀路径
                $subResult = array_map(function ($f) use ($item) {
                    return $item . DS . $f;
                }, $subResult);
                $result = array_merge($result, $subResult);
            }
        }
        return $result;

    }

    static public function rm($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::rm("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    static public function replaceExt($filePath, $oldExt, $newExt)
    {
        assert(str_ends_with($filePath, ".$oldExt"));
        return preg_replace("/\.$oldExt$/", $newExt?".$newExt":"", $filePath);
    }

    static public function trimBasePath($path, $basePath)
    {
        assert(str_starts_with($path, $basePath));
        return substr($path, strlen($basePath));
    }

    public static function filepath2className($filepath)
    {
        $filepath = File::trimBasePath(realpath($filepath), APP_PATH . DS . 'src');
        $noExt = dirname($filepath) . DS . basename($filepath, '.php');
        return str_replace(DS, '\\', $noExt);
    }

}