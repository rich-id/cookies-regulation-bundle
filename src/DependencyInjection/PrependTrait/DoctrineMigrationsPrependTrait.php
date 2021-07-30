<?php declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\DependencyInjection\PrependTrait;

use Symfony\Component\DependencyInjection\ContainerBuilder;

trait DoctrineMigrationsPrependTrait
{
    protected function prependDoctrineMigrations(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('doctrine_migrations')) {
            return;
        }

        $doctrineConfig = $container->getExtensionConfig('doctrine_migrations');
        $doctrineMigrationPaths = \array_pop($doctrineConfig)['migrations_paths'] ?? [];

        $container->prependExtensionConfig('doctrine_migrations', [
            'migrations_paths' => \array_merge($doctrineMigrationPaths, [
                'RichId\CookiesRegulationBundle\Migrations' => '@RichIdCookiesRegulationBundle/Migrations',
            ]),
        ]);
    }
}
