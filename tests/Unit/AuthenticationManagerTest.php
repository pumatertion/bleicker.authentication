<?php

namespace Tests\Bleicker\Authentication\Unit;

use Bleicker\Authentication\AuthenticationManager;
use Bleicker\Token\PrototypeTokenInterface;
use Bleicker\Token\TokenManager;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Session\Session;
use Bleicker\Session\SessionInterface;
use Bleicker\Token\TokenManagerInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Tests\Bleicker\Authentication\Unit\Fixtures\FailingToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\NoCredentialsToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\SuccessSessionToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\SuccessToken;
use Tests\Bleicker\Authentication\UnitTestCase;

/**
 * Class AuthenticationManagerTest
 *
 * @package Tests\Bleicker\Authentication\Unit
 */
class AuthenticationManagerTest extends UnitTestCase {

	/**
	 * @var SessionInterface
	 */
	protected $session;

	protected function setUp() {
		parent::setUp();
		ObjectManager::register(SessionInterface::class, new Session(new MockArraySessionStorage()));
		ObjectManager::register(TokenManagerInterface::class, new TokenManager());
	}

	/**
	 * @test
	 */
	public function runTest() {
		$authenticationManager = new AuthenticationManager();
		$authenticationManager->getTokenManager()->registerPrototypeToken(SuccessToken::class, new SuccessToken());
		$authenticationManager->getTokenManager()->registerPrototypeToken(FailingToken::class, new FailingToken());
		$authenticationManager->getTokenManager()->registerPrototypeToken(NoCredentialsToken::class, new NoCredentialsToken());
		$authenticationManager->getTokenManager()->registerSessionToken(SuccessSessionToken::class, new SuccessSessionToken());

		$authenticationManager->run();

		$this->assertEquals(PrototypeTokenInterface::AUTHENTICATION_SUCCESS, $authenticationManager->getTokenManager()->getPrototypeToken(SuccessToken::class)->getStatus(), 'Authentication Success');
		$this->assertEquals(PrototypeTokenInterface::AUTHENTICATION_FAILED, $authenticationManager->getTokenManager()->getPrototypeToken(FailingToken::class)->getStatus(), 'Authentication Failed');
		$this->assertEquals(PrototypeTokenInterface::AUTHENTICATION_NOCREDENTIALSGIVEN, $authenticationManager->getTokenManager()->getPrototypeToken(NoCredentialsToken::class)->getStatus(), 'No credentials given');
		$this->assertEquals(PrototypeTokenInterface::AUTHENTICATION_SUCCESS, $authenticationManager->getTokenManager()->getSessionToken(SuccessSessionToken::class)->getStatus(), 'Authentication Failed');
	}
}
