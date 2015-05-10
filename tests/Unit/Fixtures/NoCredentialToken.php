<?php

namespace Tests\Bleicker\Authentication\Unit\Fixtures;

use Bleicker\Token\AbstractToken;

/**
 * Class NoCredentialToken
 *
 * @package Tests\Bleicker\Authentication\Unit\Fixtures
 */
class NoCredentialToken extends AbstractToken {

	/**
	 * @return void
	 */
	public function injectCredential() {
	}

	/**
	 * @return boolean
	 */
	public function isCredentialValid() {
		return $this->getCredential() === 'foo';
	}
}
