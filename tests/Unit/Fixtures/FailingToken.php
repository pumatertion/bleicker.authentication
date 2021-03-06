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
	 * @return $this
	 */
	public function injectCredential() {
		$this->getCredential()->setValue('foo');
		return $this;
	}

	/**
	 * @return $this
	 */
	public function fetchAndSetAccount() {
		$this->getCredential()->setAccount();
		return $this;
	}
}
