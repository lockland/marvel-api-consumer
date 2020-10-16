<?php

namespace App\Model\Storage;

use GuzzleHttp\Client;
use App\Model\StorageInterface;
use App\Model\Storage\ConverterInterface;
use App\Model\Storage\Converter\MarvelConverter;
use App\Model\ID;
use App\Service\IOService;

class MarvelStorage implements StorageInterface
{
    private const FILE_PATH = __DIR__ . '/../../../tmp/cache/storage.json';
    private const API_URL = 'https://gateway.marvel.com/v1/public/characters?';
    private const FILE_MAX_AGE = 60 * 60 * 24;

    private $pub_key = '';
    private $priv_key = '';
    private $client = null;
    private $io = null;

    public function __construct($pub_key, $priv_key, IOService $io = null, Client $client = null)
    {
        $this->pub_key = $pub_key;
        $this->priv_key = $priv_key;
        $this->client = $client;
        $this->io = $io;

        if (is_null($client)) {
            $this->client = new Client(['timeout' => 10.0]);
        }

        if (is_null($io)) {
            $this->io = new IOService();
        }
    }

    protected function request()
    {
        $result = [
            'data' => ['results' => []]
        ];

        $list = ['iron man', 'spider-man', 'black widow', 'hulk', 'thanos', 'magik (illyana rasputin)'];

        foreach ($list as $name) {
            $time = time();
            $params = [
                'name' => $name,
                'ts' => $time,
                'apikey' => $this->pub_key,
                'hash' => md5($time . $this->priv_key . $this->pub_key),
            ];

            $content = $this->fetch($params);
            $result['data']['results'] = array_merge($result['data']['results'], ($content['data']['results'] ?? []));
        }

        return $result;

    }
    protected function fetch($params)
    {
        $response = $this->client->request('GET', self::API_URL . http_build_query($params));
        return json_decode($response->getBody(), true);
    }

    public function fetchAll(ConverterInterface $converter = null)
    {
        $converter = $converter ?? new MarvelConverter();

        if (! $this->isFileTooOld()) {
            $converter->setData($this->io->read(self::FILE_PATH));
            return $converter->toObject();
        }

        try {
            $converter->setData($this->store($this->request()));
        } catch (\Exception $e) {
            error_log($e);
        }

        return $converter->toObject();
    }

    private function isFileTooOld()
    {
        $mtime = file_exists(self::FILE_PATH) ? stat(self::FILE_PATH)[9] : 0;
        return ((time() - $mtime) > self::FILE_MAX_AGE);
    }

    private function store(array $content)
    {
        if (! empty($content)) {
            $this->io->write(self::FILE_PATH, $content);
        }

        return $content;
    }

    public function fetchById(ID $id, ConverterInterface $converter = null)
    {
        $converter = $converter ?? new MarvelConverter();
        $converter->setData($this->io->read(self::FILE_PATH));
        foreach ($converter->toObject() as $character) {
            if ($character->id->equals($id)) {
                return $character;
            }
        }

        return null;
    }
}
