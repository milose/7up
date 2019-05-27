<?php

if (!function_exists('me')) {
    function me()
    {
        return auth()->user();
    }
}

if (!function_exists('my')) {
    function my()
    {
        return auth()->user();
    }
}

if (!function_exists('random_str')) {
    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}

if (!function_exists('human_filesize')) {
    function human_filesize($bytes)
    {
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), [0,0,2,2,3][$i]).['B','kB','MB','GB','TB'][$i];
    }
}
