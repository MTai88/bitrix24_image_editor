<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/image_editor.bundle.css',
	'js' => 'dist/image_editor.bundle.js',
	'rel' => [
		'main.polyfill.core',
		'landing.imageeditor',
	],
	'skip_core' => true,
];