## Usage ##

### TokenManager ###
The AuthenticationManager requires a TokenManager. Just register your own or use the default TokenManager:

	ObjectManager::register(TokenManagerInterface::class, new TokenManager());

### AuthenticationManager ###
Creating AuthenticationManager Instance:

	$authenticationManager = new AuthenticationManager();

#### Register a prototype token ####
Authentication state lives as long as runtime.
	
	$authenticationManager->getTokenManager()->registerPrototypeToken(MyPrototypeToken::class, new MyPrototypeToken());

#### Register a session token ####
Authentication state will exists along the runtime.
	
	$authenticationManager->getTokenManager()->registerSessionToken(MySessioinToken::class, new MySessioinToken());

#### Getting authentication state of a Token ####

	$authenticationManager->getTokenManager()->getToken(MyPrototypeToken::class)->status();

### Run Authentication ###
Run the authentication. In this case any registered Token tries to authenticate.

	$authenticationManager->run();
	