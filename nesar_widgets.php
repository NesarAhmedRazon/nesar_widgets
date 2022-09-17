<?php

/*
*
* @package NesarWidgets
*
* Plugin Name: Elementor Addons for Tallyfy
* Plugin URI: https://github.com/NesarAhmedRazon/nesar_widgets
* Description: This plugin will add some new Elementor Widgets.
* Author: Nesar Ahmed
* Version: 1.5.93
* Elementor tested up to: 3.6.6
* Elementor Pro tested up to: 3.7.2
* Author URI: https://github.com/NesarAhmedRazon/
* Text Domain: nesar-widgets
*/

define(
    'NESAR_WIDGETS',
    __FILE__
);
require plugin_dir_path(NESAR_WIDGETS) . 'nesar_init.php';
require plugin_dir_path(NESAR_WIDGETS) . 'exts/repeatable_metabox.php';
require plugin_dir_path(NESAR_WIDGETS) . 'exts/custom-control-init.php';
require plugin_dir_path(NESAR_WIDGETS) . 'exts/PostTransfating.php';
require plugin_dir_path(NESAR_WIDGETS) . 'exts/metaboxes.php';
require plugin_dir_path(NESAR_WIDGETS) . 'api_routes/routes.php';

function add_panel_button()
{
    \Elementor\Controls_Manager::add_tab(
        'panel_style_button',
        esc_html__('Button', 'nesar-widgets')
    );
}
add_action('elementor/init', 'add_panel_button');
function core_style_frontend()
{
    wp_register_style('nesar_wid_testimonial', plugin_dir_url(__FILE__) . 'style/TallyfyTestimonial.css');
    wp_enqueue_style('nesar_wid_testimonial');
}
add_action('elementor/frontend/after_enqueue_styles', 'core_style_frontend');



function my_plugin_editor_styles()
{
    wp_register_style('nesar_font', plugin_dir_url(__FILE__) . 'style/icomon/style.css');
    wp_register_style('nesar_editor_style', plugin_dir_url(__FILE__) . 'style/editor.css');
    //wp_register_style('nesar_icon_style', plugins_url('style/icomon/style.css', __FILE__));
    wp_enqueue_style('nesar_font');
    wp_enqueue_style('nesar_editor_style');
    //wp_enqueue_style('nesar_icon_style');
}
add_action('elementor/editor/before_enqueue_styles', 'my_plugin_editor_styles');

//Add custom Script for Elementor Editor




function add_panel_fetured()
{
    \Elementor\Controls_Manager::add_tab(
        'prs_feature_style',
        esc_html__('Featured', 'nesar-widgets')
    );
}
add_action('elementor/init', 'add_panel_fetured');

//set_post_type(32666, 'post');

add_action('init', 'set_admin_bar');

function add_link_to_admin_bar($admin_bar)
{
    $pd = get_plugin_data(__FILE__);
    $args = [
        'id' => 'nw_info',
        'title' => $pd['Name'] . ': v' . $pd['Version'],
        'href'      => __('/wp-admin/admin.php?page=wppusher-plugins'),
    ];
    $admin_bar->add_node($args);
}

function set_admin_bar()
{
    // Remove Admin Bar from Front-End for all Loged In User except Nesar
    $current_user = wp_get_current_user();
    $uid =  $current_user->user_nicename;
    if ($uid !== 'nesar') {
        add_filter('show_admin_bar', '__return_false');
    }
    if (($uid == 'nesar') || ($uid == 'grimroy')) {
        add_action('admin_bar_menu', 'add_link_to_admin_bar', 999);
    }
}

new PostTransfating();

require plugin_dir_path(NESAR_WIDGETS) . 'exts/LastWorker.php';
new LastWorkerSettings(); // Adds option under General Settings

function deQueStyle()
{
    if (is_home()) {
        wp_dequeue_style('formidable');
        wp_dequeue_style('roots_app');
        wp_dequeue_style("elementor-icons-shared-0");
    }
}

add_action('wp_enqueue_scripts', 'deQueStyle', 999999999999999999999999999999999);

// function get_my_menu($request)
// {
//     $id = $request['id'];
//     // Replace your menu name, slug or ID carefully
//     return wp_get_nav_menu_items($id);
// }

// add_action('rest_api_init', function () {
//     register_rest_route('wp/v2', '/menus/(?P<id>\d+)', array(
//         'methods' => 'GET',
//         'callback' => 'get_my_menu',
//     ));
// });
