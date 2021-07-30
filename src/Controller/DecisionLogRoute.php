<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RichId\CookiesRegulationBundle\Entity\DecisionLog;
use RichId\CookiesRegulationBundle\Factory\CookieDecisionMetadataFactory;
use RichId\CookiesRegulationBundle\Factory\CookieDecisionsFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DecisionLogRoute extends AbstractController
{
    /** @var CookieDecisionMetadataFactory */
    protected $cookieDecisionMetadataFactory;

    /** @var CookieDecisionsFactory */
    protected $cookieDecisionsFactory;

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(
        CookieDecisionMetadataFactory $cookieDecisionMetadataFactory,
        CookieDecisionsFactory $cookieDecisionsFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->cookieDecisionMetadataFactory = $cookieDecisionMetadataFactory;
        $this->cookieDecisionsFactory = $cookieDecisionsFactory;
        $this->entityManager = $entityManager;
    }

    public function __invoke(): Response
    {
        $metadata = ($this->cookieDecisionMetadataFactory)();
        $decisions = ($this->cookieDecisionsFactory)();

        if ($metadata === null || $decisions === null) {
            throw new BadRequestHttpException('Fail to parse the data.');
        }

        foreach ($decisions as $decision) {
            $log = new DecisionLog();
            $log->setUuid($metadata->uuid);
            $log->setDate($metadata->date);
            $log->setServiceName($decision->serviceName);
            $log->setIsEnabled($decision->isEnabled);
            $this->entityManager->persist($log);
        }

        $this->entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
