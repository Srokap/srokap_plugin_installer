<?php
$query = get_input('q');
$limit = 20;

$mt = microtime(true);
$batch = srokap_plugin::getPluginsSearchBatch(array(
	'q' => $query,
));

$cnt = 0;
$results = array();
foreach($batch as $plugin) {
	$results[] = $plugin;
	$cnt++;
	if ($cnt>=$limit) {
		break;
	}
}

echo '<p>';
echo 'Search query: <strong>'.$query.'</strong><br/>';
echo 'Time taken: <strong>'.sprintf("%.2f", microtime(true)-$mt).'s</strong>';
echo '</p>';

if (!$cnt) {
	echo '<p>'.elgg_echo('notfound').'</p>';
} else {
	var_dump($results);
}
