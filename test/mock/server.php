<?php

include "../../src/EncryptedApi/Server.php";
include "../../vendor/hieblmedia/simple-php-encrypter-decrypter/src/Encryption/Encrypter.php";

$encryption_key = 'encryption_key';

$server = new \EncryptedApi\Server($encryption_key);

echo $server->encodeResponse(array(
	'status' => 'ok',
	'request' => $server->processRequest()
));

