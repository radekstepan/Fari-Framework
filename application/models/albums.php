<?php if (!defined('FARI')) die();

class Albums extends Fari_Model {
    
    public static function add($artist, $title) {
        // escape input
        $artist = Fari_Escape::html($artist);
        $title = Fari_Escape::html($title);
        
        // db insert
        Fari_Db::insert('albums', array('artist' => $artist, 'title' => $title));
        
        // flash message
        Fari_Message::success('Album has been saved.');
    }
    
    public static function get($albumId) {
        // escape input
        $albumId = Fari_Escape::text($albumId);
        
        // db select & return a single row
        return Fari_Db::selectRow('albums', 'id, artist, title', array('id' => $albumId));
    }
    
    public static function edit($albumId, $artist, $title) {
        // escape input
        $albumId = Fari_Escape::text($albumId);
        $artist = Fari_Escape::html($artist);
        $title = Fari_Escape::html($title);
        
        // db update
        Fari_Db::update('albums', array('artist' => $artist, 'title' => $title), array('id' => $albumId));
        
        // flash message
        Fari_Message::success('Album has been edited.');
    }
    
    public static function delete($albumId) {
        $albumId = Fari_Escape::text($albumId);
        
        Fari_Db::delete('albums', array('id' => $albumId));
        
        Fari_Message::success('Album has been deleted.');
    }
}
