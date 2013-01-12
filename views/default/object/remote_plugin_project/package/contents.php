<?php
admin_gatekeeper();

$guid = get_input('guid');
$version = get_input('version');
$entity = ElggRemotePluginProject::getByPackage($guid, $version);

$path = $entity->getPackagePath(null, 'package');
$contents = srokap_zip::getArchiveNameIndex($path);
$possibleRoots = srokap_plugin_installer::getPossiblePluginRoots($contents);

$body = '<div class="mtm">'.elgg_echo('srokap_plugin_installer:version', array($version)).'</div>';

if ($possibleRoots!==false) {
	$body .= '<div class="mtm">'.elgg_echo('srokap_plugin_installer:best_root', array($possibleRoots[0])).'</div>';
} else {
	$body .= '<div class="mtm">'.elgg_echo('srokap_plugin_installer:no_root').'</div>';
}

if (is_array($contents)) {
	$body .= '<pre style="max-width:100%;max-height:500px;overflow:scroll">';
	foreach ($contents as $file) {
		$body .= "$file\n";
	}
	$body .= '</pre>';
} else {
	$body .= elgg_echo('srokap_plugin_installer:error:cannot_read_package', array($path));
}

$title = $entity->title;

echo elgg_view_module('aside', $title, $body);
