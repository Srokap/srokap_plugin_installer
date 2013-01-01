<?php
$query = get_input('q');
$sort = get_input('sort', 'created');
$order = get_input('order');
$limit = 10;

$mt = microtime(true);
$batch = srokap_plugin::getPluginsSearchBatch(array(
	'q' => $query,
	'sort' => $sort,
	'order' => $order,
	'limit' => $limit,
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

$options = array(
	'limit' => 0,
	'full_view' => false,
	'list_type_toggle' => false,
	'pagination' => false,
);
$list = elgg_view_entity_list($results, $options);

$time = microtime(true)-$mt;

echo '<p>';
if ($query) {
	echo elgg_echo('srokap_plugin_installer:search:query', array($query)).'<br/>';
}
if ($sort) {
	echo elgg_echo('srokap_plugin_installer:search:sort', array(elgg_echo('search:sort:by:'.$sort))).'<br/>';
}
echo elgg_echo('srokap_plugin_installer:search:time', array(sprintf("%.2f", $time)));
echo '</p>';

if (!$cnt) {
	echo '<p>'.elgg_echo('notfound').'</p>';
} else {
	echo $list;
}
