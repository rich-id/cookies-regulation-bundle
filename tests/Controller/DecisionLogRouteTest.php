<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Tests\Controller;

use Doctrine\Persistence\ObjectRepository;
use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\ControllerTestCase;
use RichId\CookiesRegulationBundle\Entity\DecisionLog;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \RichId\CookiesRegulationBundle\Controller\DecisionLogRoute
 * @covers \RichId\CookiesRegulationBundle\Entity\DecisionLog
 * @covers \RichId\CookiesRegulationBundle\Factory\CookieDecisionMetadataFactory
 * @covers \RichId\CookiesRegulationBundle\Factory\CookieDecisionsFactory
 */
#[TestConfig('container')]
final class DecisionLogRouteTest extends ControllerTestCase
{
    public function testDecisionLog(): void
    {
        $response = $this->getClient()->post('/rest/cookies-regulation/log', [], [
            'preferences' => [
                ['google_tag_manager', true],
                ['another_cookie', false],
            ],
            'metadata' => [
                'uuid' => '13336e1c-1c5c-4d24-8229-6eabb98f90bd',
                'date' => '2020-11-03 17:55:47',
            ],
        ]);

        self::assertStatusCode(Response::HTTP_NO_CONTENT, $response);

        /** @var ObjectRepository<DecisionLog> $repository */
        $repository = $this->getRepository(DecisionLog::class);
        $logs = $repository->findAll();
        self::assertCount(2, $logs);

        self::assertNotNull($logs[0]->getId());
        self::assertSame('google_tag_manager', $logs[0]->getServiceName());
        self::assertTrue($logs[0]->isEnabled());
        self::assertSame('13336e1c-1c5c-4d24-8229-6eabb98f90bd', $logs[0]->getUuid());
        self::assertSame('2020-11-03 17:55:47', $logs[0]->getDate()->format('Y-m-d H:i:s'));

        self::assertNotNull($logs[0]->getId());
        self::assertSame('another_cookie', $logs[1]->getServiceName());
        self::assertFalse($logs[1]->isEnabled());
        self::assertSame('13336e1c-1c5c-4d24-8229-6eabb98f90bd', $logs[1]->getUuid());
        self::assertSame('2020-11-03 17:55:47', $logs[1]->getDate()->format('Y-m-d H:i:s'));
    }

    public function testDecisionLogPreferencesNotArray(): void
    {
        $response = $this->getClient()->post('/rest/cookies-regulation/log', [], [
            'preferences' => 'BadData',
            'metadata'    => [
                'uuid' => '13336e1c-1c5c-4d24-8229-6eabb98f90bd',
                'date' => '2020-11-03 17:55:47',
            ],
        ]);

        self::assertStatusCode(Response::HTTP_BAD_REQUEST, $response);
    }

    public function testDecisionLogPreferencesWithBadDataInside(): void
    {
        $response = $this->getClient()->post('/rest/cookies-regulation/log', [], [
            'preferences' => [
                ['', true],
            ],
            'metadata' => [
                'uuid' => '13336e1c-1c5c-4d24-8229-6eabb98f90bd',
                'date' => '2020-11-03 17:55:47',
            ],
        ]);

        self::assertStatusCode(Response::HTTP_BAD_REQUEST, $response);
    }

    public function testDecisionLogMetadataNotAnArray(): void
    {
        $response = $this->getClient()->post('/rest/cookies-regulation/log', [], [
            'preferences' => [
                ['google_tag_manager', true],
                ['another_cookie', false],
            ],
            'metadata' => 123456,
        ]);

        self::assertStatusCode(Response::HTTP_BAD_REQUEST, $response);
    }

    public function testDecisionLogMetadataBadUuid(): void
    {
        $response = $this->getClient()->post('/rest/cookies-regulation/log', [], [
            'preferences' => [
                ['google_tag_manager', true],
                ['another_cookie', false],
            ],
            'metadata' => [
                'uuid' => false,
                'date' => '2020-11-03 17:55:47',
            ],
        ]);

        self::assertStatusCode(Response::HTTP_BAD_REQUEST, $response);
    }

    public function testDecisionLogMetadataBadDate(): void
    {
        $response = $this->getClient()->post('/rest/cookies-regulation/log', [], [
            'preferences' => [
                ['google_tag_manager', true],
                ['another_cookie', false],
            ],
            'metadata' => [
                'uuid' => '13336e1c-1c5c-4d24-8229-6eabb98f90bd',
                'date' => '1685463516584684',
            ],
        ]);

        self::assertStatusCode(Response::HTTP_BAD_REQUEST, $response);
    }
}
