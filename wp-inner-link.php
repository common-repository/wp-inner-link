<?php
/*
Plugin Name: WP Inner Link
Plugin URI: http://wordpress.org/extend/plugins/wp-inner-link/
Description: A very simple plugin for internal linking within your wordpress site. You can easily use shortcode to link a page, post or custom post type. 
Version: 1.0
Author: TeamFanush
Author URI: http://labs.fanush.net/
*/



/************************************************************************
## Copyright (c) 2013, the Fanush Team. All rights reserved.
##
## Released under the GPL license
## http://www.opensource.org/licenses/gpl-license.php
##
## This is an add-on for WordPress
## http://wordpress.org/
##
## **********************************************************************
## This program is free software; you can redistribute it and/or modify
## it under the terms of the GNU General Public License as published by
## the Free Software Foundation; either version 2 of the License, or
## (at your option) any later version.
##
## This program is distributed in the hope that it will be useful,
## but WITHOUT ANY WARRANTY; without even the implied warranty of
## MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
## GNU General Public License for more details.

*******************************************************************************/


/***************************************************
## Security
## If this file is called directly, abort.
*****************************************************/



if ( ! defined( 'WPINC' ) ) {
	die;
}





require_once( plugin_dir_path( __FILE__ ) . 'class-wp-inner-link.php' );

register_activation_hook( __FILE__, array( 'WP_Inner_Link', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Inner_Link', 'deactivate' ) );

WP_Inner_Link::get_instance();