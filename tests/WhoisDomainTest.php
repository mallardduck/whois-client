<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\Client;

/**
*  Corresponding Class to test the Locator class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisDomainTest extends BaseTest
{
    /**
     * The main Whois Client
     * @var Client
     */
    protected $client;

    /**
     * The PHPUnit Setup method to build our client.
     */
    protected function setUp(): void
    {
        $this->client = new Client();
    }

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $this->assertIsObject($this->client);
    }

    /**
     * A very basic test to check that the return result is a string.
     * @param string $domain Test domains!
     * @dataProvider validDomainsProvider
     */
    public function testValidDomains($domain)
    {
        $response = $this->client->lookup($domain);
        $this->assertGreaterThanOrEqual(1, strlen($response));
    }

    /**
     * The data provider for valid domains test.
     */
    public function validDomainsProvider()
    {
        return [
            ['danpock.google'],
            ['domain.wedding'],
            ['sub.domain.club'],
            ['www.sub.domain.me'],
            ['domain.CO.uk'],
            ['www.domain.co.uk'],
            ['sub.www.domain.co.uk'],
            ['президент.рф'],
            ['www.ПРЕЗИДЕНТ.рф'],
            ['domain.1com'],
        ];
    }
}
