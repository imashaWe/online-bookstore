<?php
require "../vendor/autoload.php";
require "../core/config.php";

use Aws\S3\S3Client;

define('key', $_CONFIG['AWS']['key']);
define('secret', $_CONFIG['AWS']['secret']);

function upload_to_s3_bucket($file, $name)
{
    try {
        // creates a client object, informing AWS credentials
        $credentials = new Aws\Credentials\Credentials(key, secret);
        $clientS3 = new S3Client([
            'region' => 'us-east-1',
            'version' => '2006-03-01',
            'credentials' => $credentials
        ]);

        // putObject method sends data to the chosen bucket (in our case, teste-marcelo)
        $response = $clientS3->putObject(array(
            'Bucket' => "online-bookstore",
            'Key' => $name,
            'SourceFile' => $file['tmp_name'],
        ));

        return $response['ObjectURL'];

    } catch (Exception $e) {
        echo "Error > {$e->getMessage()}";
        return 0;

    }
}

