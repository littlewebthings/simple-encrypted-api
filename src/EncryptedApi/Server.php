<?php

namespace EncryptedApi;

class Server {
	
	private $encryptionKey;

	public function __construct($encryptionKey = null) {
		if ($encryptionKey) {
			$this->setEncryptionKey($encryptionKey);
		}
	}

	public function setEncryptionKey(String $encryptionKey) {
		if (!empty($encryptionKey)) {
			$this->encryptionKey = $encryptionKey;
		} else {
			throw new \InvalidArgumentException('encryption key not provided.');
		}
	}

	public function processRequest(String $encryptedRequest) {

		if (empty($this->encryptionKey)) {
			throw new \Exception('encryption key not present.');
		}

		$encrypter = new Encryption\Encrypter($this->encryptionKey);

		$serialized_request = $encrypter->decode($encryptedRequest);

		$request = unserialize($serialized_request);

		return $request;
	}

}