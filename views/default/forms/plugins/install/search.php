<?php
echo elgg_view('input/text', array(
	'name' => 'q',
	'placeholder' => elgg_echo('srokap_plugin_installer:search:q:placeholder'),
	'value' => get_input('q'),
));