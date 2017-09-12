<?php

use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

$container = $app->getContainer();

$container['config'] = function ($container) use ($config) {
	return $config;
};

$container['session'] = function ($container) use ($config) {
	return new \App\Session();
};

$container['log'] = function ($container) {
	$log = new Monolog\Logger($container->config['app_name']);

	$log->pushHandler(new Monolog\Handler\StreamHandler($container->config['log']['path'], $container->config['log']['level']));

	if ($container->config['log']['discord']) {
		$log->pushHandler(new App\MonologDiscordHandler($container->guzzle, $container->config['log']['discord_webhooks'], $container->config['log']['level']));
	}

	return $log;
};

$container['flash'] = function () {
	return new \Slim\Flash\Messages();
};


$container['minecraft'] = function ($container) {
	return new App\MinecraftServerQuery($container,
		[
			'host' => $container->config['minecraft']['host'],
			'port' => $container->config['minecraft']['port']
		]);
};


$container['translator'] = function ($container) {
	// First param is the "default language" to use.
	$translator = new Translator('fr_FR', new MessageSelector());
	// Set a fallback language incase you don't have a translation in the default language
	$translator->setFallbackLocales(['fr_FR']);
	// Add a loader that will get the php files we are going to store our translations in
	$translator->addLoader('php', new PhpFileLoader());

	// Add language files here
	$translator->addResource('php', '../App/lang/fr_FR.php', 'fr_FR');
	$translator->addResource('php', '../App/lang/en_EN.php', 'en_EN');

	return $translator;
};

$container['view'] = function ($container) use ($app) {
	$dir = dirname(__DIR__);
	$view = new \Slim\Views\Twig($dir . '/App/views', [
		'cache' => false //$dir . 'tmp/cache' OR '../tmp/cache'
	]);
	$twig = $view->getEnvironment();
	$twig->addExtension(new \App\TwigExtension($container));

	//global variables
	$twig->addGlobal('example', 'example');

	// Instantiate and add Slim specific extension
	$basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
	$view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
	//translator helper
	$view->addExtension(new TranslationExtension($container['translator']));

	return $view;
};

$container['guzzle'] = function ($container) {
	$client = new GuzzleHttp\Client();

	return $client;
};

$container['mysql'] = function ($container) {
	$pdo = new \Simplon\Mysql\PDOConnector(
		$container->config['mysql']['host'], // server
		$container->config['mysql']['user'],     // user
		$container->config['mysql']['password'],      // password
		$container->config['mysql']['database']   // database
	);

	$pdoConn = $pdo->connect('utf8', []); // charset, options

	$dbConn = new \Simplon\Mysql\Mysql($pdoConn);

	return $dbConn;
};

$container['notFoundHandler'] = function ($container) {
	return new \App\NotFoundHandler($container->get('view'), function ($request, $response) use ($container) {
		return $container['response']
			->withStatus(404);
	});
};