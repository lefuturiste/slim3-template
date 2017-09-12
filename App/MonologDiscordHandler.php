<?php
namespace App;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class MonologDiscordHandler extends AbstractProcessingHandler
{
	private $initialized = false;
	private $guzzle;
	private $webhooks;
	private $statement;

	/**
	 * MonologDiscordHandler constructor.
	 * @param \GuzzleHttp\Client $guzzle
	 * @param bool $webhooks
	 * @param int $level
	 * @param bool $bubble
	 */
	public function __construct(\GuzzleHttp\Client $guzzle, $webhooks, $level = Logger::DEBUG, $bubble = true)
	{
		$this->guzzle = $guzzle;
		$this->webhooks = $webhooks;
		parent::__construct($level, $bubble);
	}

	/**
	 * @param array $record
	 */
	protected function write(array $record)
	{
		$content = '[' . $record['datetime']->format('Y-m-d H:i:s') . '] ' . getenv('APP_NAME') . '.' . getenv('APP_ENV_NAME') . '.' . $record['level_name'] . ': ' . $record['message'];

		$i = 0;
		while ($i < count($this->webhooks)){
			$req = $this->guzzle->request('POST', $this->webhooks[$i], [
				'form_params' => [
					'content' => $content
				]
			]);
			$i++;
		}
	}
}