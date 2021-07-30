<?php declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use RichId\CookiesRegulationBundle\Entity\DecisionLog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class DecisionLogRoute extends AbstractController
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var RequestStack */
    protected $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function __invoke(): Response
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var array<int, string|boolean> $preferences */
        $preferences = $request->request->get('preferences');
        $metadata = $request->request->get('metadata');
        $uuid = $metadata['uuid'];
        $date = \DateTime::createFromFormat('d/m/Y, H:i:s', $metadata['date']);

        foreach ($preferences as $data) {
            $log = new DecisionLog();
            $log->setUuid($uuid);
            $log->setDate($date);
            $log->setServiceName($data[0]);
            $log->setIsEnabled((bool) $data[1]);
            $this->entityManager->persist($log);
        }

        $this->entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
