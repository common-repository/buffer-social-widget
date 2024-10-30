<?php 
/*
Plugin init class
*/

class TB_SW_Class{
	
	public function __construct(){
		add_action( 'widgets_init', array($this, 'tb_load_widgets') );
		add_action( 'wp_enqueue_scripts', array($this, 'tb_social_widget_enqueue_scripts') );
	}
	
	public function tb_pf_pluginActivate(){
		
	}
	
	public function tb_pf_pluginDeactivate(){
		
	}
	
	// Register and load the widget
	public function tb_load_widgets() {
		register_widget( 'TB_Facebook_Like_Box_Widget' ); // facebook like box widget
		register_widget( 'TB_Twitter_Timeline_Widget' ); // twitter tweet limeline widget
		register_widget( 'TB_Linkedin_Follow_Button_Widget' ); // linkedin follow button widget
		register_widget( 'TB_Pinterest_Board_Widget' ); // linkedin follow button widget
		register_widget( 'TB_Bloglovin_Button_Widget' ); // Bloglovin follow button widget
		register_widget( 'TB_Instagram_Gallery_Widget' ); // Instagram gallery widget widget
	}
	
	public function tb_social_widget_enqueue_scripts(){
		wp_enqueue_style('TB-SW-style', TB_SW__PLUGIN_URL . 'assets/css/tb-sw-style.css', null, false, 'all');
	}
}