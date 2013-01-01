<?php
admin_gatekeeper();

$url = get_input('url');
$stats = false;

//extract stats list html from sidebar
$content = srokap_http::getUrl($url);
$pos = strpos($content, '<ul class="plugin_stats">');
if ($pos) {
	$stats = substr($content, $pos, strpos($content, '</ul>', $pos)-$pos+5);
}

if ($stats) {
	echo '<div class="elgg-plugin-more">';
	echo $stats;
	echo '</div>';
} else {
	echo '<p class="elgg-state-error">'.elgg_echo('srokap_plugin_installer:plugin:details_error', array($url)).'</p>';
}

