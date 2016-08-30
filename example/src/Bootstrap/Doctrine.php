<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__), $isDevMode);

// database configuration parameters
$connection = [
    'driver'  => 'pdo_sqlite',
    'path'    => __DIR__ . '/data.sqlite',
    'charset' => 'utf8',
];

// obtaining the entity manager
$entityManager = EntityManager::create($connection, $config);
