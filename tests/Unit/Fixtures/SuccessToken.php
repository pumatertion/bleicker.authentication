<?php

namespace Tests\Bleicker\Authentication\Unit\Fixtures;

use Bleicker\Account\Account;
use Bleicker\Account\Role;
use Bleicker\Token\AbstractToken;

/**
 * Class SuccessToken
 *
 * @package Tests\Bleicker\Authentication\Unit\Fixtures
 */
class SuccessToken extends AbstractToken {

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
		$role = new Role('Admin');
		$account = new Account('john');
		$account->addRole($role);
		$this->getCredential()->setAccount($account);
		return $this;
	}
}
