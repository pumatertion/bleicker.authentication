<?php

namespace Tests\Bleicker\Authentication\Unit\Fixtures;

use Bleicker\Token\AbstractPrototypeToken;

/**
 * Class NoCredentialsToken
 *
 * @package Tests\Bleicker\Authentication\Unit\Fixtures
 */
class NoCredentialsToken extends AbstractPrototypeToken {

	/**
	 * @return $this
	 */
	public function authenticate() {

		if ($this->getStatus() === self::AUTHENTICATION_SUCCESS || $this->getStatus() !== self::AUTHENTICATION_REQUIRED) {
			return $this;
		}

		if ($this->getCredentials() === 'foo') {
			$this->status = self::AUTHENTICATION_SUCCESS;
			return $this;
		}

		$this->status = self::AUTHENTICATION_FAILED;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function injectCredentialsAndSetStatus() {
		$this->status = self::AUTHENTICATION_NOCREDENTIALSGIVEN;
		return $this;
	}
}
