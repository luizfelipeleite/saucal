<?php
namespace LuizFelipeLeite\Includes;

defined( 'ABSPATH' ) || exit;

class Api {

	// The single instance of the class.
	protected static $_instance = null;

	// Ensures only one instance of Api is loaded or can be loaded.
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action('wp_ajax_nopriv_api_endpoint', array( $this, 'get_api_data' ) );
		add_action('wp_ajax_api_endpoint', array( $this, 'get_api_data' ) );
	}

	public function get_api_data() {
    $response = wp_remote_post('https://httpbin.org/post');
    $data = json_decode(wp_remote_retrieve_body($response), true);
    wp_send_json_success($data);
		wp_die();
	}
}
