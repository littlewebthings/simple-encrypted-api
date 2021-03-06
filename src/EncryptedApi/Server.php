<?php

namespace EncryptedApi;

class Server {
	
	private $encryptionKey;

	public function __construct($encryptionKey = null) {
		if ($encryptionKey) {
			$this->setEncryptionKey($encryptionKey);
		}
	}

	public function setEncryptionKey($encryptionKey) {
		if (!empty($encryptionKey)) {
			$this->encryptionKey = $encryptionKey;
		} else {
			throw new \InvalidArgumentException('encryption key not provided.');
		}
	}

	public function processRequest() {
		$encryptedRequest = $_GET['r'];

		return $this->decodeRequest($encryptedRequest);
	}

	public function decodeRequest($encryptedRequest) {
		if (empty($this->encryptionKey)) {
			throw new \Exception('encryption key not present.');
		}

		$encrypter = new \Encryption\Encrypter($this->encryptionKey);

		$serialized_request = $encrypter->decode($encryptedRequest);

		$request = json_decode($serialized_request, true);
	
		return $request;
	}

	public function encodeResponse($response) {

		$serialized = json_encode($response, true);

		$encrypter = new \Encryption\Encrypter($this->encryptionKey);

		$response = $encrypter->encode($serialized);

		return $response;
	}
}