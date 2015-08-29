<?php
namespace Elgg\Composer\Search;

class Packagist {

	private function getUrl($path) {
		return elgg_http_build_url([
			'scheme' => 'https',
			'host' => 'packagist.org',
			'path' => $path,
		]);
	}

	public function getResults($query, $sort = null, $page = 1) {
		$startTime = microtime(true);
		$orderBys = [];

		if (in_array($sort, ['downloads', 'favers'])) {
			$orderBys[] = [
				'sort' => $sort,
				'order' => 'desc'
			];
		}

		$url = $this->getUrl('/search.json');
		$url = elgg_http_add_url_query_elements($url, [
			'q' => $query,
			'type' => 'elgg-plugin',
			'page' => $page,
			'orderBys' => $orderBys,
		]);

		$rawResult = $this->fetchUrl($url);
		$jsonResult = json_decode($rawResult);
		$jsonResult->timeTotal = microtime(true) - $startTime;
		return $jsonResult;
	}

//	/**
//	 * @param     $query
//	 * @param int $page
//	 * @return mixed
//	 */
//	public function getFullEntities($query, $page = 1) {
//		$results = $this->getResults($query, $sort, $page);
//
//		$entities = [];
//
//		foreach($results->results as $remotePluginRaw) {
//			$url = $this->getUrl('/packages/' . $remotePluginRaw->name . '.json');
//
//			$pluginDetails = $this->fetchUrl($url);
//			$jsonResult = json_decode($pluginDetails);
//
//			if ($jsonResult->package !== null) {
//				$entities[] = new \Elgg\Plugin\RemotePluginEntity($jsonResult->package);
//			}
//		}
//
//		$results->entities = $entities;
//		return $results;
//	}

	/**
	 * @param     $query
	 * @param int $page
	 * @return mixed
	 */
	public function getEntities($query, $sort = null, $page = 1) {
		$startTime = microtime(true);

		$results = $this->getResults($query, $sort, $page);

		$entities = [];

		foreach($results->results as $remotePluginRaw) {
			$entities[] = new \Elgg\Plugin\RemotePluginEntity($remotePluginRaw);
		}

		$results->entities = $entities;
		$results->timeTotal = microtime(true) - $startTime;
		return $results;
	}

	private function fetchUrl($url) {
		$response = '';

		if (ini_get('allow_url_fopen')) {
			$ctx = stream_context_create(array(
				'http' => array(
					'follow_location' => 0,
					'timeout' => 5,
				),
			));
			$response = @file_get_contents($url, null, $ctx);
		}

		if (!$response && function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($ch);
			curl_close($ch);
		}

		return (string)$response;
	}
}