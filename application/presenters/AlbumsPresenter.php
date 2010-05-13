<?php if (!defined('FARI')) die();



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
        $this->bag->albums = $this->albums->getAll();
		$this->render('albums');
	}

	public function actionAdd() {
        if ($this->request->isPost()) {
            $this->albums->add(
                $this->request->getPost('artist', 'html'),
                $this->request->getPost('title', 'html')
            );
            $this->response->redirect('/albums/');
        }
        $this->render('add');
	}

	public function actionEdit($albumId) {
        if ($this->albums->isAlbum($albumId)) {
            if ($this->request->isPost()) {
                $this->albums->edit(
                    $albumId,
                    $this->request->getPost('artist', 'html'),
                    $this->request->getPost('title', 'html')
                );

                $this->response->redirect('/albums/');
            } else {
                $this->render('edit', $albumId);
            }
        } else {
            $this->render('notfound', $albumId);
        }
	}

    public function actionDelete($albumId) {
        if ($this->albums->isAlbum($albumId)) {
            $this->albums->delete($albumId);

            $this->response->redirect('/albums/');
        } else {
            $this->render('notfound', $albumId);
        }
    }



    /********************* render *********************/



    public function renderEdit($albumId) {
        $this->bag->album = $this->albums->get($albumId);
    }

    public function renderNotfound($albumId) {
        dump($albumId);
    }

}
