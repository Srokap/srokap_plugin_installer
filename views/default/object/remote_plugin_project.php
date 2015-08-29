<?php
/**
 * ElggObject default view.
 *
 * @warning This view may be used for other ElggEntity objects
 *
 * @package Elgg
 * @subpackage Core
 */

elgg_load_css('plugin_installer.style');


/*
if ($active) {
	$classes[] = 'elgg-state-active';
	$action = 'deactivate';
	$options['title'] = elgg_echo('admin:plugins:deactivate');
	$options['class'] = 'elgg-button elgg-button-cancel';
	$options['text'] = elgg_echo('admin:plugins:deactivate');
	if (!$can_activate) {
		$classes[] = 'elgg-state-active elgg-state-cannot-activate';
	}
} else if ($can_activate) {
	$classes[] = 'elgg-state-inactive';
	$action = 'activate';
	$options['title'] = elgg_echo('admin:plugins:activate');
	$options['class'] = 'elgg-button elgg-button-submit';
	$options['text'] = elgg_echo('admin:plugins:activate');

} else {
	$classes[] = 'elgg-state-inactive elgg-state-cannot-activate';
	$action = '';
	$options['text'] = elgg_echo('admin:plugins:cannot_activate');

	$options['disabled'] = 'disabled';
}

if ($action) {
	$url = elgg_http_add_url_query_elements($actions_base . $action, array(
		'plugin_guids[]' => $plugin->guid
	));

	$options['href'] = $url;
}
$action_button = elgg_view('output/url', $options);
 */


$classes[] = 'elgg-state-inactive';
$action = 'install';
$options['title'] = elgg_echo('plugin_installer:install');
$options['class'] = 'elgg-button elgg-button-submit';
$options['text'] = elgg_echo('plugin_installer:install');
$url = elgg_http_add_url_query_elements('action/admin/plugins/install/' . $action, array(
	'name' => $vars['entity']->name
));
$url = elgg_add_action_tokens_to_url($url);
$options['href'] = $url;

$action_button = elgg_view('output/url', $options);

//$icon = elgg_view_entity_icon($vars['entity'], 'small');


$link_params = array(
	'href' => $vars['entity']->getURL(),
	'text' => $vars['entity']->name,
	'target' => '_blank',
);
$title = elgg_view('output/url', $link_params);

if (elgg_instanceof($vars['entity'], 'object')) {
	$metadata = elgg_view('navigation/menu/metadata', $vars);
}

$date = elgg_view_friendly_time($vars['entity']->getTimeCreated());

$subtitle = "{$vars['entity']->description}";

$stats = '';
$stats .= '<li>' . elgg_view_icon('download-hover') . ' ' . $vars['entity']->downloads . '</li>';
$stats .= '<li>' . elgg_view_icon('star-alt') . ' ' . $vars['entity']->favers . '</li>';

//$repoUrl = elgg_view('output/url', [
//	'href' => $vars['entity']->repository,
//]);

$params = array(
	'entity' => $vars['entity'],
	'title' => $title,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
//	'content' => elgg_view_icon('push-pin') . $repoUrl
);
$params = $params + $vars;
$body = '<ul class="float-alt plugin-installer-meta-box">' . $stats . '</ul>';
$body .= elgg_view('object/elements/summary', $params);

$vars['class'] = 'elgg-plugin';

//$icon = '<div class="elgg-image"><div>' . $action_button . '</div></div>';
$icon = '<div>' . $action_button . '</div>';

echo elgg_view_image_block($icon, $body, $vars);
