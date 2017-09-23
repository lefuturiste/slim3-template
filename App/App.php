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
		$builder->addDefinitions(__DIR__ . '/config/di.php');
	}
}