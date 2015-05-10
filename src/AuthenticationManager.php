<?php

namespace Bleicker\Authentication;

use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Token\TokensInterface;
use Bleicker\Token\Tokens;
use Bleicker\Token\TokenInterface;
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

	public function __construct(){
		$this->tokens = ObjectManager::get(TokensInterface::class, function(){
			$tokens = new Tokens();
			ObjectManager::add(TokensInterface::class, $tokens, TRUE);
			return $tokens;
		});
	}

	/**
	 * @return TokensInterface
	 */
	public function getTokens() {
		return $this->tokens;
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
