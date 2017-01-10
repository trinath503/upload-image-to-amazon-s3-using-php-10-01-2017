<?php
include('image_check.php');
$msg='';
if($_SERVER['REQUEST_METHOD'] == "POST")
{

$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$tmp = $_FILES['file']['tmp_name'];
$ext = getExtension($name);

if(strlen($name) > 0)
{

if(in_array($ext,$valid_formats))
{
 
if($size<(1024*1024))
{
include('s3_config.php');
//Rename image name. 
$actual_image_name = time().".".$ext;


$setHeaders=array(
 
  'cache-control' => 'no-cache',
  'x-ibm-client-secret' => 'X2aH6yD2iQ0eA4sM1tI7wG4iL7nL2gT3tP8jP3pG6iA3qJ3qO4',
  'x-ibm-client-id' => '4f2ebc0b-5e90-4ab2-a3af-599474c03997',
  'secret' => '8MnC/itsh14M9HhGbuX+/oCcsOzYksD0vAMfXETv',
  'bucket' => 'batua-test',
  'key' => 'AKIAIM7PFH47KK5U4WKA'
);


if($s3->putObjectFile($tmp, $bucket , $actual_image_name, $setHeaders) )
{
$msg = "S3 Upload Successful.";	
$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
echo "<img src='$s3file' style='max-width:400px'/><br/>";
echo '<b>S3 File URL:</b>'.$s3file;

}
else
$msg = "S3 Upload Fail.";


}
else
$msg = "Image size Max 1 MB";

}
else
$msg = "Invalid file, please upload image file.";

}
else
$msg = "Please select image file.";

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Files to Amazon S3 PHP</title>
</head>

<body>
<a href='http://www.9lessons.info'>www.9lessons.info</a>
<form action="" method='post' enctype="multipart/form-data">
<h3>Upload image file here</h3><br/>
<div style='margin:10px'><input type='file' name='file'/> <input type='submit' value='Upload Image'/></div>
</form>
<?php 
echo $msg.'<br/>'; 
?>
		

</body>
</html>
