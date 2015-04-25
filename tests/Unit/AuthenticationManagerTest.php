<?php

namespace Tests\Bleicker\Authentication\Unit;

use Bleicker\Authentication\AuthenticationManager;
use Bleicker\Authentication\TokenInterface;
use Bleicker\Authentication\TokenManager;
use Tests\Bleicker\Authentication\Unit\Fixtures\FailingToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\SuccessToken;
use Tests\Bleicker\Authentication\UnitTestCase;

/**
 * Class AuthenticationManagerTest
 *
 * @package Tests\Bleicker\Authentication\Unit
 */
class AuthenticationManagerTest extends UnitTestCase {

	/**
	 * @test
	 */
	public function runTest() {
		TokenManager::registerToken(SuccessToken::class, new SuccessToken());
		TokenManager::registerToken(FailingToken::class, new FailingToken());

		$authenticationManager = new AuthenticationManager();
		$authenticationManager->run();

		$this->assertEquals(TokenInterface::AUTHENTICATION_SUCCESS, TokenManager::getToken(SuccessToken::class)->getStatus(), 'Authentication Success');
		$this->assertEquals(TokenInterface::AUTHENTICATION_FAILED, TokenManager::getToken(FailingToken::class)->getStatus(), 'Authentication Failed');
	}
}
