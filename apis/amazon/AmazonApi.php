<?php namespace WppFramework;

use Aws\S3\S3Client;

class AmazonApi
{

    public function AmazonApiConfig($setup)
    {
        $s3 = new Aws\S3\S3Client([
            'version' => 'latest',
            'region' => $setup['region']
        ]);

     return $s3;
    }


}