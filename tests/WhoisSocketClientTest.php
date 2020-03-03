<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\SocketClient;
use MallardDuck\Whois\Exceptions\SocketClientException;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisSocketClientTest extends BaseTest
{

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new SocketClient("tcp://whois.nic.me:43", 10);
        $this->assertIsObject($var);
        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testIntentionalSyntaxError()
    {
        $var = new SocketClient("ztcpz://127.0.0.1:43", 10);
        $this->assertIsObject($var);
        $this->expectException(SocketClientException::class);
        $var->connect();
        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testSettingTimeoutValue()
    {
        $reader = function & ($object, $property) {
            $value = & \Closure::bind(function & () use ($property) {
                return $this->$property;
            }, $object, $object)->__invoke();

            return $value;
        };

        $var = new SocketClient("tcp://whois.nic.me:43");
        $this->assertIsObject($var);
        $timeout = $reader($var, 'timeout');
        $this->assertSame($timeout, 30);

        $var = new SocketClient("tcp://whois.nic.me:43", 10);
        $timeout = $reader($var, 'timeout');
        $this->assertSame($timeout, 10);

        unset($timeout, $var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testBasicRequestConcepts()
    {
        $var = new SocketClient("tcp://whois.nic.me:43", 10);
        $this->assertIsObject($var);
        $var->connect();
        $status = $var->writeString("danpock.me\r\n");
        $response = $var->readAll();
        $var->disconnect();
        $containedResponse = strstr($response, "\r\n", true);
        $this->assertSame("Domain Name: DANPOCK.ME", $containedResponse);

        unset($response, $status, $var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testIsConnected()
    {
        $var = new SocketClient("tcp://whois.nic.me:43", 10);
        $this->assertIsObject($var);
        $this->assertFalse($var->isConnected());
        $var->connect();
        $this->assertTrue($var->isConnected());
        $var->disconnect();
        $this->assertFalse($var->isConnected());

        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testWriteWithoutValidConnection()
    {
        $var = new SocketClient("tcp://whois.nic.me:43", 10);
        $this->assertIsObject($var);
        $this->expectException(SocketClientException::class);
        $status = $var->writeString("danpock.me\r\n");

        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testReadAllWithoutValidConnection()
    {
        $var = new SocketClient("tcp://whois.nic.me:43", 10);
        $this->assertIsObject($var);
        $var->connect();
        $status = $var->writeString("danpock.me\r\n");
        $var->disconnect();
        $this->expectException(SocketClientException::class);
        $response = $var->readAll();

        unset($var);
    }
}
