<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\Client;
use MallardDuck\Whois\Exceptions\MissingArgException;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class ExceptionContentTest extends BaseTest
{

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new Client();
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * Test function comment stub.
     * @param string $input         Test input!
     * @param string $whoisServer   Test whois!
     * @param string $messageRegex  Test exception regex!
     * @dataProvider validateLookupArgsProvider
     */
    public function testValidateLookupArgs($input, $whoisServer, $messageRegex)
    {
        $client = new Client();
        $this->assertTrue(method_exists($client, 'validateLookupArgs'));
        $foo = self::getMethod($client, 'validateLookupArgs');
        $this->expectException(MissingArgException::class);
        $this->expectExceptionMessageRegExp($messageRegex);
        $foo->invokeArgs($client, [$input, $whoisServer]);
        unset($client, $foo, $wat);
    }

    /**
     * Test function comment stub.
     */
    public function validateLookupArgsProvider()
    {
        return [
                [
                    '',
                    'whois.verisign-grs.com',
                    "/(.*)No primary input provided(.*)/i",
                ],
                [
                    'google.com',
                    '',
                    "/(.*)No whois server provided(.*)/i",
                ],
                [
                    '',
                    '',
                    "/(.*)No input provided(.*)/i",
                ],
            ];
    }
}
