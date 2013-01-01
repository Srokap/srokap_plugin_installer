<?php
$data = get_input('data');
$data = base64_decode($data);
$entity = unserialize($data);

if ($entity instanceof ElggRemotePluginProject) {
	$url = $entity->getDownloadURL();
	if ($url) {
		forward($url);
	} else {
		//unable to determine download url
		register_error(elgg_echo('action:plugin:download:error:no_download_url', array($entity->getURL())));
	}
} else {
	//invalid param
	register_error(elgg_echo('action:plugin:download:error:param'));
}

forward(REFERER);