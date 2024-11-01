<?php
/*
Plugin Name: Yo Gallery
Plugin URI: http://yoga.byethost10.com/
Description: modern, stylish, simple and very flexible wordpress gallery plugin
Version: 1.0.0
Author: Yo Gallery Team
Author URI:  https://profiles.wordpress.org/yogallery
License: GPLv3 or later
Text Domain: yo-gallery
Domain Path: /languages/
*/

/* */
if( !defined('WPINC') || !defined("ABSPATH") ) die();

/* Plugin path */
define("YO_GALLERY_PATH", 		plugin_dir_path( __FILE__ ) );

/* Plugin version */
define("YO_GALLERY_VERSION", 	'1.0.0' );

/* Plugin url*/
define("YO_GALLERY_URL", 		plugin_dir_url( __FILE__ ) );

/* Class include */
include_once( YO_GALLERY_PATH.'yo-gallery-class.php');

/* Init gallery class*/
$yo_gallery = new YO_GALLERY();