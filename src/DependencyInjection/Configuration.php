<?php declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

class Configuration extends AbstractConfiguration
{
    public const CONFIG_NODE = 'rich_id_cookies_regulation';

    protected function buildConfig(NodeBuilder $nodeBuilder): void
    {
        $nodeBuilder->scalarNode('enable_auto_import')->defaultTrue();
        $nodeBuilder->scalarNode('website')->isRequired();
        $nodeBuilder->scalarNode('locale')->defaultValue('en')->isRequired();

        $privacyPolicyNode = $nodeBuilder->arrayNode('privacy_policy')->addDefaultsIfNotSet()->children();
        $privacyPolicyNode->scalarNode('url')->isRequired();
        $privacyPolicyNode->scalarNode('label')->defaultValue('Privacy Policy');
        $privacyPolicyNode->booleanNode('open_in_new_window')->defaultTrue();

        $modalNode = $nodeBuilder->arrayNode('modal')->children();
        $modalNode->scalarNode('header')->isRequired();
        $modalNode->integerNode('related_companies_count')->isRequired();
        $modalNode->scalarNode('related_companies_privacy_policy_url')->isRequired();

        $servicesNode = $nodeBuilder->arrayNode('services')->normalizeKeys(true)->arrayPrototype()->children();
        $servicesNode->scalarNode('name')->isRequired();
        $servicesNode->scalarNode('description')->isRequired();
        $servicesNode->scalarNode('conservation')->isRequired();
        $servicesNode->scalarNode('initialization_callback')->defaultNull();

        $predefinedServiceNode = $servicesNode->arrayNode('predefined')->children();
        $predefinedServiceNode->scalarNode('name')->isRequired();
        $predefinedServiceNode->arrayNode('options')->ignoreExtraKeys(false);
    }
}
