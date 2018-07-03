<?php

namespace App\Entity;

class BattleAction
{

    private $id;

    private $battleToken;

    private $userToken;

    private $battleHeroId;

    private $skillId;

    private $x;

    private $y;

    public function __construct(string $battleToken, string $userToken, int $battleHeroId, int $skillId, int $x, int $y)
    {
        $this->battleToken = $battleToken;
        $this->userToken = $userToken;
        $this->battleHeroId = $battleHeroId;
        $this->skillId = $skillId;
        $this->x = $x;
        $this->y = $y;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getBattleToken(): string
    {
        return $this->battleToken;
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }

    public function getBattleHeroId(): int
    {
        return $this->battleHeroId;
    }

    public function getSkillId(): int
    {
        return $this->skillId;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return [
            'id'           => $this->id,
            'battleToken'  => $this->battleToken,
            'userToken'    => $this->userToken,
            'battleHeroId' => $this->battleHeroId,
            'skillId'      => $this->skillId,
            'x'            => $this->x,
            'y'            => $this->y,
        ];
    }
}
