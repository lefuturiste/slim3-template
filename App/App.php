<?php
namespace App;
use Config\Config;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\FilesystemCache;

class App extends \DI\Bridge\Slim\App
{
	protected function configureContainer(ContainerBuilder $builder)
	{
		$builder->addDefinitions(__DIR__ . '/config/app.php');
		$builder->addDefinitions(__DIR__ . '/config/api.php');
		$builder->addDefinitions(__DIR__ . '/config/database.php');
		$builder->addDefinitions(__DIR__ . '/config/containers.php');
		if (getenv('PHP_DI_CACHE')) {
			$builder->setDefinitionCache(new FilesystemCache('tmp/di'));
			$builder->writeProxiesToFile(true, 'tmp/proxies');
		}
	}

}
