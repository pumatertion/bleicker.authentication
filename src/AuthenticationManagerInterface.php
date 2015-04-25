<?php
namespace Bleicker\Authentication;

use Bleicker\Token\TokenManagerInterface;

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
	 * @return TokenManagerInterface
	 */
	public function getTokenManager();
}
