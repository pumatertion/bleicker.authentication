<?php

namespace Bleicker\Authentication;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class TokenManager
 *
 * @package Bleicker\Authentication
 */
class TokenManager implements TokenManagerInterface {

	/**
	 * @var array
	 */
	public static $tokens = [], $sessionTokens = [];

	/**
	 * @param string $alias
	 * @param TokenInterface $token
	 */
	public static function registerToken($alias, TokenInterface $token) {
		static::$tokens[$alias] = $token;
	}

	/**
	 * @param string $alias
	 * @return TokenInterface|NULL
	 */
	public static function getToken($alias) {
		if (static::isSession($alias)) {
			return static::getTokenFromSession($alias);
		}
		if (static::hasToken($alias)) {
			return static::$tokens[$alias];
		}
		return NULL;
	}

	/**
	 * @param string $alias
	 * @return TokenInterface|NULL
	 * @todo Implement Session Handling
	 */
	public function getTokenFromSession($alias) {
		if (static::hasToken($alias)) {
			return static::$tokens[$alias];
		}
		return NULL;
	}

	/**
	 * @param string $alias
	 * @return boolean
	 */
	public static function hasToken($alias) {
		return array_key_exists($alias, static::$tokens);
	}

	/**
	 * @param string $alias
	 * @return boolean
	 * @todo Implement Session Handling
	 */
	public static function hasSessionToken($alias) {
		return array_key_exists($alias, static::$tokens);
	}

	/**
	 * @param string $alias
	 */
	public static function makeSession($alias) {
		static::$sessionTokens[$alias] = TRUE;
	}

	/**
	 * @param string $alias
	 * @return boolean
	 */
	public static function isSession($alias) {
		return array_key_exists($alias, static::$sessionTokens);
	}

	/**
	 * @param string $alias
	 */
	public static function makePrototype($alias) {
		if (static::isSession($alias)) {
			unset(static::$sessionTokens[$alias]);
		}
	}

	/**
	 * @return array
	 */
	public static function getTokens() {
		return static::$tokens;
	}
}
