<?php
$data = get_input('data');
$data = base64_decode($data);
$entity = unserialize($data);

if ($entity instanceof ElggRemotePluginProject) {
	$entity->download();
	system_message(elgg_echo('action:plugin:install:ok'));
} else {
	//invalid param
	register_error(elgg_echo('action:plugin:install:error:param'));
}

forward(REFERER);