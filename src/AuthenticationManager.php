<?php

namespace Bleicker\Authentication;

use Bleicker\ObjectManager\ObjectManager;

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
		/** @var TokenInterface $token */
		foreach (TokenManager::getTokens() as $token) {
			$token->injectCredentialsAndSetStatus()->authenticate();
		}
		return $this;
	}
}
