<?php
require_once __DIR__ . '/aws/aws-autoloader.php';
use Aws\S3\S3Client;
class AwsSDK{

	public $client = null;

	public function __construct(){

		$this->client = S3Client::factory(array(
			'version' => 'latest',
			'region' => 'us-east-1',
		    'scheme' => 'http',
		    'credentials' => array(
		        'key'    => 'AKIAJFM5252LZSPX453Q',
		        'secret' => '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'
		    )

		));
		$this->client->registerStreamWrapper();

	}


}

?>
