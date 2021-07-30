<?php declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Tests\Controller;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\ControllerTestCase;
use RichId\CookiesRegulationBundle\Entity\DecisionLog;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \RichId\CookiesRegulationBundle\Controller\DecisionLogRoute
 * @covers \RichId\CookiesRegulationBundle\Entity\DecisionLog
 */
final class DecisionLogRouteTest extends ControllerTestCase
{
    #[TestConfig('container')]
    public function testDecisionLog(): void
    {
        $response = $this->getClient()->post('/rest/cookies-regulation/log', [], [
            'preferences' =>  [
                ['google_tag_manager', true],
                ['another_cookie', false],
            ],
            'metadata' => [
                'uuid' => '13336e1c-1c5c-4d24-8229-6eabb98f90bd',
                'date' => '03/11/2020, 17:55:47'
            ]
        ]);

        self::assertStatusCode(Response::HTTP_NO_CONTENT, $response);

        $logs = $this->getRepository(DecisionLog::class)->findAll();
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
}
