<?php

namespace Tests\Bleicker\Authentication\Unit;

use Bleicker\Authentication\TokenManager;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Session\Session;
use Tests\Bleicker\Authentication\Unit\Fixtures\FailingToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\SuccessToken;
use Tests\Bleicker\Authentication\UnitTestCase;
use Tests\Bleicker\Authentication\Unit\Fixtures\SuccessSessionToken;
use Bleicker\Session\SessionInterface;

/**
 * Class TokenManagerTest
 *
 * @package Tests\Bleicker\Authentication\Unit
 */
class TokenManagerTest extends UnitTestCase {

	/**
	 * @test
	 */
	public function addTokenTest() {
		$tokenManager = new TokenManager();
		$tokenManager->registerToken('foo', new SuccessToken());
		TokenManager::registerToken('bar', new FailingToken());
		$this->assertTrue($tokenManager->hasToken('foo'));
		$this->assertTrue($tokenManager->hasToken('bar'));
		$this->assertTrue(TokenManager::hasToken('foo'));
		$this->assertTrue(TokenManager::hasToken('bar'));
		$this->assertInstanceOf(SuccessToken::class, $tokenManager->getToken('foo'));
		$this->assertInstanceOf(FailingToken::class, $tokenManager->getToken('bar'));
		$this->assertInstanceOf(SuccessToken::class, TokenManager::getToken('foo'));
		$this->assertInstanceOf(FailingToken::class, TokenManager::getToken('bar'));
	}

	/**
	 * @test
	 */
	public function addSessionToken(){
		ObjectManager::register(SessionInterface::class, new Session());
		TokenManager::registerToken(SuccessSessionToken::class, new SuccessSessionToken());
		$this->assertTrue(TokenManager::hasToken(SuccessSessionToken::class));
	}
}
