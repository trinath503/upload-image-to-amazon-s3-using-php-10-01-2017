<?php
// Bucket Name
$bucket="trinath";
if (!class_exists('S3'))require_once('S3.php');
			
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'your-key');
if (!defined('awsSecretKey')) define('awsSecretKey', 'secret-key');
			
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

?>