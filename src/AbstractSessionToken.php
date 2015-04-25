<?php

namespace Bleicker\Authentication;

/**
 * Class AbstractToken
 *
 * @package Bleicker\Authentication
 */
abstract class AbstractSessionToken extends AbstractToken implements SessionTokenInterface {

	/**
	 * String representation of object
	 *
	 * @link http://php.net/manual/en/serializable.serialize.php
	 * @return string the string representation of the object or null
	 */
	public function serialize() {
		return $this->getStatus();
	}

	/**
	 * Constructs the object
	 *
	 * @link http://php.net/manual/en/serializable.unserialize.php
	 * @param string $serialized
	 * @return void
	 */
	public function unserialize($serialized) {
		$this->status = $serialized;
	}
}
