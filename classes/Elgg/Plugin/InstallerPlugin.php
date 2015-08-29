<?php

namespace Elgg\Plugin;

class InstallerPlugin {

	public function init() {
		$url = elgg_get_simplecache_url('plugin_installer/style.css');
		elgg_register_css('plugin_installer.style', $url);

		$actionsPath = dirname(dirname(dirname(__DIR__))) . '/actions/';
//		elgg_register_action('admin/plugins/install/search', $actionsPath . 'admin/plugins/install/search.php', 'admin');
		elgg_register_action('admin/plugins/install/install', $actionsPath . 'admin/plugins/install/install.php', 'admin');

		elgg_register_menu_item('page', array(
			'name' => 'plugin_installer',
			'href' => 'admin/plugins/install/',
			'text' => elgg_echo('plugin_installer:admin_menu:install'),
			'context' => 'admin',
			'section' => 'configure',
			'priority' => 100,
		));
	}

}