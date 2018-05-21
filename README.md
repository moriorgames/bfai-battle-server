Battle Server
=============

The battle server project is in charge of connecting multiplayers when a battle is being played.

1. Battle server has to store battle data
2. Get and Send data to connected clients
4. Be aware that the clients are still connected to the battle


Installation
============

Requires php 7.1

```
$ git clone https://github.com/moriorgames/bfai-battle-server.git
$ cd bfai-battle-server
$ php phars/composer.phar install
# Runs the websocket in port 5100
$ php socket
```

Is preferable to get the application up using docker, see instructions in the header of Dockerfile
