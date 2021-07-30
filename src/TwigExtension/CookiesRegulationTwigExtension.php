<?php declare(strict_types=1);

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

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCookiesRegulationConfig', [$this, 'getCookiesRegulationConfig']),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getCookiesRegulationConfig(): array
    {
        return $this->parameterBag->get(Configuration::CONFIG_NODE);
    }
}
