<?php

namespace Tests\Bleicker\Authentication\Unit\Fixtures;

use Bleicker\Token\AbstractSessionToken;

/**
 * Class SuccessSessionToken
 *
 * @package Tests\Bleicker\Authentication\Unit\Fixtures
 */
class SuccessSessionToken extends AbstractSessionToken {

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
		$this->credentials = 'foo';
		$this->status = self::AUTHENTICATION_REQUIRED;
		return $this;
	}
}
