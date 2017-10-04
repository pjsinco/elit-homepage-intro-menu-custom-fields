<?php

/**
 * Elit 
 *
 * @package Elit_Homepage_Intro_Menu_Item_Custom_Fields
 * @version 1.0.0
 * @author  Dzikri Aziz <kvcrvt@gmail.com>
 * @author  Patrick Sinco
 *
 * Plugin name: Elit Homepage Intro Menu Item Custom Fields
 * Plugin URI: https://github.com/kucrut/wp-menu-item-custom-fields
 * Description: Add a custom field for tags to menu items
 * Version: 1.0.0
 * Authors: Dzikri Aziz and Patrick Sinco
 */


if ( ! class_exists( 'Menu_Item_Custom_Fields' ) ) :
	/**
	* Menu Item Custom Fields Loader
	*/
	class Menu_Item_Custom_Fields {

		/**
		* Add filter
		*
		* @wp_hook action wp_loaded
		*/
		public static function load() {
			add_filter( 'wp_edit_nav_menu_walker', array( __CLASS__, '_filter_walker' ), 99, 2 );
		}


		/**
		* Replace default menu editor walker with ours
		*
		* We don't actually replace the default walker. We're still using it and
		* only injecting some HTMLs.
		*
		* @since   0.1.0
		* @access  private
		* @wp_hook filter wp_edit_nav_menu_walker
		* @param   string $walker Walker class name
		* @return  string Walker class name
		*/
		public static function _filter_walker( $walker, $id ) {

      $target_menu = get_option( 'elit_settings' );

      // Only show the custom field on the menu identifed
      // on the settings page
      if ( $target_menu ) {
        $target_menu_id = $target_menu['elit_menu_id_for_custom_field'];
        if ( $id !== ( int ) $target_menu_id ) return $walker;
      }

			$walker = 'Menu_Item_Custom_Fields_Walker';
			if ( ! class_exists( $walker ) ) {
				require_once dirname( __FILE__ ) . '/walker-nav-menu-edit.php';
			}

			return $walker;
		}
	}
	add_action( 'wp_loaded', array( 'Menu_Item_Custom_Fields', 'load' ), 9 );
endif; // class_exists( 'Menu_Item_Custom_Fields' )

// Uncomment the following line to test this plugin
require_once dirname( __FILE__ ) . '/doc/elit-tag-menu-item.php';
require_once dirname( __FILE__ ) . '/elit-homepage-intro-menu-custom-fields-options.php';
