<?php

$query = get_input('q');
$sort = get_input('sort');

$url = elgg_get_site_url();

$url .= 'admin/plugins/install';
$url = elgg_http_add_url_query_elements($url, [
	'q' => $query,
	'sort' => $sort,
]);

forward($url);
