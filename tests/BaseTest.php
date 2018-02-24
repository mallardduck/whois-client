<?php
namespace MallardDuck\Whois\Test;

use PHPUnit\Framework\TestCase;
use League\Uri\Components\Host;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
abstract class BaseTest extends TestCase
{
    public function getUriException()
    {
        $host = new Host();
        $isNewLib = (method_exists($host, 'getRegistrableDomain')) ? true : false;
        if ($isNewLib) {
            return \League\Uri\Components\Exception::class;
        }
        return \Exception::class;
    }

    /**
     * [getMethod description]
     * @param  mixed  $class [description]
     * @param  string $name  [description]
     * @return mixed         [description]
     */
    protected static function getMethod($class, $name)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}