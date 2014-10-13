<?php 

namespace Encryption\Test;

use EncryptedApi\Client;
use EncryptedApi\Server;

class ClientTest extends \PHPUnit_Framework_TestCase {

	private $encryption_key = 'encryption_key';
	private $api_key = 'api_key';

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInputKeyValidated() {

		$client = new Client();

		$client->setEncryptionKey('');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInputURLValidated() {

		$client = new Client();

		$client->setURL('');
	}

	public function testEncodeDecodeArray() {

		$client = new Client('http://localhost', $this->encryption_key);
		$server = new Server($this->encryption_key);

		$request = array(
			"action" => "save",
			"object" => array(
				"name" => "mock object"
			)
		);

		$encoded = $client->encodeRequest($request);

		$decoded = $server->decodeRequest($encoded);

		$this->assertArrayHasKey('action', $decoded);
		$this->assertEquals($decoded['action'], "save");
		$this->assertEquals($decoded['object']['name'], "mock object");
	}
}