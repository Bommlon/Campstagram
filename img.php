<?php
$folder = 'pictures';
$filename = basename($_GET['name']); // strips path
$filepath = $folder . '/' . $filename;

if (!preg_match('/\.(jpg|jpeg|png|gif)$/i', $filename)) {
	http_response_code(400);
	exit('Invalid file type.');
}

if (!file_exists($filepath)) {
	http_response_code(404);
	exit('Image not found.');
}

$mime = mime_content_type($filepath);
header("Content-Type: $mime");
readfile($filepath);
?>