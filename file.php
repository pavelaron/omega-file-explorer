<?php

if (!isset($_GET['path'])) {
	http_response_code(400);
	echo 'Bad request';

	exit;
}

$path = $_GET['path'];

if (!file_exists($path)) {
	http_response_code(404);
	echo 'File not found';

	exit;
}

$mime_types = array(
	'txt'       => 'text/plain',
	'log'       => 'text/plain',
	'js'        => 'text/javascript',
	'css'       => 'text/css',
	'htm'       => 'text/html',
	'html'      => 'text/html',
	'diff'      => 'text/x-patch',
	'patch'     => 'text/x-patch',
	'c'         => 'text/x-csrc',
	'h'         => 'text/x-chdr',
	'o'         => 'text/x-object',
	'ko'        => 'text/x-object',

	'bmp'       => 'image/bmp',
	'gif'       => 'image/gif',
	'png'       => 'image/png',
	'jpg'       => 'image/jpeg',
	'jpeg'      => 'image/jpeg',
	'svg'       => 'image/svg+xml',

	'json'      => 'application/json',
	'jsonp'     => 'application/javascript',
	'zip'       => 'application/zip',
	'pdf'       => 'application/pdf',
	'xml'       => 'application/xml',
	'xsl'       => 'application/xml',
	'doc'       => 'application/msword',
	'ppt'       => 'application/vnd.ms-powerpoint',
	'xls'       => 'application/vnd.ms-excel',
	'odt'       => 'application/vnd.oasis.opendocument.text',
	'odp'       => 'application/vnd.oasis.opendocument.presentation',
	'pl'        => 'application/x-perl',
	'sh'        => 'application/x-shellscript',
	'php'       => 'application/x-php',
	'deb'       => 'application/x-deb',
	'iso'       => 'application/x-cd-image',
	'tar.gz'    => 'application/x-compressed-tar',
	'tgz'       => 'application/x-compressed-tar',
	'gz'        => 'application/x-gzip',
	'tar.bz2'   => 'application/x-bzip-compressed-tar',
	'tbz'       => 'application/x-bzip-compressed-tar',
	'bz2'       => 'application/x-bzip',
	'tar'       => 'application/x-tar',
	'rar'       => 'application/x-rar-compressed',

	'mp3'       => 'audio/mpeg',
	'ogg'       => 'audio/x-vorbis+ogg',
	'wav'       => 'audio/x-wav',
	'aac'       => 'audio/aac',

	'mpg'       => 'video/mpeg',
	'mpeg'      => 'video/mpeg',
	'avi'       => 'video/x-msvideo',
	'mov'       => 'video/quicktime',
	'mp4'       => 'video/mp4',
	'ogv'       => 'video/ogg',
	'webm'      => 'video/webm',
	'flv'       => 'video/x-flv',

	'README'    => 'text/plain',
	'log'       => 'text/plain',
	'cfg'       => 'text/plain',
	'conf'      => 'text/plain',

	'pac'       => 'application/x-ns-proxy-autoconfig',
	'wpad.dat'  => 'application/x-ns-proxy-autoconfig',
	'appcache'  => 'text/cache-manifest',
	'manifest'  => 'text/cache-manifest',
);

$extension = pathinfo($path, PATHINFO_EXTENSION);
$content_type = isset($mime_types[$extension])
	? $mime_types[$extension] 
	: 'application/octet-stream';

header("Content-type: $content_type");
readfile(implode('/', [__DIR__, $path]));
