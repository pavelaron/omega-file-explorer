<?php

$dir = "files";

// Run the recursive function 

$response = scan($dir);

function is_media($path) {
	if (@is_array(getimagesize($path))) {
		return true;
	}

	$segments = explode('.', $path);
	$ext = end($segments);

	return in_array($ext, array('flv', 'mp4', 'ogv', 'webm'));
}

// This function scans the files folder recursively, and builds a large array

function scan($dir) {
	$files = array();

	// Check if directory exists
	if (!file_exists($dir)) {
		return $files;
	}

	try {
		$directoryIterator = new RecursiveDirectoryIterator(
			$dir,
			RecursiveDirectoryIterator::SKIP_DOTS,
		);

		// Only iterate through the current directory level (not recursive)
		foreach ($directoryIterator as $fileInfo) {
			$fileName = $fileInfo->getFilename();

			// Skip hidden files
			if ($fileName[0] == '.') {
				continue;
			}
			
			$path = $fileInfo->getPathname();
			$isDir = $fileInfo->isDir();
			$key = $isDir ? 'items' : 'size';

			$files[] = array(
				'name' => $fileName,
				'type' => $isDir ? 'folder' : 'file',
				'path' => $path,
				'is_media' => is_media($path),
				$key => $isDir ? scan($path) : $fileInfo->getSize(),
			);
		}
	} catch (Exception $e) {
		$files = [];
	}

	return $files;
}


// Output the directory listing as JSON

header('Content-type: application/json');
echo json_encode(array(
	"name"	=> "files",
	"type"	=> "folder",
	"path"	=> $dir,
	"items"	=> $response
));
