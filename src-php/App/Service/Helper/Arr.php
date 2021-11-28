<?php


namespace App\Service\Helper;


class Arr
{

    /**
     * 通过类似 jsonPath 的表达式获取数组中的值。
     * @param array $arr
     * @param string $expr
     * @return array|bool
     *
     * expr 的语法为 jsonPath 的子集。以'$'为根元素，其余部分仅支持'.'分割的 key 。
     * key 可以被 `[]` 包裹，如数组下标的语法。
     * key 可以被 `""`, `''` 包裹，从而空字符串也可以做key,
     * key 中不能出现 '.'，即使被引号包裹也不行。
     */
    static function simpleFetch(array $arr, string $expr)
    {
        if (is_string($expr)) {
            $expr = explode(".", $expr);
        }
        if (!$expr or $expr[0] != '$') {
            // todo exception
            return false;
        }
        array_shift($expr);
        $res =& $arr;
        foreach ($expr as $key) {
            if (preg_match('/^\[.+]$|^".*"$|^\'.*\'$/', $key)
            ) {
                $key = substr($key, 1, -1);
            }
            if (!isset($res[$key])) {
                return null;
            }
            $res =& $res[$key];
        }
        return $res;
    }

    static function simpleSet(array &$arr, $expr, $value)
    {
        if (is_string($expr)) {
            $expr = explode(".", $expr);
        }
        if (!$expr or $expr[0] != '$') {
            return false;
        }
        array_shift($expr);
        $res =& $arr;
        foreach ($expr as $key) {
            if (preg_match('/^\[.+]$|^".*"$|^\'.*\'$/', $key)
            ) {
                $key = substr($key, 1, -1);
            }
            if (!is_array($res)) {
                $res = [];
            }
            if (!isset($res[$key])) {
                $res[$key] = [];
            }
            $res =& $res[$key];

        }
        $res = $value;
        return $res;
    }
}