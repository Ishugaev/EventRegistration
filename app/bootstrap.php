<?php

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$config = Yaml::parse(file_get_contents(__DIR__ . '/../config/parameters.yml'));

//init spot orm
$db = new \Spot\Config();
$db->addConnection('mysql', $config['database']);

// create a log channel
$log = new Logger('AppLog');
$log->pushHandler(new StreamHandler(__DIR__. '/../var/log/app.log', Logger::WARNING));

$container = new ContainerBuilder();
$container->set('log', $log);
$container->register('spot', '\Spot\Locator')->addArgument($db);
$container->register('validator', 'Valitron\Validator');
$container->register('registration.manager', 'EventRegistration\Manager\RegistrationRequestManager')
    ->addArgument(new Reference('spot'))
    ->addArgument($container->get('log'));
$container->register('registration.request_validator', 'EventRegistration\RequestValidator\RegistrationRequestValidator')
    ->addArgument(new Reference('validator'));
$container->register('twig', 'Twig_Environment')
    ->addArgument(new Twig_Loader_Filesystem(__DIR__ . '/../src/Resources/views'));
$container->register('event.controller', 'EventRegistration\Controller\EventController')
    ->addArgument(new Reference('twig'))
    ->addArgument(new Reference('spot'))
    ->addArgument(new Reference('registration.request_validator'))
    ->addArgument(new Reference('registration.manager'));
$container->set('dispatcher', $dispatcher);

