<?php
$query = get_input('q');
$sort = get_input('sort', 'relevance');
$order = get_input('order');
$limit = 20;

$mt = microtime(true);
$batch = srokap_plugin::getPluginsSearchBatch(array(
	'q' => $query,
	'sort' => $sort,
	'order' => $order,
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
if ($query) {
	echo elgg_echo('srokap_plugin_installer:search:query', array($query)).'<br/>';
}
if ($sort) {
	echo elgg_echo('srokap_plugin_installer:search:sort', array(elgg_echo('search:sort:by:'.$sort))).'<br/>';
}
echo elgg_echo('srokap_plugin_installer:search:time', array(sprintf("%.2f", microtime(true)-$mt)));
echo '</p>';

if (!$cnt) {
	echo '<p>'.elgg_echo('notfound').'</p>';
} else {
	//TODO better display
	var_dump($results);
}
