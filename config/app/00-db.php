<?php

$ormCache = new \Doctrine\Common\Cache\ArrayCache();
$entityManagerConfig = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration(
    array("config/orm"), false, "config/orm/proxy", $ormCache);
$entityManagerConfig->setAutoGenerateProxyClasses(\Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS);
$entityManagerConfig->setMetadataCacheImpl($ormCache);
//$entityManagerConfig->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
try {
    $entityManager = \Doctrine\ORM\EntityManager::create(array(
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => 'root',
        'dbname' => 'task',
        'host' => '127.0.0.1:8889',
        'connection' => array('compress' => 'true'),
        'driverOptions' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        )
    ), $entityManagerConfig);
    $entityManager->getConnection()->getDatabasePlatform()
        ->registerDoctrineTypeMapping('enum', 'string');
    if (isset($diContainer)) {
        $diContainer->addSharedInstance($entityManager, 'Doctrine\ORM\EntityManagerInterface');
    }
} catch (Exception $ex) {
    throw new InvalidArgumentException('DB-Connection error');
}