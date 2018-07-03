<?php

namespace App\Repository;

use App\Definitions\Redis;
use App\Entity\BattleAction;
use App\Services\TokenValidator;
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
        if (TokenValidator::validate($action->getBattleToken()) && TokenValidator::validate($action->getUserToken())) {
            $key = $this->key($action->getBattleToken());
            $this->client->rpush($key, [$action->toJson()]);
            $this->client->expire($key, Redis::TTL);
        }
    }

    private function key(string $token): string
    {
        return static::NAMESPACE . $token;
    }
}
