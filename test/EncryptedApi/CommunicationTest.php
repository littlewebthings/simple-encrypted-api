<?php 

namespace Encryption\Test;

use EncryptedApi\Client;
use EncryptedApi\Server;

class CommunicationTest extends \PHPUnit_Framework_TestCase {

	private $encryption_key = 'encryption_key';
	private $api_key = 'api_key';

	public function testServerResponse() {

		$client = new Client('http://localhost/simple-encrypted-api/test/mock/server.php', $this->encryption_key);

		$request = array(
			"action" => "save",
			"object" => array(
				"name" => "mock object"
			)
		);

		$response = $client->sendRequest($request);

		$this->assertArrayHasKey('request', $response);
	}
}