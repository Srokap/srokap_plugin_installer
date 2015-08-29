<?php
echo '<div>';
echo elgg_view('input/text', array(
	'name' => 'q',
	'placeholder' => elgg_echo('plugin_install:search:q:placeholder'),
	'value' => get_input('q'),
	'autofocus' => 'autofocus',
));
echo '</div>';


//sorting
echo '<div>';
echo '<label>'.elgg_echo('plugin_install:sort_by').'</label> ';
echo elgg_view('input/dropdown', array(
	'name' => 'sort',
	'options_values' => array(
		'none' => elgg_echo('plugin_install:sort:none'),
		'downloads' => elgg_echo('plugin_install:sort:downloads'),
		'favers' => elgg_echo('plugin_install:sort:favers'),
	),
	'value' => get_input('sort', 'none'),
));
echo '</div>';

echo '<div>';
echo elgg_view('input/submit', array(
	'name' => 'submit',
	'value' => elgg_echo('submit'),
));
echo '</div>';
