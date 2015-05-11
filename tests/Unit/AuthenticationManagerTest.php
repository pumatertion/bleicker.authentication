<?php

namespace Tests\Bleicker\Authentication\Unit;

use Bleicker\Account\AccountInterface;
use Bleicker\Authentication\AuthenticationManager;
use Bleicker\Authentication\AuthenticationManagerInterface;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Token\TokenInterface;
use Bleicker\Token\Tokens;
use Tests\Bleicker\Authentication\Unit\Fixtures\FailingToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\NoCredentialToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\SessionExistsToken;
use Tests\Bleicker\Authentication\Unit\Fixtures\SessionNotExistsToken;
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
		Tokens::prune();
	}

	protected function tearDown() {
		parent::tearDown();
		Tokens::prune();
	}

	/**
	 * @test
	 */
	public function authenticationTest() {
		$successToken = SuccessToken::register(SuccessToken::class);
		$noCredentialToken = NoCredentialToken::register(NoCredentialToken::class);
		$failingToken = FailingToken::register(FailingToken::class);
		$reconstructedBySessionToken = SessionExistsToken::register(SessionExistsToken::class);
		$notReconstructedBySessionToken = SessionNotExistsToken::register(SessionNotExistsToken::class);

		$this->authenticationManager->run();

		$this->assertEquals(TokenInterface::AUTHENTICATION_SUCCESS, $successToken->getStatus());
		$this->assertEquals(TokenInterface::AUTHENTICATION_NOT_REQUIRED, $noCredentialToken->getStatus());
		$this->assertEquals(TokenInterface::AUTHENTICATION_FAILED, $failingToken->getStatus());
		$this->assertEquals(TokenInterface::AUTHENTICATION_SUCCESS, $reconstructedBySessionToken->getStatus());
		$this->assertEquals(TokenInterface::AUTHENTICATION_NOT_REQUIRED, $notReconstructedBySessionToken->getStatus());

		$this->assertInstanceOf(AccountInterface::class, $successToken->getCredential()->getAccount());
		$this->assertInstanceOf(AccountInterface::class, $reconstructedBySessionToken->getCredential()->getAccount());
		$this->assertNull($noCredentialToken->getCredential()->getAccount());
		$this->assertNull($failingToken->getCredential()->getAccount());
		$this->assertNull($notReconstructedBySessionToken->getCredential()->getAccount());

		$this->assertEquals(2, $this->authenticationManager->getAccounts()->count());
		$this->assertEquals('john', $this->authenticationManager->getAccounts()->first()->getIdentity());
		$this->assertEquals('AccountBySession', $this->authenticationManager->getAccounts()->next()->getIdentity());

		$this->assertEquals(2, $this->authenticationManager->getRoles()->count());
		$this->assertEquals('Admin', $this->authenticationManager->getRoles()->first()->getName());
		$this->assertEquals('RoleBySession', $this->authenticationManager->getRoles()->next()->getName());

		$this->assertTrue($this->authenticationManager->hasRole('Admin'));
		$this->assertTrue($this->authenticationManager->hasRole('RoleBySession'));
	}

	/**
	 * @test
	 */
	public function logoutTokensTest() {
		$successToken = SuccessToken::register(SuccessToken::class);
		$noCredentialToken = NoCredentialToken::register(NoCredentialToken::class);
		$failingToken = FailingToken::register(FailingToken::class);
		$reconstructedBySessionToken = SessionExistsToken::register(SessionExistsToken::class);
		$notReconstructedBySessionToken = SessionNotExistsToken::register(SessionNotExistsToken::class);

		$this->authenticationManager->run();
		$this->assertTrue($this->authenticationManager->hasRole('Admin'));
		$this->assertTrue($this->authenticationManager->hasRole('RoleBySession'));

		$this->authenticationManager
			->logout($successToken)
			->logout($noCredentialToken)
			->logout($failingToken)
			->logout($reconstructedBySessionToken)
			->logout($notReconstructedBySessionToken);

		$this->assertFalse($this->authenticationManager->hasRole('Admin'));
		$this->assertFalse($this->authenticationManager->hasRole('RoleBySession'));
	}
}
