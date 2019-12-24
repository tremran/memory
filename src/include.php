<?php 

// permet de connaitre les classes des packages ajoutés par composer
require_once __DIR__ . '/../vendor/autoload.php';

// Lis le fichier de configuration
$config = parse_ini_file(__DIR__ . '/config/config.ini');

// initialise l'entitymanager de Doctrine
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
