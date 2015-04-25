<?php

namespace Bleicker\Authentication;

use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Token\TokenManager;
use Bleicker\Token\SessionTokenInterface;
use Bleicker\Token\TokenInterface;
use Bleicker\Token\TokenManagerInterface;

/**
 * Class AuthenticationManager
 *
 * @package Bleicker\Authentication
 */
class AuthenticationManager implements AuthenticationManagerInterface {

	/**
	 * @var TokenManagerInterface
	 */
	protected $tokenManager;

	public function __construct(){
		$this->tokenManager = ObjectManager::get(TokenManagerInterface::class);
	}

	/**
	 * @return TokenManagerInterface
	 */
	public function getTokenManager() {
		return $this->tokenManager;
	}

	/**
	 * @return $this
	 */
	public function run() {

		/** @var SessionTokenInterface $token */
		foreach ($this->tokenManager->getSessionTokens() as $token) {
			$token->injectCredentialsAndSetStatus()->authenticate();
		}

		/** @var TokenInterface $token */
		foreach ($this->tokenManager->getPrototypeTokens() as $token) {
			$token->injectCredentialsAndSetStatus()->authenticate();
		}

		return $this;
	}
}
