<?php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;

$entityPaths = array("../src");
// конфигурация подключения
$dbParams = array(
    'driver'   => 'pdo_pgsql',
    'user'     => 'postgres',
    'password' => '',
    'dbname'   => 'admin_chart_test',
);

$config = Setup::createAnnotationMetadataConfiguration($entityPaths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
