<?php

function is_media($child) {
	$ext = strtolower($child->getExtension());
	
	return in_array(
		$ext,
		[
			'bmp',
			'gif',
			'png',
			'jpg',
			'jpeg',
			'svg',
			'flv',
			'mp4',
			'ogv',
			'webm'
		]
	);
}

function scan($dir) {
	if (!file_exists($dir)) {
		return array();
	}

	$result = array();

	foreach ($dir as $child) {
		$name = $child->getBasename();

		if ($child->isDot() || $name[0] === '.') {
			continue;
		}

		$isDir = $child->isDir();
		$path = $child->getPathname();

		$conditional = $isDir ? 'items' : 'size';
		$conditionalValue = $isDir
			? scan(new DirectoryIterator($path))
			: $child->getSize();

		$result[] = array(
			'name'       => $name,
			'path'       => $path,
			'is_media'   => is_media($child),
			$conditional => $conditionalValue
		);
	}

	return $result;
}

header('Content-type: application/json');
echo json_encode(array(
	'name'  => 'files',
	'path'  => 'files',
	'items' => scan(new DirectoryIterator('files'))
));
