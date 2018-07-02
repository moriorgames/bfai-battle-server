<?php

namespace App\Services;

use App\Entity\BattleAction;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Class SocketServer
 * @package AppBundle\Services
 */
class SocketServer implements MessageComponentInterface
{
    /**
     * @var \SplObjectStorage
     */
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    /**
     * @param ConnectionInterface $from
     * @param string              $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo sprintf("\n-- Message %s \n", $msg);
        $params = json_decode($msg, true);

        if ($this->validateActionParams($params)) {

            $battleToken = $userToken = '';
            $battleHeroId = $skillId = $x = $y = 999;
            extract($params);

            $battleAction = new BattleAction;
            $battleAction->setId(123);
            $battleAction->setBattleToken($battleToken);
            $battleAction->setUserToken($userToken);
            $battleAction->setBattleHeroId($battleHeroId);
            $battleAction->setSkillId($skillId);
            $battleAction->setX($x);
            $battleAction->setY($y);

            foreach ($this->clients as $client) {
                $client->send(json_encode($battleAction->toArray()));
            }
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function validateActionParams(array $params): bool
    {
        return
            isset($params['battleToken']) &&
            isset($params['userToken']) &&
            isset($params['battleHeroId']) &&
            isset($params['skillId']) &&
            isset($params['x']) &&
            isset($params['y']);
    }
}
