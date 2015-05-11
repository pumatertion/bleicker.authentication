<?php
namespace Bleicker\Authentication;

use Doctrine\Common\Collections\Collection;

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
	 * @return Collection
	 */
	public function getTokens();

	/**
	 * @return Collection
	 */
	public function getAccounts();

	/**
	 * @return Collection
	 */
	public function getRoles();
}
