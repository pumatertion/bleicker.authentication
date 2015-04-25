<?php
namespace Bleicker\Authentication;

/**
 * Interface TokenManager
 *
 * @package Bleicker\Authentication
 */
interface TokenManagerInterface {

	/**
	 * @param string $alias
	 * @param TokenInterface $token
	 */
	public static function registerToken($alias, TokenInterface $token);

	/**
	 * @param string $alias
	 * @return TokenInterface|NULL
	 */
	public static function getToken($alias);

	/**
	 * @param string $alias
	 * @return boolean
	 */
	public static function hasToken($alias);

	/**
	 * @param string $alias
	 * @return boolean
	 */
	public static function isSession($alias);

	/**
	 * @param string $alias
	 */
	public static function makeSession($alias);

	/**
	 * @param string $alias
	 */
	public static function makePrototype($alias);

	/**
	 * @param string $alias
	 * @return TokenInterface|NULL
	 */
	public function getTokenFromSession($alias);

	/**
	 * @param string $alias
	 * @return boolean
	 */
	public static function hasSessionToken($alias);

	/**
	 * @return array
	 */
	public static function getTokens();
}