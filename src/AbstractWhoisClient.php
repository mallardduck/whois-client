<?php
namespace MallardDuck\Whois;

use Hoa\Socket\Client as SocketClient;
use MallardDuck\Whois\WhoisClientInterface;

/**
 * The Whois Client Class.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 0.4.0
 */
abstract class AbstractWhoisClient implements WhoisClientInterface
{

    /**
     * The port for creating the socket.
     * @var int
     */
    protected $port = 43;

    /**
     * The timeout duration used for WhoIs server lookups.
     * @var int
     */
    protected $timeout = 10;

    /**
     * The carriage return line feed character comobo.
     * @var string
     */
    protected $clrf = "\r\n";

    /**
     * The input domain provided by the user.
     * @var SocketClient|null
     */
    protected $connection;

    /**
     * Perform a Whois lookup.
     *
     * Performs a Whois request using the given input for lookup and the Whois
     * server values.
     *
     * @param  string $lookupValue  The domain or IP being looked up.
     * @param  string $whoisServer  The whois server being queried.
     *
     * @return string               The raw text results of the query response.
     */
    public function makeRequest(string $lookupValue, string $whoisServer) : string
    {
        $this->createConnection($whoisServer);
        $this->writeRequest($lookupValue);
        return $this->getResponseAndClose();
    }

    /**
     * Creates a socket connection to the whois server and activates it.
     *
     * @param string $whoisServer The whois server domain or IP being queried.
     */
    final public function createConnection(string $whoisServer) : void
    {
        // Form a TCP socket connection to the whois server.
        $this->connection = new SocketClient('tcp://'.$whoisServer.':'.$this->port, $this->timeout);
        $this->connection->connect();
    }

    /**
     * Writes a whois request to the active socket connection.
     *
     * @param string $lookupValue The cache item to save.
     *
     * @return int|bool Either an int of the return code, or false on some errors.
     */
    final public function writeRequest(string $lookupValue)
    {
        // Send the domain name requested for whois lookup.
        return $this->connection->writeString($lookupValue.$this->clrf);
    }

    /**
     * A method for retrieving a raw Whois response.
     *
     * This method must retrieve the reponse from the active socket and then
     * close the socket. If the connection is not properly closed servers could
     * drop/ignore rapid subsequent requests.
     *
     * @return string   The raw results of the query response.
     */
    final public function getResponseAndClose() : string
    {
        // Read the full output of the whois lookup.
        $response = $this->connection->readAll();
        // Disconnect the connections after use in order to prevent observed
        // network & performance issues. Not doing this caused mild trottling.
        $this->connection->disconnect();
        return $response;
    }

    // Fluent option methods
    /**
     * Fluent method to set the port for non-standard requests.
     *
     * @param  int    $port The port to use for the request.
     * @return self         The very same class.
     */
    final public function withPort(int $port) : self
    {
        $this->port = $port;
        return $this;
    }

    /**
     * Fluent method to set the timeout for the current request.
     *
     * @param  int    $timeout  The timeout duration in seconds.
     * @return self             The very same class.
     */
    final public function withTimeout(int $timeout) : self
    {
        $this->timeout = $timeout;
        return $this;
    }
}
