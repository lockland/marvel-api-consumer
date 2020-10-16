<?php

namespace App\Model;

class Character
{
    public function __construct(ID $id, $name, $desc, Image $image, array $stories = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $desc;
        $this->image = $image;
        $this->stories = $stories;
    }

    public function getImagePath()
    {
        return $this->image->getPath();
    }
}
