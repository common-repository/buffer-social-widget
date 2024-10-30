<?php 
/*
Plugin Name: Buffer Social Widget
Author: Theme Buffer
Author URI: http://www.themebuffer.com/
Version: 1.0.3
Description: Buffer Social feed widget offers social widgets, for Bloglovin, Facebook, Linkedin, Twitter, Instagram, and Pinterest.
License: GPLv2 or later
Text Domain: tb-social-widget
*/

//define( 'TB_SW_VERSION', '1.0' );
//define( 'TB_SW__MINIMUM_WP_VERSION', '4.0' );
define( 'TB_SW__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TB_SW__PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once( TB_SW__PLUGIN_DIR . 'inc/widget.facebooklike.php' );
require_once( TB_SW__PLUGIN_DIR . 'inc/widget.twitter.php' );
require_once( TB_SW__PLUGIN_DIR . 'inc/widget.linkedinbutton.php' );
require_once( TB_SW__PLUGIN_DIR . 'inc/widget.pinterest.php' );
require_once( TB_SW__PLUGIN_DIR . 'inc/widget.bloglovin.php' );
require_once( TB_SW__PLUGIN_DIR . 'inc/widget.instagram.php' );
require_once( TB_SW__PLUGIN_DIR . 'inc/class.plugin.core.php' );

$obj_TB_SW_Class = new TB_SW_Class;
