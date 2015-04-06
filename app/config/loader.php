<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$dirs = [

	$config->application->controllersDir,
	$config->application->modelsDir,
	$config->application->transformersDir,
	$config->application->collectionsDir,
];

$loader->registerDirs($dirs);

$loader->registerNamespaces( (array) $config->namespaces);

$loader->register();
