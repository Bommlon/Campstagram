<?php
$targetDir = "pictures/";
$allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

 // create new directory with 744 permissions if it does not exist yet
 // owner will be the user/group the PHP script is run under
 if ( !file_exists($targetDir) ) {
	mkdir ($targetDir, 0744);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
	$file = $_FILES['image'];
	$description = $_POST['description'] ?? 'image';

	$mime = mime_content_type($file['tmp_name']);
	if (in_array($mime, $allowedTypes) && $file['error'] === 0) {
		// Clean description: remove special chars, replace spaces with underscores
		$desc = preg_replace('/[^a-zA-Z0-9-_ ]/', '', $description);
		$desc = str_replace(' ', '_', $desc);

		// Ensure filename is unique by adding current timestamp
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		$filename = $desc . '_' . time() . '.' . $ext;

		$targetFile = $targetDir . $filename;
		move_uploaded_file($file['tmp_name'], $targetFile);
	}
}

header('Location: index.php');
exit;
?>
