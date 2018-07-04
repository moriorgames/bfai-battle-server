<?php

namespace App\Repository;

use App\Definitions\Redis;
use App\Entity\BattleAction;
use Predis\Client as RedisClient;

class BattleActionRepository
{
    const NAMESPACE = 'actions-';

    private $client;

    public function __construct(RedisClient $client)
    {
        $this->client = $client;
    }

    public function persist(BattleAction $action): void
    {
        $key = $this->key($action->getBattleToken());
        $this->client->rpush($key, [$action->toJson()]);
        $this->client->expire($key, Redis::TTL);
    }

    public function nextId(BattleAction $action): int
    {
        $key = $this->key($action->getBattleToken());

        return $this->client->llen($key);
    }

    private function key(string $token): string
    {
        return static::NAMESPACE . $token;
    }
}
