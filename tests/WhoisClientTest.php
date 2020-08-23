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
class WhoisClientTest extends BaseTest
{
    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new Client();
        $this->assertIsObject($var);
        unset($var);
    }

    /**
     * Make sure we throw an exception if no args are given.
     */
    public function testEmptyLookupThrowsException()
    {
        $this->expectException(MissingArgException::class);
        $var = new Client();
        $this->assertIsObject($var);
        $var->lookup();
        unset($var);
    }

    /**
     * Make sure we throw an exception if no domain given.
     */
    public function testEmptyPrimaryLookupThrowsException()
    {
        $this->expectException(MissingArgException::class);
        $var = new Client();
        $this->assertTrue(is_object($var));
        $var->lookup('', 'something'); // doesn't need to be real value - testing arg validation
        unset($var);
    }

    /**
     * Make sure we throw an exception if no whois server given.
     */
    public function testEmptyServerLookupThrowsException()
    {
        $this->expectException(MissingArgException::class);
        $var = new Client();
        $this->assertTrue(is_object($var));
        $var->lookup('something', ''); // doesn't need to be real value - testing arg validation
        unset($var);
    }

    /**
     * Do a basic lookup for google.com.
     */
    public function testClientLookupGoogle()
    {
        $var = new Client();
        $results = $var->lookup('google.com', 'whois.verisign-grs.com');
        $this->assertNotEmpty($results);
        $this->assertIsString($results);
        $this->assertGreaterThanOrEqual(1, count(explode("\r\n", $results)));
        unset($var, $results);
    }

    /**
     * Test function comment stub.
     * @param string $domain Test domains!
     * @param string $parsed Parsed domains!
     * @dataProvider validDomainsProvider
     */
    public function testValidParsingInputs($domain, $parsed)
    {
        $client = new Client();
        $this->assertTrue(method_exists($client, 'parseWhoisInput'));
        $foo = self::getMethod($client, 'parseWhoisInput');
        $wat = $foo->invokeArgs($client, [$domain]);
        $this->assertEquals($parsed, $wat);
        unset($client, $foo, $wat);
    }

    /**
     * Test function comment stub.
     */
    public function validDomainsProvider()
    {
        return [
                ['domain', 'domain'],
                ['danpock.me.', 'danpock.me.'],
                ['www.sub.domain.xyz', 'www.sub.domain.xyz'],
                ['i❤.ws', 'xn--i-7iq.ws'],
                ['🍕💩.ws', 'xn--vi8hiv.ws'],
                ['президент.рф', 'xn--d1abbgf6aiiy.xn--p1ai'],
                ['xn--e1afmkfd.xn--80akhbyknj4f', 'xn--e1afmkfd.xn--80akhbyknj4f'],
            ];
    }
}
