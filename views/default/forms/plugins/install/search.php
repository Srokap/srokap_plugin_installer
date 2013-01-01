<?php
echo '<div>';
echo elgg_view('input/text', array(
	'name' => 'q',
	'placeholder' => elgg_echo('srokap_plugin_installer:search:q:placeholder'),
	'value' => get_input('q'),
));
echo '</div>';

echo '<div>';
echo '<label>'.elgg_echo('sort').'</label> ';
echo elgg_view('input/dropdown', array(
	'name' => 'sort',
	'options_values' => array(
		'relevance' => elgg_echo('search:sort:by:relevance'),
		'created' => elgg_echo('search:sort:by:created'),
		'updated' => elgg_echo('search:sort:by:updated'),
	),
	'value' => get_input('sort', 'relevance'),
));
echo '</div>';
