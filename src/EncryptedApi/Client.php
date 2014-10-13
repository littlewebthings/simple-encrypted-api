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

	public function setEncryptionKey(String $encryptionKey) {
		if (!empty($encryptionKey)) {
			$this->encryptionKey = $encryptionKey;
		} else {
			throw new \InvalidArgumentException('encryption key not provided.');
		}
	}

	public function setURL(String $url) {
		if (!empty($url)) {
			$this->url = $url;
		} else {
			throw new \InvalidArgumentException('encryption key not provided.');
		}
	}

	public function sendRequest($requestData) {
		if (empty($this->url)) {
			throw new \Exception('server URL not specified.');
		}

		if (empty($this->encryptionKey)) {
			throw new \Exception('encryption key not specified.');			
		}

		$serialized_request = serialize($requestData);

		$encrypter = new \Encryption\Encrypter($this->encryptionKey);

		$encoded = $encrypted->encode($serialized_request);

		// Init curl
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $this->url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($curl);

		return $result;
	}

}