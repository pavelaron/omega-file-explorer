<?php

$dir = "files";

// Run the recursive function 

$response = scan($dir);


// This function scans the files folder recursively, and builds a large array

function scan($dir) {
	$files = array();

	// Is there actually such a folder/file?
	if (file_exists($dir)) {
		foreach (scandir($dir) as $f) {
			if (!$f || $f[0] == '.') {
				continue; // Ignore hidden files
			}
			
			$path = "$dir/$f";
			$is_dir = is_dir($path);
			$key = $is_dir ? 'items' : 'size';
			
			$files[] = array(
				'name' => $f,
				'type' => $is_dir ? 'folder' : 'file',
				'path' => $path,
				'is_img' => @is_array(getimagesize($path)),
				$key => $is_dir ? scan($path) : filesize($path)
			);
		}
	}

	return $files;
}


// Output the directory listing as JSON

header('Content-type: application/json');
echo json_encode(array(
	"name" => "files",
	"type" => "folder",
	"path" => $dir,
	"items" => $response
));
