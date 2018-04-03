<?php

use Psr\Container\ContainerInterface;

return [
	'settings.displayErrorDetails' => function (ContainerInterface $container) {
		return $container->get('app_debug');
	},
	'settings.debug' => function (ContainerInterface $container) {
		return $container->get('app_debug');
	},
	'notFoundHandler' => function (ContainerInterface $container) {
		return new \App\NotFoundHandler($container);
	},

	\Monolog\Logger::class => function (ContainerInterface $container) {
		$log = new Monolog\Logger($container->get('app_name'));

		$log->pushHandler(new Monolog\Handler\StreamHandler($container->get('log')['path'], $container->get('log')['level']));

		if ($container->get('log')['discord']) {
			$log->pushHandler(new \DiscordHandler\DiscordHandler(
				$container->get('log')['discord_webhooks'],
				$container->get('app_name'),
				$container->get('env_name'),
				$container->get('log')['level']
			));
		}

		return $log;
	},

	\Symfony\Component\Translation\Translator::class => function () {
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
	},

	\Slim\Views\Twig::class => function (\DI\Container $container, \Symfony\Component\Translation\Translator $translator) {
		$dir = dirname(dirname(__DIR__));
		$view = new \Slim\Views\Twig($dir . '/App/views', $container->get('twig'));
		$twig = $view->getEnvironment();
		$twig->addExtension($container->get(\App\TwigExtension::class));

		//global variables
		$twig->addGlobal('example', 'example');

		// Instantiate and add Slim specific extension
		$basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
		$view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));
		//translator helper
		$view->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension($translator));

		return $view;
	},

	\Simplon\Mysql\Mysql::class => function ($container) {
		$pdo = new \Simplon\Mysql\PDOConnector(
			$container->get('mysql')['host'], // server
			$container->get('mysql')['username'],     // user
			$container->get('mysql')['password'],      // password
			$container->get('mysql')['database']   // database
		);

		$pdoConn = $pdo->connect('utf8', []); // charset, options

		$dbConn = new \Simplon\Mysql\Mysql($pdoConn);

		return $dbConn;
	}
];
