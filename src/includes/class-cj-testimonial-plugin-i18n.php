<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       cjwsstrm.com
 * @since      1.0.0
 *
 * @package    Cj_Testimonial_Plugin
 * @subpackage Cj_Testimonial_Plugin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cj_Testimonial_Plugin
 * @subpackage Cj_Testimonial_Plugin/includes
 * @author     CJ Wesstrom <cjwesstrom@gmail.com>
 */
class Cj_Testimonial_Plugin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cj-testimonial-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
