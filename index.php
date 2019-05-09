<?php
/**
 * Plugin Name: ESNext Data Module - Get With Gutenberg
 * Plugin URI: https://github.com/Wordpress
 * Description: Demonstrate how to use the Data Module in a Gutenberg block in ESNext.
 * Version: 1.0.0
 * Author: Get With Gutenberg
 * Author URI: https://getwithgutenberg.com
 * Text Domain: gwg
 * Domain Path: languages
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) || exit;

define( 'GWG_ESNEXT_VERSION', '1.0.0' );
define( 'GWG_ESNEXT_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'GWG_ESNEXT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

function gwg_init() {
	load_plugin_textdomain( 'gwg', false, GWG_ESNEXT_PLUGIN_DIR . '/languages' );
}
add_action( 'init', 'gwg_init' );

function gwg_register_block_type() {

	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}

	wp_register_style(
		'gwg-style',
		GWG_ESNEXT_PLUGIN_URL . 'style.css',
		[],
		GWG_ESNEXT_VERSION
	);

	wp_register_style(
		'gwg-editor',
		GWG_ESNEXT_PLUGIN_URL . 'editor.css',
		[],
		GWG_ESNEXT_VERSION
	);

	wp_register_script(
		'gwg-block',
		GWG_ESNEXT_PLUGIN_URL . 'block.build.js',
		[ 'wp-blocks', 'wp-i18n', 'wp-data', 'wp-compose' ],
		GWG_ESNEXT_VERSION,
		true // Enqueue script in the footer.
	);

	register_block_type(
		'gwg/esnext-data',
		[
			'editor_script' => 'gwg-block',
			'editor_style'  => 'gwg-editor',
			'style'         => 'gwg-style',
		]
	);

	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'gwg-block', 'gwg', GWG_ESNEXT_PLUGIN_DIR . '/languages' );
	}
}
add_action( 'init', 'gwg_register_block_type' );
