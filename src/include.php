<?php 

require_once __DIR__ . '/../vendor/autoload.php';

$config = parse_ini_file(__DIR__ . '/config/config.ini');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__ . '/classes');
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'host'     => $config['db_host'],
    'port'     => $config['db_port'],
    'driver'   => $config['db_driver'],
    'user'     => $config['db_user'],
    'password' => $config['db_password'],
    'dbname'   => $config['db_name'],
);


$doctrineConfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $doctrineConfig);
