<?php
/**
 * This is class for logical representation of remote plugin projects. 
 * We don't expect them to be saved to DB, so save-related methods are overriden.
 */
class ElggRemotePluginProject extends ElggObject {
	
	/**
	 * @see ElggObject::initializeAttributes()
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "remote_plugin_project";
		$this->attributes['access_id'] = ACCESS_PUBLIC;
	}
	
	/**
	 * @see ElggEntity::getURL()
	 */
	public function getURL() {
		return $this->rssGuid;
	}
	
	/**
	 * @var int|null cache for plugin project guid
	 * @see ElggRemotePluginProject::getGUID()
	 */
	private $guid;
	
	/**
	 * Careful, this returns REMOTE guid, not local one.
	 * @return int|bool plugin project guid or false on failure
	 */
	public function getGUID() {
		if ($guid!==null) {
			return $guid;
		}
		$guid = false;
		if (preg_match('#'.srokap_plugin::getCommunityPageURL().'plugins/([0-9]*)/#', $this->rssGuid, $matches)) {
			$guid = $matches[1];
		}
		return $guid;
	}

	/**
	 * Determining direct download URL is heavy operation, we delegate it to action.
	 */
	public function getDownloadActionURL() {
		$data = base64_encode(serialize($this));
		$url = elgg_get_config('wwwroot').'action/plugin/download';
		$url = elgg_http_add_url_query_elements($url, array(
			'data' => $data,
		));
		$url = elgg_add_action_tokens_to_url($url);
		return $url;
	}
	
	/**
	 * Warning, it's high cost method. You shouldn't use it multiple times.
	 * @return srting|bool URL or false on failure
	 */
	public function getDownloadURL() {
		$result = false;
		if ($this->getGUID()) {
			$url = srokap_plugin::getCommunityPageURL().'export/default/'.$this->getGUID();
			$content = srokap_http::getUrl($url);
			if ($content) {
				//var_dump($content);
				if (preg_match('#recommended_release_guid:\s*</b>\s*([0-9]*)#', $content, $matches)) {
					$result = srokap_plugin::getCommunityPageURL().'plugins/download/'.$matches[1];
				}
			}
		}
		return $result;
	}
	
	/**
	 * Some URLs are missing version and go to redirection loop. We try to check here if URL looks fine.
	 */
	public function validateURL() {
		$url = $this->getURL();
		if (preg_match('#'.srokap_plugin::getCommunityPageURL().'plugins/([0-9]*)/([^/]+)/#', $url, $matches)) {
			return true;
		}
		return false;
	} 

	/**
	 * Overrides core functionality for read-only purposes
	 */
	public function canComment($user_guid = 0) {
		return false;
	}

	/**
	 * Overrides core functionality for read-only purposes
	 */
	public function getMetaData($name) {
		return $this->getVolatileData($name);
	}
	
	/**
	 * Overrides core functionality for read-only purposes
	 */
	public function setMetaData($name, $value, $value_type = null, $multiple = false) {
		return $this->setVolatileData($name, $value);
	}
	
	/**
	 * Overrides core functionality for read-only purposes
	 */
	public function save() {
		throw new IOException(get_class($this)." is read only and cannot be saved to DB");
	}
	
	/**
	 * Fill object with the data from RSS feed item.
	 * @param stdClass $item
	 */
	public function loadFromRss($item) {
		$this->title = (string)$item->title;
		$description = trim((string)$item->description);
		if (empty($description)) {
			$this->description = elgg_echo('srokap_plugin_installer:no_description');
		} else {
			$this->description = $description;
		}
		$this->rssGuid = (string)$item->guid;
		$this->rssLink = (string)$item->link;
		$this->attributes['time_created'] = strtotime($item->pubDate);
	}
}