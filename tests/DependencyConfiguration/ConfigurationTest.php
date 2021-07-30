<?php declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Tests\DependencyConfiguration;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
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
        $parameterBag = $this->getService(ParameterBagInterface::class);
        $config = $parameterBag->get(Configuration::CONFIG_NODE);

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
                'modal'              => [
                    'header'                               => 'Modal header',
                    'related_companies_count'              => 2,
                    'related_companies_privacy_policy_url' => 'http://related_companies_privacy_policy',
                ],
                'services'           => [
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
