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
        $client = new SimpleClient;
        $this->assertTrue(is_object($client));
        unset($client);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testBasicRequestConcepts()
    {
        $client = new SimpleClient;
        $this->assertTrue(is_object($client));
        $client->createConnection("whois.nic.me");
        $status = $client->writeRequest("danpock.me");
        $response = $client->getResponseAndClose();
        $this->assertTrue(strstr($response, "\r\n", true) === "Domain Name: DANPOCK.ME");

        unset($response, $status, $client);
    }
}
