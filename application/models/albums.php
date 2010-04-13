<?php if (!defined('FARI')) die();



class Albums {

    private $albums;

    public function __construct() {
        $this->albums = new Table('albums');
    }

    function getAll() {
        return $this->albums->findAll();
    }

    function get($albumId) {
        return $this->albums->findFirst()->where(array('id' => $albumId));
    }

    function isAlbum($albumId) {
        $result = $this->get($albumId);
        return (!empty($result));
    }

    function add($artist, $title) {
        $this->albums->artist = $artist;
        $this->albums->title = $title;

        $this->albums->add();
        
        Fari_Message::success('Album has been saved.');
    }

    function edit($albumId, $artist, $title) {
        $this->albums->artist = $artist;
        $this->albums->title = $title;

        $this->albums->update()->where(array('id' => $albumId));

        Fari_Message::success('Album has been edited.');
    }

    function delete($albumId) {
        $this->albums->remove()->where(array('id' => $albumId));

        Fari_Message::success('Album has been deleted.');
    }

}