<?php
namespace Elgg\Plugin;


class RemotePluginEntity extends \ElggObject {

	/**
	 * @see ElggObject::initializeAttributes()
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "remote_plugin_project";
		$this->attributes['access_id'] = ACCESS_PUBLIC;
	}

	public function __construct($properties) {
		parent::__construct();

		$blacklist = [
			'type',
			'subtype',
		];

		foreach($properties as $key => $property) {
			if (!in_array($key, $blacklist)) {
				if (isset($this->attributes[$key])) {
					$this->attributes[$key] = $property;
				} else {
					$this->{$key} = $property;
				}
			}
		}
	}

	private function getDetails() {

	}

	public function getURL() {
		return 'https://packagist.org/packages/' . $this->name;
	}

	/**
	 * Careful, this returns REMOTE guid, not local one.
	 * @return int|bool plugin project guid or false on failure
	 */
	public function getGUID() {
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
}