<?php

namespace src\Infra\EntityManager;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;

class EntityManagerCreator
{
    protected static $entityManager;

    public static function create(): EntityManager
    {
        $paths = [__DIR__ . "/../../Dominio"];
        $isDevMode = true;

        $config = ORMSetup::createAnnotationMetadataConfiguration($paths, $isDevMode);

        $connectionParams = [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/db.sqlite',
        ];

        $connection = DriverManager::getConnection($connectionParams, $config);

        return new EntityManager($connection, $config);
    }

    public static function getEntityManager()
    {
        if (!self::$entityManager) {
            self::$entityManager = self::create();
        }

        return self::$entityManager;
    }
}
