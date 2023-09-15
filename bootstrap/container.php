<?php declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;
use League\Container\ReflectionContainer;
use League\Container\Container;

/**
 * Container setup
 */
$container = new Container();
$container->delegate(
    new ReflectionContainer() // Auto-wiring
);

/**
 * set Request
 */
$container->add(Request::class,Request::createFromGlobals());

/**
 * set Twig
 */
$container->add(\Twig\Environment::class)
    ->addArgument(new Twig\Loader\FilesystemLoader(BASEPATH.'/src/Presentation/Views'));

