<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DataMapper2Storage;

/**
 * Description of WebStorage
 *
 * @author d.lanec
 */
class WebStorage implements StorageDao, \Psr\Log\LoggerAwareInterface {
	
	protected $source_url;
	
	use \Psr\Log\LoggerAwareTrait;
			
	function __construct($source_url) {
		$this->source_url = $source_url;
		$this->logger     = new \Psr\Log\NullLogger;
	}
	
	public function delete($id) {
		$res = json_decode($this->getSource('/' .$id ,[],"DELETE"),true);
		return $res['result']===true;			
	}

	public function fetchAll() {
		return json_decode($this->getSource(''),true);
	}

	public function fetchRow($id) {
		return json_decode($this->getSource('/' .$id),true);
	}

	public function insert(array $data) {
		$res = json_decode($this->getSource('',$data,"POST"),true);
		return $res['result']===true;		
	}

	public function update($id,array $data) {
		$res = json_decode($this->getSource('/'. $id,$data,"PUT"),true);
		return $res['result']===true;		
	}
	
	protected function getSource($url,array $data = [], $type = "GET"){

		//$fp = fopen($tmp_path, 'w');

		$ch = curl_init($this->source_url . $url);
		//curl_setopt($ch, CURLOPT_FILE, $fp);
		
		$this->logger->debug("curl init source ". $this->source_url . $url);
		
		curl_setopt($ch, CURLOPT_HEADER, false);
		
		curl_setopt($ch, CURLOPT_TIMEOUT, 200);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		
		switch ($type) {
			case "PUT":
				curl_setopt($ch, CURLOPT_POST, 0);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
				$this->logger->debug("curl put");
				break;
			
			case "DELETE":

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				$this->logger->debug("curl delete");
				break;
			
			case "POST":

				curl_setopt($ch, CURLOPT_POST, 0);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
				$this->logger->debug("curl post ". http_build_query($data));
				break;			

			default:
				$this->logger->debug("curl get ");
				break;
		}
		

		//$res = curl_exec_follow($ch,$fp, false );
		
		$res = curl_exec($ch);
			
		$info = curl_getinfo($ch);
		
		if($info['http_code']!=200){
			$this->logger->debug("curl http code ". $info['http_code'] );
		}

		curl_close($ch);
		
		return $res;
	}	
	
}
