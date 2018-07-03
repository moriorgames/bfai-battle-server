<?php

namespace App\Factories;

use Predis\Client;

class RedisClientStaticFactory
{
    public static function create(): Client
    {
        return new Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]);
    }
}
