<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Factory;

use RichId\CookiesRegulationBundle\Model\CookieDecisionMetadata;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CookieDecisionMetadataFactory
{
    /** @var RequestStack */
    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function __invoke(): ?CookieDecisionMetadata
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();
        /** @var array<string, string> $metadata */
        $metadata = $request->request->get('metadata');

        if (!\is_array($metadata)) {
            return null;
        }

        $uuid = $metadata['uuid'] ?? null;
        $date = new \DateTime($metadata['date'] ?? '');

        if (!\is_string($uuid) || empty($uuid) || !$date instanceof \DateTime) {
            return null;
        }

        $model = new CookieDecisionMetadata();
        $model->uuid = $uuid;
        $model->date = $date;

        return $model;
    }
}
