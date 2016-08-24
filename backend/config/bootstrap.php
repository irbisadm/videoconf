<?php
require_once __DIR__ . "/../vendor/autoload.php";
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
//Doctrine2 settings
$isDev = true;
header('Access-Control-Allow-Origin:*');
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../src/VideoConf/Data"), $isDev);

$conn = array(
  'driver'   => 'pdo_mysql',
  'host'     => '127.0.0.1:8889',
  'user'     => 'videoapp',
  'password' => 'hV4PsVsuNM3pB5DP',
  'dbname'   => 'videoapp',
);
$entityManager = EntityManager::create($conn, $config);
