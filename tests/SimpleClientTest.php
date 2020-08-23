<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\SimpleClient;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class SimpleClientTest extends BaseTest
{
    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new SimpleClient();
        $this->assertIsObject($var);
        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testBasicRequestConcepts()
    {
        $var = new SimpleClient();
        $this->assertIsObject($var);
        $var->createConnection("whois.nic.me");
        $status = $var->writeRequest("danpock.me");
        $response = $var->getResponseAndClose();
        $containedResponse = strstr($response, "\r\n", true);
        $this->assertSame("Domain Name: DANPOCK.ME", $containedResponse);

        unset($response, $status, $var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testConnectionDisconnects()
    {
        $reader = function & ($object, $property) {
            $value = & \Closure::bind(function & () use ($property) {
                return $this->$property;
            }, $object, $object)->__invoke();

            return $value;
        };


        $var = new SimpleClient();
        $this->assertIsObject($var);
        $var->createConnection("whois.nic.me");

        // Grab a reference to the client and socket
        $socketClient = & $reader($var, 'connection');
        $socket = & $reader($socketClient, 'socket');

        // Check our references once...
        $this->assertIsObject($socketClient);
        $this->assertIsResource($socket);

        // Make the request and grab the data...
        $status = $var->writeRequest("danpock.me");
        $response = $var->getResponseAndClose();

        // Check our refernces again...
        $this->assertNull($socket);
        $this->assertIsObject($socketClient);

        // Check our response data...
        $containedResponse = strstr($response, "\r\n", true);
        $this->assertSame("Domain Name: DANPOCK.ME", $containedResponse);

        unset($response, $status, $client);
    }
}
