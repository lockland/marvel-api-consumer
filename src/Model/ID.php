<?php

namespace App\Model;

class ID
{
    private $id = 0;

    public function __construct($id)
    {
        if (! is_numeric($id)) {
            throw new \InvalidArgumentException("Id is invalid");
        }

        $this->id = (int) $id;
    }


    public function getValue()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function equals(ID $id)
    {
        return $this->getValue() == $id->getValue();
    }

}
