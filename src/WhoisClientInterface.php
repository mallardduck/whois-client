<?php

namespace MallardDuck\Whois;

/**
 * WhoisClientInterface defines an interface for basic Whois lookup in PHP.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 1.0.0
 */
interface WhoisClientInterface
{
    /**
     * Perform a Whois lookup.
     *
     * Performs a Whois request using the given input for lookup and the Whois
     * server values.
     *
     * This method must not keep any sockets open. It's simple an single request method.
     *
     * @param  string $lookupValue  The domain or IP being looked up.
     * @param  string $whoisServer  The whois server being queried.
     *
     * @return string               The raw text results of the query response.
     */
    public function makeRequest(string $lookupValue, string $whoisServer): string;

    /**
     * Creates the connection to the whois server.
     *
     * The $whoisServer argument must always be a string and the connection to
     * the server should be created as a class property left up to the Implementing
     * Library. The property will be used throughout the methods.
     *
     * @param string $whoisServer The whois server being queried.
     *
     * @throws Exceptions\SocketClientException
     */
    public function createConnection(string $whoisServer);

    /**
     * Writes a whois request to the active socket connection.
     *
     * @param string $lookupValue The value to lookup for the whois request.
     *
     * @return int|bool Either an int of the return code, or false on some errors.
     */
    public function writeRequest(string $lookupValue);

    /**
     * A method for retrieving a raw Whois response.
     *
     * This method must only retrieve the response from the active socket and
     * nothing more. The socket must not be closed for any subsequent requests.
     *
     * @return string   The raw results of the query response.
     */
    public function getResponse(): string;

    /**
     * A method for retrieving a raw Whois response.
     *
     * This method must retrieve the response from the active socket and then
     * close the socket. If the connection is not properly closed servers could
     * drop/ignore rapid subsequent requests.
     *
     * @return string   The raw results of the query response.
     */
    public function getResponseAndClose(): string;
}
