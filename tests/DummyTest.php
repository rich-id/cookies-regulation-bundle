<?php declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\tests;

use RichCongress\TestTools\TestCase\TestCase;
use RichId\CookiesRegulationBundle\RichIdCookiesRegulationBundle;

/**
 * Class DummyTest
 *
 * @package   RichId\CookiesRegulationBundle\Tests
 * @author    Nicolas Guilloux <nguilloux@rich-id.com>
 * @copyright 2014 - 2020 RichId (https://www.rich-id.com)
 *
 * @covers \RichId\CookiesRegulationBundle\RichIdCookiesRegulationBundle
 */
class DummyTest extends TestCase
{
    public function testInstanciateBundle(): void
    {
        $bundle = new RichIdCookiesRegulationBundle();

        self::assertInstanceOf(RichIdCookiesRegulationBundle::class, $bundle);
    }
}
