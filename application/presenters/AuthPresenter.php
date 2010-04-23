<?php if (!defined('FARI')) die();



class AuthPresenter extends Fari_ApplicationPresenter {

    /** @var Fari_AuthenticatorSimple */
    private $user;
	
	public function actionIndex($p) { }

	public function actionLogin() {
        // authenticate user if form data POSTed
        if ($this->request->getPost('username')) {
            $username = Fari_Decode::accents($this->request->getPost('username'));
            $password = Fari_Decode::accents($this->request->getPost('password'));
            
            $this->user = new Fari_AuthenticatorSimple();
		    if ($this->user->authenticate($username, $password, $this->request->getPost('token'))) {
                $this->response->redirect('/');
            } else {
                Fari_Message::fail('Sorry, your username or password wasn\'t recognized');
            }
        }

        Fari_Message::notify('Use \'admin\' for username and password.');
        $this->bag->messages = Fari_Message::get();
        
		// create token & display login form
		$this->bag->token = Fari_FormToken::create();
		$this->render('login');
	}

    public function actionLogout() {
        $this->user = new Fari_AuthenticatorSimple();
		$this->user->signOut();
        
        Fari_Message::success('You have been logged out');
        Fari_Message::get();
        
		$this->render('login');
	}

}
