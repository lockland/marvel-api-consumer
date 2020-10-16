<?php

namespace App\Service;

class IOService
{
    public function read($file, $isJson = true)
    {
        $str = file_get_contents($file);
        return $isJson ? json_decode($str, true) : $str;
    }

    public function write($file, $content, $toJson = true)
    {
        $content = $toJson ? json_encode($content) : $content;
        return file_put_contents($file, $content);
    }
}
