<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Factory;

use RichId\CookiesRegulationBundle\Model\CookieDecisionMetadata;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class CookieDecisionMetadataFactory
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

    public function __invoke(): ?CookieDecisionMetadata
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();
        /** @var array<string, string> $metadata */
        $metadata = $this->decoder->decode($request->getContent(), 'json')['metadata'] ?? null;

        if (!\is_array($metadata)) {
            return null;
        }

        $uuid = $metadata['uuid'] ?? null;

        try {
            $date = new \DateTime($metadata['date'] ?? '');
        } catch (\Throwable $e) {
            return null;
        }

        if (!\is_string($uuid) || empty($uuid) || !$date instanceof \DateTime) {
            return null;
        }

        $model = new CookieDecisionMetadata();
        $model->uuid = $uuid;
        $model->date = $date;

        return $model;
    }
}
