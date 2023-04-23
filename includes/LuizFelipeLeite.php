<?php

namespace LuizFelipeLeite\Includes;

defined('ABSPATH') || exit;

final class LuizFelipeLeite
{
	public $version = '1.0.0';

	// The single instance of the class.
	protected static $_instance = null;

	// Ensures only one instance of LuizFelipeLeite is loaded or can be loaded.
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct()
	{
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
		$this->init_classes();
	}

	private function define_constants()
	{
		$this->define('LFL_ABSPATH', dirname(LFL_PLUGIN_FILE) . '/');
		$this->define('LFL_PLUGIN_URL', plugin_dir_url(LFL_PLUGIN_FILE));
		$this->define('LFL_VERSION', $this->version);
	}

	// Define constant if not already set.
	private function define($name, $value)
	{
		if (!defined($name)) {
			define($name, $value);
		}
	}

	private function includes()
	{
		include_once LFL_ABSPATH . 'includes/Api.php';
		include_once LFL_ABSPATH . 'includes/LFLBlock.php';
	}

	private function init_classes()
	{
		Api::instance();
		LFLBlock::instance();
	}

	private function init_hooks()
	{
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('enqueue_block_editor_assets', array($this, 'enqueue_blocks'));
	}

	public function enqueue_scripts()
	{
		wp_register_style('lfl-block', LFL_PLUGIN_URL . 'dist/css/lfl-block.min.css', array(), LFL_VERSION);
	}

	function enqueue_blocks()
	{
		wp_enqueue_script('lfl-block', LFL_PLUGIN_URL . 'dist/js/lfl-block.js', array('wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-api'), LFL_VERSION, true);
		wp_register_style('lfl-block', LFL_PLUGIN_URL . 'dist/css/lfl-block.min.css', array(), LFL_VERSION);

		wp_localize_script('lfl-block', 'ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('api-nonce')
		));
	}
}
