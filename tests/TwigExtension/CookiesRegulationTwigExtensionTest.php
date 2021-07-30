<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Tests\TwigExtension;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\CookiesRegulationBundle\TwigExtension\CookiesRegulationTwigExtension;
use Twig\TwigFunction;

/**
 * @covers \RichId\CookiesRegulationBundle\TwigExtension\CookiesRegulationTwigExtension
 */
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
                    'url'                => 'http://privacy_policy',
                    'label'              => 'Privacy Policy',
                    'open_in_new_window' => true,
                ],
                'modal' => [
                    'header'                               => 'Modal header',
                    'related_companies_count'              => 2,
                    'related_companies_privacy_policy_url' => 'http://related_companies_privacy_policy',
                ],
                'services' => [
                    'google_tag_manager' => [
                        'name'                    => 'Google Tag Manager',
                        'description'             => 'Tag management system',
                        'conservation'            => '6 months.',
                        'initialization_callback' => null,
                        'predefined'              => [
                            'name'    => 'googleTagManager',
                            'options' => ['id' => 'GTM-TEST'],
                        ],
                    ],
                ],
            ],
            $config
        );
    }
}
