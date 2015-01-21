<?php

/*----------------------------------------------------------------
--------------
Plugin Name: WP maps
Plugin URI: http://www.site.us/
Description: Sample plugin for get google maps with marker.
Author: Nicolay Rodionov
Version: 0.1
Author URI: http://www.site.us/
------------------------------------------------------------------
------------*/

include_once('maps.php');
add_action('wp_head', 'Get_maps::head');
add_action('admin_head', 'Get_maps::head');
add_action('widgets_init', 'Get_maps::register_this_widget');
add_action('admin_menu', 'Get_maps::admin_this_widget');

