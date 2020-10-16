<?php

namespace App\Model;

class Image
{
    private $path = "";
    private $ext = "";

    public function __construct($path, $extension)
    {
        if (parse_url($path) === false) {
            throw new \InvalidArgumentException("Path is invalid");
        }

        $this->path = $path;
        $this->ext = $extension;
    }


    public function getPath()
    {
        return "$this->path.$this->ext";
    }

    public function __toString()
    {
        return $this->getPath();
    }

}
