<?php
namespace Bleicker\Authentication;

use Bleicker\Token\TokensInterface;

/**
 * Interface AuthenticationManager
 *
 * @package Bleicker\Authentication
 */
interface AuthenticationManagerInterface {

	/**
	 * @return $this
	 */
	public function run();

	/**
	 * @return TokensInterface
	 */
	public function getTokens();
}
