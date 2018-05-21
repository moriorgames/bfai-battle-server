<?php

namespace Entity;

class BattleAction
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $battleToken;

    /**
     * @var string
     */
    private $userToken;

    /**
     * @var int
     */
    private $battleHeroId;

    /**
     * @var int
     */
    private $skillId;

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

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

    public function setBattleToken(string $battleToken)
    {
        $this->battleToken = $battleToken;
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }

    public function setUserToken(string $userToken)
    {
        $this->userToken = $userToken;
    }

    public function getBattleHeroId(): int
    {
        return $this->battleHeroId;
    }

    public function setBattleHeroId(int $battleHeroId)
    {
        $this->battleHeroId = $battleHeroId;
    }

    public function getSkillId(): int
    {
        return $this->skillId;
    }

    public function setSkillId(int $skillId)
    {
        $this->skillId = $skillId;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x)
    {
        $this->x = $x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y)
    {
        $this->y = $y;
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
