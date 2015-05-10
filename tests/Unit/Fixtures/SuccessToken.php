<?php

namespace Tests\Bleicker\Authentication\Unit\Fixtures;

use Bleicker\Token\AbstractToken;

/**
 * Class SuccessToken
 *
 * @package Tests\Bleicker\Authentication\Unit\Fixtures
 */
class SuccessToken extends AbstractToken {

	/**
	 * @return void
	 */
	public function injectCredential() {
		$this->credential = 'foo';
	}

	/**
	 * @return boolean
	 */
	public function isCredentialValid() {
		return $this->getCredential() === 'foo';
	}
}
