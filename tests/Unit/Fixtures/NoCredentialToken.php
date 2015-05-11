<?php

namespace Tests\Bleicker\Authentication\Unit\Fixtures;

use Bleicker\Account\Account;
use Bleicker\Token\AbstractToken;

/**
 * Class NoCredentialToken
 *
 * @package Tests\Bleicker\Authentication\Unit\Fixtures
 */
class NoCredentialToken extends AbstractToken {

	/**
	 * @return $this
	 */
	public function injectCredential() {
		$this->getCredential()->setValue();
		return $this;
	}

	/**
	 * @return $this
	 */
	public function fetchAndSetAccount() {
		$this->getCredential()->setAccount(new Account('john'));
		return $this;
	}
}
