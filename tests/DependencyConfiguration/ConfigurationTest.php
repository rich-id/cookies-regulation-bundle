<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Tests\DependencyConfiguration;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\CookiesRegulationBundle\DependencyInjection\Configuration;
use RichId\CookiesRegulationBundle\RichIdCookiesRegulationBundle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @covers \RichId\CookiesRegulationBundle\RichIdCookiesRegulationBundle
 * @covers \RichId\CookiesRegulationBundle\DependencyInjection\Configuration
 */
class ConfigurationTest extends TestCase
{
    public function testInstantiateBundle(): void
    {
        $bundle = new RichIdCookiesRegulationBundle();

        self::assertInstanceOf(RichIdCookiesRegulationBundle::class, $bundle);
    }

    #[TestConfig('container')]
    public function testInstantiationContainer(): void
    {
        /** @var ParameterBagInterface $parameterBag */
        $parameterBag = $this->getService(ParameterBagInterface::class);
        $config = $parameterBag->get(Configuration::CONFIG_NODE);

        self::assertEquals(
            [
                'enable_auto_import' => true,
                'website'            => 'Test Website',
                'locale'             => 'fr',
                'privacy_policy'     => [
                    'url' => [
                        'absolute' => 'http://privacy_policy',
                    ],
                    'label'              => 'Privacy Policy',
                    'open_in_new_window' => true,
                ],
                'modal' => [
                    'header'                               => 'Modal header',
                    'headerWithoutConsent'                 => 'Modal headerWithoutConsent',
                    'related_companies_privacy_policy_url' => [
                        'absolute' => 'http://related_companies_privacy_policy',
                    ],
                ],
                'services' => [
                    'google_tag_manager' => [
                        'enable'                  => true,
                        'name'                    => 'Google Tag Manager',
                        'description'             => 'Tag management system',
                        'mandatory'               => true,
                        'conservation'            => '6 months',
                        'related_companies_count' => 1,
                        'cookies_identifiers'     => [],
                        'enabledByDefault'        => false,
                        'predefined'              => [
                            'name'    => 'googleTagManager',
                            'options' => ['id' => 'GTM-TEST'],
                        ],
                    ],
                    'another_service' => [
                        'enable'                  => false,
                        'name'                    => 'Another Service',
                        'description'             => 'Description of the another service',
                        'mandatory'               => false,
                        'conservation'            => '1 year',
                        'cookies_identifiers'     => [],
                        'related_companies_count' => 2,
                        'initialization_callback' => 'init_callback()',
                        'enabledByDefault'        => false,
                    ],
                ],
            ],
            $config
        );
    }
}
