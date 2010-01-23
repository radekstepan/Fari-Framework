<?php if (!defined('FARI')) die();

class Albums_Controller extends Fari_Controller {

	public static function _desc() { return 'Akrabat and a test of db connection'; }
	
	public function _init() {
		// is user authenticated?
		if (!Fari_User::isAuthenticated('realname')) $this->redirect('/login/');
		
		// get user's credentials
		$this->view->user = Fari_User::getCredentials();
		
		// get messages for us
		$this->view->messages = Fari_Message::get();
	}
	
	public function index($pageRequested) {
                // setup a new paginator with 8 items per page and +/- 3 page links in paginator
		$albums = new Fari_Paginator(8, 3);
		
		// use paginator to display items on a page passed as the first parameter
		$this->view->paginator = $albums->select($pageRequested, 'albums', 'id, title, artist');
		
		$this->view->display('albums');
	}
	
	public function add() {
		if (isset($_POST['artist'])) {
			// add album, message will be stored in the session
			Albums::add($_POST['artist'], $_POST['title']);
			$this->redirect('/albums/index/'); // redirect back to the listing
		}
		
		$this->view->display('add');
	}
	
	public function edit($albumId) {
		if (isset($_POST['artist'])) {
			// edit album, message will be stored in the session
			Albums::edit($albumId, $_POST['artist'], $_POST['title']);
			$this->redirect('/albums/index/'); // redirect back to the listing
		}
		
		// load existing album
		$this->view->album = Albums::get($albumId);
		
		$this->view->display('edit');
	}
	
	public function delete($albumId) {
		Albums::delete($albumId);
		$this->redirect('/albums/index/'); // redirect back to the listing
	}

}
