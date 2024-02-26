<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Factory;

use RichId\CookiesRegulationBundle\Model\CookieDecision;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class CookieDecisionsFactory
{
    /** @var RequestStack */
    protected $requestStack;

    /** @var DecoderInterface */
    protected $decoder;

    public function __construct(RequestStack $requestStack, DecoderInterface $decoder)
    {
        $this->requestStack = $requestStack;
        $this->decoder = $decoder;
    }

    /** @return CookieDecision[] */
    public function __invoke(): ?array
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();
        /** @var array<int, array<int, string|bool>> $decisions */
        $decisions = $this->decoder->decode($request->getContent(), 'json')['preferences'] ?? null;
        $models = [];

        if (!\is_array($decisions)) {
            return null;
        }

        foreach ($decisions as $decision) {
            [$serviceName, $isEnabled] = $decision;
            $isEnabled = (bool) $isEnabled;

            if (!\is_string($serviceName) || empty($serviceName) || !\is_bool($isEnabled)) {
                return null;
            }

            $model = new CookieDecision();
            $model->serviceName = $serviceName;
            $model->isEnabled = $isEnabled;
            $models[] = $model;
        }

        return $models;
    }
}
