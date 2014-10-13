<?

namespace EncryptedApi;

class Client {
	private $encryptionKey;
	private $url;

	public function __construct($url = null, $encryptionKey = null) {
		if ($encryptionKey) {
			$this->setEncryptionKey($encryptionKey);
		}

		if ($url) {
			$this->setURL($url);
		}
	}

	public function setEncryptionKey($encryptionKey) {
		if (!empty($encryptionKey)) {
			$this->encryptionKey = $encryptionKey;
		} else {
			throw new \InvalidArgumentException('encryption key not provided.');
		}
	}

	public function setURL($url) {
		if (!empty($url)) {
			$this->url = $url;
		} else {
			throw new \InvalidArgumentException('encryption key not provided.');
		}
	}

	public function createRequestURL($requestData) {
		if (empty($this->url)) {
			throw new \Exception('server URL not specified.');
		}

		$url = $this->url;

		if (preg_match('/\?/', $this->url)) {
			$url .= '&';
		} else {
			$url .= '?';
		}

		$encoded_request = $this->encodeRequest($requestData);

		$url .= 'r='.$encoded_request;

		return $url;
	}

	public function sendRequest($requestData) {
		$request_url = $this->createRequestURL($requestData);

		// Init curl
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $request_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$encoded_response = curl_exec($curl);

		$response = $this->decodeResponse($encoded_response);

		return $response;
	}

	public function encodeRequest($requestData) {
		if (empty($this->encryptionKey)) {
			throw new \Exception('encryption key not specified.');			
		}

		$serialized_request = json_encode($requestData, true);

		$encrypter = new \Encryption\Encrypter($this->encryptionKey);

		$encoded = $encrypter->encode($serialized_request);

		return $encoded;
	}

	public function decodeResponse($encoded) {
		$encrypter = new \Encryption\Encrypter($this->encryptionKey);
		
		$decoded = json_decode($encrypter->decode($encoded), true);



		return $decoded;
	}

}