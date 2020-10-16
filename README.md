# marvel-api-consumer
A small POC using php tools like slim 4, twig, php-di, guzzlehttp and symfony dotenv

This poc uses guzzlehttp to hit marvel API and retrieve information about its characters.
As Marvel has many I've choosen just 6 to show on the interface.

The Marvel API requires an authentication to authorize requests, so if you don't have your
keys see the [doc here](https://developer.marvel.com/docs) get them.

With your keys in hand just put them on the `.env` file as below:

```
MARVEL_PUB_KEY=<your public key>
MARVEL_PRIV_KEY=<your private key>
```

After clone the repository and set keys values lets install all dependencies

```
$ cd /path/to/repo
$ composer install --no-dev
```

See how to install composer [here](https://getcomposer.org/download/)

Now lets run your server

```
$ php -S 127.0.0.1:8000 -t public/
```
