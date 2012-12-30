<?php
class srokap_plugin_installer {
	static function init() {
		elgg_register_event_handler('pagesetup', 'system', array(__CLASS__, 'pagesetup'));
		elgg_register_js('ui.plugins.installer', 'mod/'.__CLASS__.'/js/ui.plugins.installer.js');
		elgg_register_ajax_view('plugins/install/search/results');
	}
	
	static function pagesetup() {
		elgg_register_menu_item('page', array(
			'name' => 'srokap_plugin_installer',
			'href' => 'admin/plugins/install/',
			'text' => elgg_echo('admin:plugins:install'),
			'context' => 'admin',
			'section' => 'configure',
			'priority' => 100,
		));
	}
}