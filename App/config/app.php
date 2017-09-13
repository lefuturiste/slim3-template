<?php
return [
	'app_name' => getenv('APP_NAME'),
	'app_debug' => tobool(getenv('APP_DEBUG')),
	'env_name' => getenv('APP_ENV_NAME'),
	'log' => [
		'level' => getenv('LOG_LEVEL'),
		'discord' => getenv('LOG_DISCORD'),
		'discord_webhooks' => [
			'https://discordapp.com/api/webhooks/349907239303249930/QDPTQxUjaiD3wTrGH14eYa2jyVmdmxG1UNjaOAgP_lmqMEV_-KSq5kt7TG9A5A8GEO10'
		],
		'path' => getenv('LOG_PATH')
	],
	'twig' => [
		'cache' => getenv('TWIG_CACHE')
	]
];