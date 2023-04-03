<?php

use project\common\LogRuntime;
use project\common\LogXhprofRuntime;

if (!function_exists('dateRangeConflict')) {
    function dateRangeConflict($dateRangeArr)
    {
        //把时间段进行排序,时间轴上从小到大排列
        sort($dateRangeArr);

        foreach ($dateRangeArr as $k => $v) {
            $i = $k + 1;
            //较小时间段的结束日期 > 较大时间段的开始日期大,那么日期有冲突
            if (isset($dateRangeArr[$i]) && $v[1] > $dateRangeArr[$i][0]) {
                return [$v, $dateRangeArr[$i]];
            }
        }
    }
}

if (!function_exists('randNick')) {
    function randNick($n = 3): string
    {
        $nick = '';
        for ($i = 0; $i < $n; $i++) {
            $nick .= mb_chr(mt_rand(0x4E00, 0x9FA5));
        }
        return $nick;
    }
}

if (!function_exists('readableDate')) {
    function readableDate($time, $timezone = 'Asia/Shanghai'): string
    {
        $format = str_contains($time, '.') ? 'U.u' : 'U';
        $dateTime = new DateTime();
        $dateTime->createFromFormat($format, $time, new DateTimeZone($timezone));
        return $dateTime->format('Y-m-d H:i:s.u');
    }
}

if (!function_exists('readableBytes')) {
    function dbTime($micro = true): string
    {
        $time = microtime(true);

        $arr = explode(".", $time);

        $currentTime = $arr[0];

        $microStr = substr($arr[1], 0, 3);

        return $micro ? date("Y-m-d H:i:s", $currentTime) . "." . $microStr : date("Y-m-d H:i:s", $currentTime);
    }
}

if (!function_exists('readableTime')) {
    function readableTime($size, $scale = 3): string
    {
        $unit = ['s', 'ms', 'μs', 'ns', 'ps', 'fs'];
        //指数
        $i =  - (($size > 1 || $size == 0) ? 0 : floor(log($size,1000)));
        $min = min(count($unit) - 1, $i);
        //基数
        $operand = pow(1000, $min);

        return round($operand *  $size, $scale) . $unit[$min];
    }
}

if (!function_exists('readableBytes')) {
    function readableBytes($size, $scale = 3): string
    {
        $unit = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        //指数
        $i = $size < 1024 ? 0 : floor(log($size,1024));
        //基数
        $operand = pow(1024, $i);

        return round($size / $operand, $scale) . $unit[$i];
    }
}

if (!function_exists('ip')) {
    function ip(): string
    {
        $ip = 'unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim(current($ip));
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? $ip;
        }

        return $ip;
    }
}


if (!function_exists('uncamelize')) {
    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     * @param string $camelCaps
     * @param string $separator
     * @return string
     */
    function uncamelize(string $camelCaps, string $separator = '_'): string
    {
        $str = preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps);

        $str = preg_replace('/([0-9])([A-Z])/', "$1" . $separator . "$2", $str);

        return strtolower($str);
    }
}

if (!function_exists('camelize')) {
    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     * @param string $uncamelize
     * @param bool   $class
     * @param string $separator
     * @return string
     */
    function camelize(string $uncamelize, bool $class = true, string $separator = '_'): string
    {
        $uncamelize = $separator . str_replace($separator, " ", strtolower($uncamelize));

        $uncamelize = ltrim(str_replace(" ", "", ucwords($uncamelize)), $separator);

        return $class ? ucwords($uncamelize) : $uncamelize;
    }
}


