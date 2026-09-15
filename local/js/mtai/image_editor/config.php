<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'js' => 'dist/image_editor.bundle.js',
	'rel' => [
		'main.polyfill.core',
		'landing.imageeditor',
	],
	'skip_core' => true,
];
