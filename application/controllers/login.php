<?php if (!defined('FARI')) die();

class Login_Controller extends Fari_Controller {

	public static function _desc() { return 'Login, user authentication'; }
	
	public function index($parameter)	{
		// authenticate user if form data POSTed
		if (isset($_POST['username'])
		    && Fari_User::authenticate($_POST['username'], $_POST['password'], $_POST['token'], 'realname')) {
			$user = Fari_User::getCredentials();
			Fari_Message::notify("Welcome $user!");
			$this->redirect('/albums/');
		}
		// create token & display login form
		$this->view->token = Fari_Token::create();
		$this->view->display('login');
	}
	
	public function logout() {
		Fari_User::signOut();
		$this->redirect('/login/');
	}
}
