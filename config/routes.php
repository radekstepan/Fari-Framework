<?php if (!defined('FARI')) die();

/**
 * An optional routes file that will serve as a helpful 'redirect' to your Controller/Actions.
 * 
 * @author Radek Stepan <radek.stepan@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * @package Fari
 */

$customRoutes = array(
    // nicely rewrite albums listing (using default 'index' action)
    '/albums\/([\0-9])/' => 'albums/index/\1'
);