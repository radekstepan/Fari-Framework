<?php if (!defined('FARI')) die();



class Albums extends Fari_ApplicationModel {

    function getAll() {
        return $this->db->select('albums', 'id, artist, title');
    }

    function get($albumId) {
        return $this->db->selectRow('albums', 'id, artist, title', array('id' => $albumId));
    }

    function isAlbum($albumId) {
        $result = $this->get($albumId);
        return (!empty($result));
    }

    function add($artist, $title) {
        $this->db->insert('albums', array('artist' => $artist, 'title' => $title));
        
        Fari_Message::success('Album has been saved.');
    }

    function edit($albumId, $artist, $title) {
        $this->db->update('albums', array('artist' => $artist, 'title' => $title), array('id' => $albumId));

        Fari_Message::success('Album has been edited.');
    }

    function delete($albumId) {
        $this->db->delete('albums', array('id' => $albumId));

        Fari_Message::success('Album has been deleted.');
    }

}