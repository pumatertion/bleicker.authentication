<?php

namespace Tests\Bleicker\Authentication\Unit;

use Bleicker\Authentication\AuthenticationManager;
use Bleicker\Token\TokenInterface;
use Bleicker\Token\TokenManager;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Session\Session;
use Bleicker\Session\SessionInterface;
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
		$this->session = ObjectManager::get(SessionInterface::class);
	}

	/**
	 * @test
	 */
	public function runTest() {
		TokenManager::registerPrototypeToken(SuccessToken::class, new SuccessToken());
		TokenManager::registerPrototypeToken(FailingToken::class, new FailingToken());
		TokenManager::registerPrototypeToken(NoCredentialsToken::class, new NoCredentialsToken());
		TokenManager::registerSessionToken(SuccessSessionToken::class, new SuccessSessionToken());

		$authenticationManager = new AuthenticationManager();
		$authenticationManager->run();

		$this->assertEquals(TokenInterface::AUTHENTICATION_SUCCESS, TokenManager::getPrototypeToken(SuccessToken::class)->getStatus(), 'Authentication Success');
		$this->assertEquals(TokenInterface::AUTHENTICATION_FAILED, TokenManager::getPrototypeToken(FailingToken::class)->getStatus(), 'Authentication Failed');
		$this->assertEquals(TokenInterface::AUTHENTICATION_NOCREDENTIALSGIVEN, TokenManager::getPrototypeToken(NoCredentialsToken::class)->getStatus(), 'No credentials given');
		$this->assertEquals(TokenInterface::AUTHENTICATION_SUCCESS, TokenManager::getSessionToken(SuccessSessionToken::class)->getStatus(), 'Authentication Failed');
	}
}
