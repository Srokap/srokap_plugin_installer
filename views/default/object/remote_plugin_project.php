<?php

$entity = elgg_extract('entity', $vars);
// $icon = elgg_view_entity_icon($entity, 'small');

$title = elgg_view('output/url', array(
	'href' => $entity->getURL(),
	'text' => $entity->title,
	'target' => '_blank',
));

if (elgg_instanceof($entity, 'object')) {
	$metadata = elgg_view('navigation/menu/metadata', $vars);
}

$date = elgg_view_friendly_time($entity->time_created);

$subtitle = elgg_echo('srokap_plugin_installer:created', array($date));

$content = '';

if (!$entity->validateURL()) {
	$content .= '<p class="elgg-state-error">'.elgg_echo('srokap_plugin_installer:possibly_broken').'</p>';
}

$content .= elgg_view('output/longtext', array(
	'value' => $entity->description,
));

$content .= '<div class="pts">';
$content .= elgg_view('output/url', array(
	'href' => '#',
	'text' => elgg_echo('srokap_plugin_installer:plugin:details_link'),
	'class' => 'plugin-show-details',
	'data-url' => $entity->rssGuid,
));
$content .= '</div>';

$image_alt .= '<div class="mtm">'.elgg_view('output/url', array(
	'href' => $entity->getDownloadActionURL(),
	'text' => elgg_echo('srokap_plugin_installer:download'),
	'class' => 'elgg-button elgg-button-submit',
)).'</div>';

$params = array(
	'entity' => $entity,
	'title' => $title,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'tags' => $entity->tags,
	'content' => $content,
);
$params = $params + $vars;
$body = elgg_view('object/elements/summary', $params);

// $vars['image'] = $icon;
$vars['body'] = $body;
$vars['image_alt'] = $image_alt;
$vars['class'] = 'elgg-plugin elgg-state-active';
echo elgg_view('page/components/image_block', $vars);
