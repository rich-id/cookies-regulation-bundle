<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Tests\TwigExtension;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\CookiesRegulationBundle\TwigExtension\CookiesRegulationTwigExtension;
use Twig\TwigFunction;

/** @covers \RichId\CookiesRegulationBundle\TwigExtension\CookiesRegulationTwigExtension */
#[TestConfig('container')]
final class CookiesRegulationTwigExtensionTest extends TestCase
{
    public function testGetFunctions(): void
    {
        /** @var CookiesRegulationTwigExtension $extension */
        $extension = $this->getService(CookiesRegulationTwigExtension::class);

        self::assertContainsOnlyInstancesOf(TwigFunction::class, $extension->getFunctions());
    }

    public function testGetConfig(): void
    {
        /** @var CookiesRegulationTwigExtension $extension */
        $extension = $this->getService(CookiesRegulationTwigExtension::class);
        $config = $extension->getCookiesRegulationConfig();

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
                        'related_companies_count' => 2,
                        'cookies_identifiers'     => [],
                        'initialization_callback' => 'init_callback()',
                        'enabledByDefault'        => false,
                    ],
                ],
            ],
            $config
        );
    }

    public function testGetRelatedCompaniesCount(): void
    {
        /** @var CookiesRegulationTwigExtension $extension */
        $extension = $this->getService(CookiesRegulationTwigExtension::class);
        $result = $extension->getCookiesRegulationRelatedCompaniesCount();

        self::assertSame(1, $result);
    }
}
