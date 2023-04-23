<?php
namespace LuizFelipeLeite\Includes;

defined( 'ABSPATH' ) || exit;

class LFLBlock {

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
        add_action('init', array($this, 'register_block'));
    }

    public function register_block() {
        register_block_type('blocks/lfl-block', array(
            'editor_script' => 'lfl-block',
            'render_callback' => array($this, 'lfl_callback'),
            'style'         => 'lfl-block',
        ));
    }

    public function lfl_callback() {
        $nonce = wp_create_nonce('api-nonce');

        $response = wp_remote_post(admin_url('admin-ajax.php'), array(
            'method' => 'POST',
            'headers' => array(
                'Content-type: application/json',
            ),
            'body' => array(
                'action' => 'api_endpoint',
                'nonce' => $nonce
            ),
        ));
        
        if (is_wp_error($response)) {
            return '';
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);
        
        $output = '<div class="wp-block-lfl-block">';

        foreach($data['data']['headers'] as $header) {
            $output .= '<p>' . esc_html($header) . '</p>';
        }

        $output .= '</div>';

        return $output;
    }
}
