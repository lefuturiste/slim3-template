<?php

$container = $app->getContainer();

$container->set('config', $config);

$container->set(\Monolog\Logger::class, function () use($container) {
	$log = new Monolog\Logger($container->get('config')['app_name']);

	$log->pushHandler(new Monolog\Handler\StreamHandler($container->get('config')['log']['path'], $container->get('config')['log']['level']));

	if ($container->get('config')['log']['discord']) {
		$log->pushHandler(new \DiscordHandler\DiscordHandler($container->get('config')['log']['discord_webhooks'], $container->get('config')['app_name'], $container->get('config')['env_name'], $container->get('config')['log']['level']));
	}

	return $log;
});

$container->set('translator', function ($container) {
	// First param is the "default language" to use.
	$translator = new \Symfony\Component\Translation\Translator('fr_FR', new \Symfony\Component\Translation\MessageSelector());
	// Set a fallback language incase you don't have a translation in the default language
	$translator->setFallbackLocales(['fr_FR']);
	// Add a loader that will get the php files we are going to store our translations in
	$translator->addLoader('php', new \Symfony\Component\Translation\Loader\PhpFileLoader());

	// Add language files here
	$translator->addResource('php', '../App/lang/fr_FR.php', 'fr_FR');
	$translator->addResource('php', '../App/lang/en_EN.php', 'en_EN');

	return $translator;
});

$container->set(\Slim\Views\Twig::class, function () use ($app, $container) {
	$dir = dirname(__DIR__);
	$view = new \Slim\Views\Twig($dir . '/App/views', $container->get('config')['twig']);
	$twig = $view->getEnvironment();
	$twig->addExtension($container->get(\App\TwigExtension::class));

	//global variables
	$twig->addGlobal('example', 'example');

	// Instantiate and add Slim specific extension
	$basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
	$view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));
	//translator helper
	$view->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension($container->get('translator')));

	return $view;
});

$container->set('guzzle', function () {
	$client = new GuzzleHttp\Client();

	return $client;
});

$container->set('mysql', function () use ($container) {
	$pdo = new \Simplon\Mysql\PDOConnector(
		$container->get('config')['mysql']['host'], // server
		$container->get('config')['mysql']['user'],     // user
		$container->get('config')['mysql']['password'],      // password
		$container->get('config')['mysql']['database']   // database
	);

	$pdoConn = $pdo->connect('utf8', []); // charset, options

	$dbConn = new \Simplon\Mysql\Mysql($pdoConn);

	return $dbConn;
});