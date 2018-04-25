#!/usr/bin/env php

<?php

require __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger(basename(__FILE__, ".php"));
$logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));

$s3Bucket = getenv('S3_BUCKET');
$s3ObjectKey = getenv('S3_OBJECT_KEY');
$s3Region = getenv('S3_REGION');

$logger->info("S3_BUCKET: " . $s3Bucket);
$logger->info("S3_OBJECT_KEY: " . $s3ObjectKey);
$logger->info("S3_REGION: " . $s3Region);

$s3 = new S3Client(['region' => $s3Region, 'version' => '2006-03-01']);

$download = $s3->getObject(array(
            'Bucket' => $s3Bucket,
            'Key' => $s3ObjectKey,
            'SaveAs' => $s3ObjectKey,
        ));
$logger->info("Downloded files: " . $s3ObjectKey);

$result = $s3->putObject(array(
            'Bucket' => $s3Bucket,
            'Key' => 'test/' . $s3ObjectKey,
            'SourceFile'   => $s3ObjectKey,
        ));
$logger->info("Uploaded files: " . $s3ObjectKey);