<?php

namespace App\Model;

use App\Model\Storage\ConverterInterface;
use App\Model\ID;

interface StorageInterface
{
    public function fetchAll(ConverterInterface $converter = null);

    public function fetchById(ID $id, ConverterInterface $converter = null);
}
