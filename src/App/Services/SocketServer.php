<?php

namespace App\Services;

use App\Entity\BattleAction;
use App\Factories\RedisClientStaticFactory;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use App\Repository\BattleActionRepository;

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

        if ($this->validateParams($params)) {

            $client = RedisClientStaticFactory::create();
            $battleActionRepo = new BattleActionRepository($client);
            $battleAction = $this->createBattleActionFromParams($params);
            $battleAction->setId($battleActionRepo->nextId($battleAction));
            $battleActionRepo->persist($battleAction);

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

    private function createBattleActionFromParams(array $params): BattleAction
    {
        $battleToken = $userToken = '';
        $battleHeroId = $skillId = $x = $y = 999;
        extract($params);

        return new BattleAction(
            $battleToken, $userToken, $battleHeroId, $skillId, $x, $y
        );
    }

    private function validateParams(array $params): bool
    {
        return
            isset($params['battleToken']) &&
            isset($params['userToken']) &&
            isset($params['battleHeroId']) &&
            isset($params['skillId']) &&
            isset($params['x']) &&
            isset($params['y']) &&
            TokenValidator::validate($params['battleToken']) &&
            TokenValidator::validate($params['userToken']);
    }
}
