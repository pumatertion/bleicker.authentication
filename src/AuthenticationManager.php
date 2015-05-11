<?php

namespace Bleicker\Authentication;

use Bleicker\Account\AccountInterface;
use Bleicker\Account\RoleInterface;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Token\TokenInterface;
use Bleicker\Token\Tokens;
use Bleicker\Token\TokensInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class AuthenticationManager
 *
 * @package Bleicker\Authentication
 */
class AuthenticationManager implements AuthenticationManagerInterface {

	/**
	 * @var TokensInterface
	 */
	protected $tokens;

	public function __construct() {
		$this->tokens = ObjectManager::get(TokensInterface::class, function () {
			$tokens = new Tokens();
			ObjectManager::add(TokensInterface::class, $tokens, TRUE);
			return $tokens;
		});
	}

	/**
	 * @return Collection
	 */
	public function getTokens() {
		return new ArrayCollection($this->tokens->storage());
	}

	/**
	 * @return Collection
	 */
	public function getAccounts() {
		$accounts = new ArrayCollection();
		/** @var TokenInterface $token */
		foreach($this->getTokens() as $token){
			if ($token->getCredential()->getAccount() !== NULL) {
				$accounts->add($token->getCredential()->getAccount());
			}
		}
		return $accounts;
	}

	/**
	 * @return Collection
	 */
	public function getRoles() {
		$roles = new ArrayCollection();
		/** @var AccountInterface $account */
		foreach($this->getAccounts() as $account){
			/** @var RoleInterface $role */
			foreach($account->getRoles() as $role){
				if (!$roles->contains($role)) {
					$roles->add($role);
				}
			}
		}
		return $roles;
	}

	/**
	 * @return $this
	 */
	public function run() {
		/** @var TokenInterface $token */
		foreach ($this->tokens->storage() as $token) {
			$token->authenticate();
		}
		return $this;
	}
}
