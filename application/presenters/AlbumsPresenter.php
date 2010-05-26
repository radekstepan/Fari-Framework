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
            $this->redirectTo('/login/');
        }

        $this->albums = new Albums();
	}



    /********************* actions *********************/


    
	public function actionIndex($p) {
        $this->bag->albums = $this->albums->findAll();
		$this->renderAction('albums');
	}

	public function actionAdd() {
        if ($this->request->isPost()) {            
            try {
                $this->albums->set(array(
                    'artist' => $this->request->getPost('artist', 'html'),
                    'title' => $this->request->getPost('title', 'html')
                ))->add();
                
                $this->flashSuccess = 'Album has been saved.';
                $this->redirectTo('/albums/');

            } catch (TableException $e) {
                $this->flashFail = $e->getMessage();
            }
        }
        
        $this->renderAction();
	}

	public function actionEdit($albumId) {
        if ($this->request->isPost()) {
            try {
                $this->albums->set(array(
                    'artist' => $this->request->getPost('artist', 'html'),
                    'title' => $this->request->getPost('title', 'html')
                ))->update()->where($albumId);

                $this->flashSuccess = 'Album has been updated.';
                $this->redirectTo('/albums/');
                
             } catch (TableException $e) {
                $this->flashFail = $e->getMessage();
            }
        }

        $this->renderAction('edit', $albumId);
	}

    public function actionDelete($albumId) {
        if ($this->albums->delete()->where($albumId) == 1) {
            $this->flashSuccess = 'Album has been deleted.';
        }
        
        $this->redirectTo('/albums/');
    }



    /********************* render *********************/



    public function renderEdit($albumId) {
        $this->bag->album = $this->albums->findFirst()->where($albumId);
    }

}
