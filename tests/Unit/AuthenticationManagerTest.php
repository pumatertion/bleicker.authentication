<?php

namespace Tests\Bleicker\Authentication\Unit;

use Bleicker\Authentication\AuthenticationManager;
use Bleicker\Authentication\AuthenticationManagerInterface;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Token\TokenInterface;
use Tests\Bleicker\Authentication\Unit\Fixtures\FailingToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\NoCredentialToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\SuccessToken;
use Tests\Bleicker\Authentication\UnitTestCase;

/**
 * Class AuthenticationManagerTest
 *
 * @package Tests\Bleicker\Authentication\Unit
 */
class AuthenticationManagerTest extends UnitTestCase {

	/**
	 * @var AuthenticationManagerInterface
	 */
	protected $authenticationManager;

	protected function setUp() {
		parent::setUp();
		$this->authenticationManager = ObjectManager::get(AuthenticationManagerInterface::class, function () {
			$authenticationManager = new AuthenticationManager();
			ObjectManager::add(AuthenticationManagerInterface::class, $authenticationManager, TRUE);
			return $authenticationManager;
		});
	}

	/**
	 * @test
	 */
	public function runTest() {
		$successToken = SuccessToken::register(SuccessToken::class);
		$noCredentialToken = NoCredentialToken::register(NoCredentialToken::class);
		$failingToken = FailingToken::register(FailingToken::class);

		$this->authenticationManager->run();

		$this->assertEquals(TokenInterface::AUTHENTICATION_SUCCESS, $successToken->getStatus());
		$this->assertEquals(TokenInterface::AUTHENTICATION_NOT_REQUIRED, $noCredentialToken->getStatus());
		$this->assertEquals(TokenInterface::AUTHENTICATION_FAILED, $failingToken->getStatus());
	}
}
