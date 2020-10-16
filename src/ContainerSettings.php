<?php

use App\Model\StorageInterface;
use App\Model\Storage\MarvelStorage;
use App\Service\IOService;


return [
    IOService::class => new IOService,
    StorageInterface::class => new MarvelStorage(getenv('MARVEL_PUB_KEY'), getenv('MARVEL_PRIV_KEY')),
];
