<?php
/**
 * Plugin Name: Luiz Felipe Leite
 * Description: Block API Based Plugin Test
 * Author: Luiz Felipe Leite
 * Version: 1.0.0
 * Text Domain: lfl
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'LFL_PLUGIN_FILE' ) ) {
	define( 'LFL_PLUGIN_FILE', __FILE__ );
}

// Include the main LuizFelipeLeite class.
if ( ! class_exists( 'LuizFelipeLeite\Includes\LuizFelipeLeite', false ) ) {
	include_once dirname( LFL_PLUGIN_FILE ) . '/includes/LuizFelipeLeite.php';
}

// Returns the main instance of the plugin.
function fuizfelipeleite() {
	return LuizFelipeLeite\Includes\LuizFelipeLeite::instance();
}

$GLOBALS['fuizfelipeleite'] = fuizfelipeleite();
