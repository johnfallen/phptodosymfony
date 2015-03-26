<?php
/**
 * I am an include file that extends/adds functionality to PHP. I am included
 * in every request. Mostly just utility functions.
 *
 * @author John Allen
 * @version 1.0
 */

// needed for the function dump()
include_once 'deBug.php';
include_once 'kint-master/Kint.class.php';

/**
 * I dump out data in a readable format
 *
 * @param any $var  I am the data to dump to the screen. I am required.
 * @return void
 */
function cfDump($var){
    $dBug = new dBug($var);
}


/**
* I dump out data in a readable format
*
* @param any $value  I am the data to dump to the screen. I am required.
* @return void
*/
function dump( $value ){
//echo '<pre>'; var_dump($value); echo '</pre>';
    Kint::dump( $value );
}



?>