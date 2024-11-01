<?php
/*  
 * YO Gallery
 * Version:           1.0.0 - 32132
 * Author:            Yo Gallery Team (YGT)
 * Date:              05/05/2018
 */

if( !defined('WPINC') || !defined("ABSPATH") ){
	die();
}


class YO_GALLERY {

	private $options ;
	private $options_name = 'YO_GALLERY';


	public function __construct() {
		$this->options = get_option( $this->options_name , array() );
		if(!isset($this->options['enable_everywhere'])) $this->options['enable_everywhere'] = 0;
		$this->hooks();
		$this->widget();
	}


	private function hooks() {
		add_action( 'plugins_loaded', array( $this, 'register_text_domain' ) );

		register_activation_hook( __FILE__, 	array($this, 'activation') );
		register_deactivation_hook( __FILE__, 	array($this, 'deactivation') );

		add_action( 'wp_loaded', array( $this, 'wp_load_hooks' ) );

	}

	private function save_options() {
		update_option( $this->options_name, $this->options );
	}

	public function register_text_domain() {
		load_plugin_textdomain( 'yo-gallery', false, YO_GALLERY_PATH . 'languages' );
	}

	public static function activation(){ 	
		add_option( 'yo-gallery-install', 1 );  	
	}
	
	public static function deactivation(){ 
		delete_option('yo-gallery-install');		
	}

	public function widget() {
		include( YO_GALLERY_PATH . 'yo-gallery-widget.php');
	}


	public function wp_load_hooks(){
		if( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'settings_menu' ) );
			add_filter( 'plugin_action_links', array( $this, 'plugin_actions_links'), 10, 2 );
		}
	}

	public function plugin_actions_links( $links, $file ) {
		static $plugin;

		if( $file == 'yo-gallery/yo-gallery.php' && current_user_can('manage_options') ) {
			array_unshift(
				$links,
				sprintf( '<a href="%s">%s</a>', esc_attr( $this->settings_page_url() ), __( 'Settings' ) )
			);
		}

		return $links;
	}
	
	private function settings_page_url() {
		return add_query_arg( 'page', 'yo_gallery_options', admin_url( 'options-general.php' ) );
	}

	public function settings_menu() {
		$title = __( 'Yo Gallery', 'yo-gallery' );
		//add_submenu_page( 'options.php', $title, $title, 'manage_options', 'yo_gallery_options', array( $this, 'options' ) );
		add_options_page( 'Yo Gallery Options',  $title, 'manage_options', 'yo_gallery_options', array( $this, 'options' )  );
	}


	public function options() {
		include( YO_GALLERY_PATH .'yo-gallery-options.php');
	}
}