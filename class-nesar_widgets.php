<?php
if (!defined('ABSPATH')) {
    // Exit if accessed directly.
    exit;
}
final class Nesar_Widgets
{

    public function __construct()
    {

        // Initialize the plugin.
        add_action('plugins_loaded', array($this, 'init'));
    }

    public function init()
    {
        require_once 'nesar_elw_servic.php';
    }
}

new Nesar_Widgets();
