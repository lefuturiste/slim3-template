<?php
namespace App;

//TO DO: A commenter
class MinecraftServerQuery {

	private $endpoint = "https://mcapi.us/server/";

	public function __construct($container, $config)
	{
			$this->guzzle = $container->guzzle;
			$this->config = $config;
	}

	private function extractData($resp){
		return json_decode($resp->getBody(), 1);
	}

	private function getData(){
		return $this->extractData($this->guzzle->request('GET', $this->endpoint . 'status?ip=' . $this->config['host']));
	}

	public function getStatus(){
		$data = $this->getData();
		if ($data['status'] == 'success'){
			return true;
		}else{
			return false;
		}
	}

	public function getInfos(){
		if ($this->getStatus()){
			$data = $this->getData();
			return [
				'motd' => $data['motd'],
				'motd_extra' => $data['motd_extra'],
				'motd_formatted' => $data['motd_formatted'],
				'server' => $data['server']
			];
		}
	}

	public function getPlayers(){
		if ($this->getStatus()){
			$data = $this->getData();
			return $data['players'];
		}else{
			return $this->getStatus();
		}
	}

}