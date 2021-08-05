<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\TwigExtension;

use RichId\CookiesRegulationBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CookiesRegulationTwigExtension extends AbstractExtension
{
    /** @var ParameterBagInterface */
    protected $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /** @return TwigFunction[] */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCookiesRegulationConfig', [$this, 'getCookiesRegulationConfig']),
            new TwigFunction('getCookiesRegulationRelatedCompaniesCount', [$this, 'getCookiesRegulationRelatedCompaniesCount']),
        ];
    }

    /** @return array<string, mixed> */
    public function getCookiesRegulationConfig(): array
    {
        /** @var array<string, mixed> $config */
        $config = $this->parameterBag->get(Configuration::CONFIG_NODE);

        return $config;
    }

    public function getCookiesRegulationRelatedCompaniesCount(): int
    {
        $services = Configuration::get('services', $this->parameterBag);
        $counts = \array_map(
            static function (array $services): int {
                return $services['enable'] ? $services['related_companies_count'] : 0;
            },
            $services
        );

        return \array_sum($counts);
    }
}
