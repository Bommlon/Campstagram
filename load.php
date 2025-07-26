<?php
// pls don't cache response thank you
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

$folder = 'pictures';
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

$images = glob($folder . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
shuffle($images);

$perPage = 20;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$start = ($page - 1) * $perPage;
$imagesToShow = array_slice($images, $start, $perPage);

foreach ($imagesToShow as $image) {
	$name = basename($image);

	// Clean filename into description
	$text = preg_replace('/_[0-9]{10}(?=\.(jpg|jpeg|png|gif))/i', '', $name);	// remove timestamp (10 digit number just before file extension)
	$text = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '', $text);	// remove file extension
	$text = str_replace('_', ' ', $text);	// replace _ with space

	// Output HTML for each image
	echo "
    <div class = 'post-container'>
		<div class = 'post'>
			<img src='img.php?name={$name}' loading='lazy' />
			<div class = 'description'>$text</div>
		</div>
	</div>
    ";
}
?>