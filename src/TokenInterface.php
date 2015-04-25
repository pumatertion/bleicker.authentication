<?php

namespace Bleicker\Authentication;

/**
 * Interface TokenInterface
 *
 * @package Bleicker\Authentication
 */
interface TokenInterface {

	const AUTHENTICATION_NOCREDENTIALSGIVEN = 'authenticationNoCredentialsGiven',
		AUTHENTICATION_REQUIRED = 'authenticationRequired',
		AUTHENTICATION_FAILED = 'authenticationFailed',
		AUTHENTICATION_SUCCESS = 'authenticationSuccess';

	/**
	 * @return $this
	 */
	public function injectCredentialsAndSetStatus();

	/**
	 * @return mixed
	 */
	public function getCredentials();

	/**
	 * @return string
	 */
	public function getStatus();

	/**
	 * @return $this
	 */
	public function authenticate();
}
