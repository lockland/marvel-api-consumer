<?php

namespace App\Model\Storage\Converter;

use App\Model\Storage\ConverterInterface;
use App\Model\{Character, ID, Image};

class MarvelConverter implements ConverterInterface
{
    private $data = [];

    public function setData($data)
    {
        if (is_string($data)) {
            $this->data = json_decode($data, true);
        } elseif (is_array($data) && isset($data['data']['results'])) {
            $this->data = $data;
        } else {
            throw new \InvalidArgumentException("Invalid Marvel API data structure");
        }
    }


    public function toObject()
    {
        $result = [];

        foreach ($this->data['data']['results'] as $character) {
            $stories = [];
            for ($i = 0; $i < 5; $i++) {
                if (isset($character['stories']['items'][$i]['name'])) {
                    $stories[] = $character['comics']['items'][$i]['name'];
                }
            }

            $result[] = new Character(
                new ID($character['id']),
                $character['name'],
                $character['description'],
                new Image($character['thumbnail']['path'], $character['thumbnail']['extension']),
                $stories
            );
        }

        return $result;
    }

    public function toArray()
    {
        return $this->data;
    }
}
