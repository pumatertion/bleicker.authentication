<?php

namespace Bleicker\Authentication;

use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Token\TokenManager;
use Bleicker\Token\SessionTokenInterface;
use Bleicker\Token\TokenInterface;

/**
 * Class AuthenticationManager
 *
 * @package Bleicker\Authentication
 */
class AuthenticationManager {

	/**
	 * @return $this
	 */
	public function run() {

		/** @var SessionTokenInterface $token */
		foreach (TokenManager::getSessionTokens() as $token) {
			$token->injectCredentialsAndSetStatus()->authenticate();
		}

		/** @var TokenInterface $token */
		foreach (TokenManager::getPrototypeTokens() as $token) {
			$token->injectCredentialsAndSetStatus()->authenticate();
		}

		return $this;
	}
}
