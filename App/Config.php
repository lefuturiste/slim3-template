<?php

namespace App;

class Config
{
	/**
	 * Get all configs keys
	 *
	 * @param string $dir (slash is required)
	 * @return mixed
	 */
	public static function get($dir = __DIR__ . '/config/')
	{
		//instance of dotenv lib
		//racine of the project we could find the .env file
		$dotenv = new \Dotenv\Dotenv('..');
		$dotenv->load();

		//find all file with .php extension in $dir
		$allConfigFiles = include $dir . 'map.php';

		//include it in the config array
		$i = 0;
		$config = [];
		while ($i < count($allConfigFiles)){
			$config = array_merge($config, include $dir . $allConfigFiles[$i]);
			$i++;
		}

		//finish and return
		return $config;
	}
}