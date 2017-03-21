<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage Digitec
 */




if( is_home() ) {	
	maven_archive();
} else {
	maven_single();
}