<?php
namespace MallardDuck\Whois;

use TrueBV\Punycode;
use MallardDuck\Whois\Exceptions\MissingArgException;

/**
 * The Whois Client Class.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 0.4.0
 */
class Client extends AbstractWhoisClient
{
    /**
     * The Unicode for IDNA.
     * @var \TrueBV\Punycode
     */
    protected $punycode;

    /**
     * The parsed input after validating and encoding.
     * @var string
     */
    public $parsedInput;

    /**
     * Construct the Whois Client Class.
     */
    public function __construct()
    {
        $this->punycode = new Punycode();
    }
    /**
     * Performs a Whois look up on the domain provided.
     * @param  string $input        The domain or ip being looked up via whois.
     * @param  string $whoisServer  The whois server to preform the lookup on.
     *
     * @return string         The output of the Whois look up.
     */
    public function lookup(string $input = "", string $whoisServer = "") : string
    {
        $this->validateLookupArgs($input, $whoisServer);
        $this->parseWhoisInput($input);

        return $this->makeRequest($this->parsedInput, $whoisServer);
    }

    /**
     * Validates the input for the `lookup` method.
     * @param  string $input        A string that should represent a domain name or IP.
     * @param  string $whoisServer  A string that represents a domain or IP of a whois server.
     */
    private function validateLookupArgs(string $input = "", string $whoisServer = "") : void
    {
        if (empty($input) || empty($whoisServer)) {
            $primaryMissing = $input ? false : true;
            $serverMissing = $whoisServer ? false : true;
            if ($primaryMissing && $serverMissing) {
                throw new MissingArgException(
                    "No input provided. Must provide both primary input (domain or IP) and whois server to this method."
                );
            } elseif ($primaryMissing) {
                throw new MissingArgException(
                    "No primary input provided. Cannot lookup empty domain, or IP string."
                );
            } elseif ($serverMissing) {
                throw new MissingArgException(
                    "No whois server provided. Must provide IP or domain for whois server with this method."
                );
            }
        }
    }

    /**
     * Takes the user provided input and parses then encodes the string.
     * @param  string $input The user provided input.
     *
     * @return string Returns the parsed whois input.
     */
    public function parseWhoisInput(string $input) : string
    {
        // Check domain encoding
        $encoding = mb_detect_encoding($input);

        // Punycode the domain if it's Unicode
        if ("UTF-8" === $encoding) {
            $input = $this->punycode->encode($input);
        }
        $this->parsedInput = $input;

        return $input;
    }
}
