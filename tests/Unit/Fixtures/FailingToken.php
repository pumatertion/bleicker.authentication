<?php

namespace Tests\Bleicker\Authentication\Unit\Fixtures;

use Bleicker\Token\AbstractToken;

/**
 * Class FailingToken
 *
 * @package Tests\Bleicker\Authentication\Unit\Fixtures
 */
class FailingToken extends AbstractToken {

	/**
	 * @return void
	 */
	public function injectCredential() {
		$this->credential = 'bar';
	}

	/**
	 * @return boolean
	 */
	public function isCredentialValid() {
		return $this->getCredential() === 'foo';
	}
}
