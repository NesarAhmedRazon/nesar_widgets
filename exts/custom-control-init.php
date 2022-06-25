<?php

namespace ElementorControls;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Elementor_Custom_Controls
{

	public function includes()
	{
		require_once(plugin_dir_path(__FILE__) . 'custom-control.php');
	}

	public function register_controls()
	{
		$this->includes();
		$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register(new \Elementor\CustomControl\Direction_Control(), \Elementor\CustomControl\Direction_Control::Direction);
	}

	public function __construct()
	{
		add_action('elementor/controls/controls_registered', [$this, 'register_controls']);
	}
}
new Elementor_Custom_Controls();
