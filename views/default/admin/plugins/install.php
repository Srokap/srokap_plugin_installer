<?php

//$composerCommand = dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/bin/composer';

$query = get_input('q', '');
$itemsPerPage = 15;
$offset = get_input('offset');
$page = $offset ? ($offset / $itemsPerPage) + 1 : 1;
$sort = get_input('sort');

$packagist = new Elgg\Composer\Search\Packagist();

//$results = $packagist->getResults($query, $page);
$results = $packagist->getEntities($query, $sort, $page);
//$results = $packagist->getFullEntities('', $page);

//echo '<pre>';
//var_dump($results);
////passthru($composerCommand . ' search test');
//echo '</pre>';
//
//$items = [];
//
//foreach($results->results as $remotePluginRaw) {
//	$items[] = new \Elgg\Plugin\RemotePluginEntity($remotePluginRaw);
//}

//echo '<pre>';
//var_dump($results);
//echo '</pre>';

echo elgg_view_module('main', elgg_echo('search'), elgg_view_form('admin/plugins/install/search', [
	'action' => elgg_normalize_url('admin/plugins/install'),
	'method' => 'get',
	'disable_security' => true,
]));

echo '<p class="mtl mbl"><strong>' . $results->total
	. '</strong> results for query: <strong>'
	. $query . '</strong></p>';

echo elgg_view('page/components/list', [
	'items' => $results->entities,
	'count' => $results->total,
	'limit' => $itemsPerPage,
	'offset' => $itemsPerPage * ($page - 1),
	'no_results' => elgg_echo('plugin_installer:no_results')
]);

echo '<span>' . elgg_echo('plugin_installer:request_time', [$results->timeTotal]) . '</span>';
