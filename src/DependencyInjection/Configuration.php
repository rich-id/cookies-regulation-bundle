<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
        $privacyPolicyNode->scalarNode('route');
        $privacyPolicyNode->scalarNode('label')->defaultValue('Privacy Policy');
        $privacyPolicyNode->booleanNode('open_in_new_window')->defaultTrue();

        $privacyPolicyUrlNode = $privacyPolicyNode->arrayNode('url');
        self::addUrlOrRouteConfig($privacyPolicyUrlNode);

        $modalNode = $nodeBuilder->arrayNode('modal')->children();
        $modalNode->scalarNode('header')->isRequired();
        $modalNode->integerNode('related_companies_count')->isRequired();

        $relatedCompaniesPrivacyPolicyUrlNode = $modalNode->arrayNode('related_companies_privacy_policy_url');
        self::addUrlOrRouteConfig($relatedCompaniesPrivacyPolicyUrlNode);

        $servicesNode = $nodeBuilder->arrayNode('services')->normalizeKeys(true)->arrayPrototype()->children();
        $servicesNode->booleanNode('enable')->defaultTrue();
        $servicesNode->scalarNode('name')->isRequired();
        $servicesNode->scalarNode('description');
        $servicesNode->booleanNode('mandatory')->defaultFalse();
        $servicesNode->scalarNode('conservation')->isRequired();
        $servicesNode->arrayNode('cookies_identifiers')->scalarPrototype();
        $servicesNode->scalarNode('initialization_callback');

        $predefinedServiceNode = $servicesNode->arrayNode('predefined')->children();
        $predefinedServiceNode->scalarNode('name')->isRequired();
        $predefinedServiceNode->arrayNode('options')->ignoreExtraKeys(false);
    }

    private static function addUrlOrRouteConfig(ArrayNodeDefinition $node): void
    {
        $node->beforeNormalization()
            ->ifString()
            ->then(static function ($v) {
                return ['absolute' => $v];
            });

        $children = $node->children();
        $children->scalarNode('absolute')->end();
        $children->scalarNode('route')->end();
        $children->arrayNode('parameters')->ignoreExtraKeys(false);
    }
}
