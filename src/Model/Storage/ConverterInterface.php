<?php

namespace App\Model\Storage;

interface ConverterInterface
{
    public function toObject();
    public function toArray();
    public function setData($data);
}
