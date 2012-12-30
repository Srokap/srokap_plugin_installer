<?php
elgg_load_js('ui.plugins.installer');

$body = elgg_view_form('plugins/install/search', array(
	'action' => 'admin/plugins/install',
	'method' => 'get',
	'disable_security' => true,
));
echo elgg_view_module('main', elgg_echo('srokap_plugin_installer:search'), $body);

echo '<br/>';

$body = elgg_view('plugins/install/search/results', array());
echo elgg_view_module('aside', elgg_echo('srokap_plugin_installer:results'), $body, array(
	'id' => 'plugins-install-search-results',
));

echo elgg_view('graphics/ajax_loader', array('id' => 'plugins-install-search-loader'));
