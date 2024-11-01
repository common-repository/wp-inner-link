<?php
/********************************************************
## WP Inner Link.
##
## @package     WPIL
## @author  	dotcomdotbd <dotcomdotbd@gmail.com>
## @license     GPL-2.0+
## @link        http://labs.fanush.net
## @copyright   2013 Team Fanush
 *********************************************************/



/*************************************************************
## WP_Inner_Link class.
## WP Inner Link
## WPIL Main Plugin class.
## WP Inner Link: Rename this class to a proper name for your plugin.
##
##
## @package WPIL
## @author  dotcomdotbd <dotcomdotbd@gmail.com>
***************************************************************/


class WP_Inner_Link {


	protected $version = '1.0';

	protected $plugin_slug = 'wp-inner-link';

	protected static $instance = null;

	protected $plugin_screen_hook_suffix = null;



	/*****************************************************************
	## Initialize the plugin by setting localization, filters, 
	## and administration functions.
	## Set Plugin Path
	## Set Plugin URL
	## Add shortcode support for widgets
	## @since     1.0.0
	***********************************************************************/


	private function __construct() {

		add_shortcode('wpil', array($this, 'wpil_shortcode'));
		add_filter('widget_text', 'do_shortcode'); 

	     add_filter('mce_external_plugins', array($this, 'wpil_add_plugin'));  
	     add_filter('mce_buttons_3',  array($this,'wpil_register_button'));  
		
	}



	/*************************************************************
	## Return an instance of this class.
	##
	## @since     1.0.0
	## @return    object    A single instance of this class.
	***************************************************************/


	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	

	/*******************************************************************
	## Fired when the plugin is activated.
	##
	## @since    1.0.0
	## @param    boolean    $network_wide   
	## True if WPMU superadmin uses "Network Activate" action,
	## false if WPMU is disabled or plugin is activated on an individual blog.
	 **************************************************************************/


	public static function activate( $network_wide ) {
		// No activation activities right now.
	}

	
	

	/********************************************************************
	## Fired when the plugin is deactivated.
	##
	## @since    1.0.0
	## @param    boolean    $network_wide    
	## True if WPMU superadmin uses "Network Deactivate" action, 
	##false if WPMU is disabled or plugin is deactivated on an individual blog.
	********************************************************************/


	public static function deactivate( $network_wide ) {
		// No deactivation activities right now.
	}




	/*********************************************************
	## Get link of related page/post/custom post type
	## Return appropriate link with text
	##
	## @since    1.0.0
	**********************************************************/


	public function get_wpil($posttype, $link_text, $title){

		$posttype  = trim($posttype);
		$link_text = trim($link_text);
		$title  = trim($title);


		if(!$posttype){
			$posttype = 'post';
		}

		
		$home = get_option('siteurl');

		$page = get_page_by_title( $title, OBJECT, $posttype);

		if(!$link_text){ $link_text = $title; }

		if($page){

			$permalink = get_permalink($page->ID);
			return '<a href="'.$permalink.'">'.$link_text.'</a>';

		} else {

			if ( is_user_logged_in() ){

				$assume_slug  = urlencode($title);
				$create_new_link = $home.'/wp-admin/post-new.php?post_type='.$posttype.'&post_title='.$assume_slug;

				return $link_text. '<a href="'.$create_new_link.'" title="This '.$posttype .' is not yet created. Create it (requires a valid access/permission)">(?)</a>';
			} else{

				return $title;
			}

		}

		
	}


	/********************************************
	## Plugin Shortcode Function
	## extract the attributes into variables
	##
	## @since    1.0.0
	**********************************************/

	public function wpil_shortcode($atts){
		
		extract(shortcode_atts(array(
			'posttype' => 'post',
			'link_text' => '',
			'title' => '',
		), $atts));


		return $this->get_wpil( $posttype, $link_text, $title);
	}



	


	/*****************************************************
	## Add Icons into Post/Page Editor
	##
	## @since    1.0.0
	*******************************************************/

	public function wpil_add_button() {  
	
	   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {  

	     add_filter('mce_external_plugins', 'wpil_add_plugin');  
	     add_filter('mce_buttons_3', 'wpil_register_button');  

	   }  

	} 




	/*****************************************************
	## Register Buttons for Editor
	##
	## @since    1.0.0
	*******************************************************/

	function wpil_register_button($buttons) {  
  
  		array_push($buttons, "wpil");  
   		return $buttons;  

	} 


	/*******************************************************
	## Add Js for Buttons in editor
	##
	## @since    1.0.0
	*******************************************************/

	function wpil_add_plugin($plugin_array) {  

		$plugin_array['wpil'] = plugins_url( 'library/customcodes.js' , __FILE__ );
 	  
    	return $plugin_array;  
	}  


}