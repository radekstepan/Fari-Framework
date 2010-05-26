<?php if (!defined('FARI')) die();

/**
 * User authentication.
 *
 * @package   Application\Presenters
 */
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
                $this->redirectTo('/');
            } else {
                $this->flashFail = 'Sorry, your username or password wasn\'t recognized';
            }
        }

        $this->flashNotify = 'Use \'admin\' for username and password.';
        
		// create token & display login form
		$this->bag->token = Fari_FormToken::create();
		$this->renderAction();
	}

    public function actionLogout() {
        $this->user = new Fari_AuthenticatorSimple();
		$this->user->signOut();
        
        $this->flashSuccess = 'You have been logged out';
        
		$this->renderAction('login');
	}

}
