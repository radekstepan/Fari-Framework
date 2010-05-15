<?php if (!defined('FARI')) die();

/**
 * Albums model, example of ORM.
 *
 * @package Application\Models\Albums
 */
class Albums extends Table {

    /** @var string name of the db table */
    public $table = 'albums';

    /** @var array validates the presence of column data */
    public $validatesPresenceOf = array('artist', 'title');

    /** @var array validates the length of columns */
    public $validatesLengthOf = array(array('artist' => 2));

}