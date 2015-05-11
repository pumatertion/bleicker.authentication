<?php

namespace Tests\Bleicker\Authentication\Unit\Fixtures;

use Bleicker\Account\Account;
use Bleicker\Account\AccountInterface;
use Bleicker\Account\Role;
use Bleicker\Token\AbstractSessionToken;

/**
 * Class SessionExistsToken
 *
 * @package Tests\Bleicker\Authentication\Unit\Fixtures
 */
class SessionExistsToken extends AbstractSessionToken {

	/**
	 * @return $this
	 */
	public function injectCredential() {
		return $this;
	}

	/**
	 * @return $this
	 */
	public function fetchAndSetAccount() {
		return $this;
	}

	/**
	 * @return AccountInterface
	 */
	public function reconstituteAccountFromSession() {
		$role = new Role('RoleBySession');
		$account = new Account('AccountBySession');
		$account->addRole($role);
		return $account;
	}
}
