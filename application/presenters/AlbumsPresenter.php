<?php if (!defined('FARI')) die();

/**
 * Albums.
 *
 * @package   Application\Presenters
 */
class AlbumsPresenter extends Fari_ApplicationPresenter {

    /** @var Fari_AuthenticatorSimple */
    private $user;

    /** @var Albums */
    private $albums;



    /********************* authenticate *********************/



	public function filterStartup() {
        $this->user = new Fari_AuthenticatorSimple();
        if (!$this->user->isAuthenticated()) {
            $this->response->redirect('/login/');
        }

        $this->albums = new Albums();
        $this->bag->messages = Fari_Message::get();
	}



    /********************* actions *********************/


    
	public function actionIndex($p) {
        $this->bag->albums = $this->albums->findAll();
		$this->render('albums');
	}

	public function actionAdd() {
        if ($this->request->isPost()) {            
            try {
                $this->albums->set(array(
                    'artist' => $this->request->getPost('artist', 'html'),
                    'title' => $this->request->getPost('title', 'html')
                ))->add();
                
                Fari_Message::success('Album has been saved.');
                $this->response->redirect('/albums/');

            } catch (TableException $e) {
                Fari_Message::fail($e->getMessage());
                $this->bag->messages = Fari_Message::get();
            }
        }
        
        $this->render('add');
	}

	public function actionEdit($albumId) {
        if ($this->request->isPost()) {
            try {
                $this->albums->set(array(
                    'artist' => $this->request->getPost('artist', 'html'),
                    'title' => $this->request->getPost('title', 'html')
                ))->update()->where($albumId);

                Fari_Message::success('Album has been updated.');
                $this->response->redirect('/albums/');
                
             } catch (TableException $e) {
                Fari_Message::fail($e->getMessage());
                $this->bag->messages = Fari_Message::get();
            }
        }

        $this->render('edit', $albumId);
	}

    public function actionDelete($albumId) {
        if ($this->albums->remove()->where($albumId) == 1) {
            Fari_Message::success('Album has been deleted.');
        }
        
        $this->response->redirect('/albums/');
    }



    /********************* render *********************/



    public function renderEdit($albumId) {
        $this->bag->album = $this->albums->findFirst()->where($albumId);
    }

}
