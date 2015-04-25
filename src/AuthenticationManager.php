<?php

namespace Bleicker\Authentication;

use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Token\TokenManager;
use Bleicker\Token\SessionTokenInterface;
use Bleicker\Token\PrototypeTokenInterface;
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
			call_user_func_array(array($token, 'injectCredentialsAndSetStatus'), func_get_args());
			$token->authenticate();
		}

		/** @var PrototypeTokenInterface $token */
		foreach ($this->tokenManager->getPrototypeTokens() as $token) {
			call_user_func_array(array($token, 'injectCredentialsAndSetStatus'), func_get_args());
			$token->authenticate();
		}

		return $this;
	}
}
