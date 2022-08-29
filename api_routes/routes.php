<?php

/**
 * Create all Routes for WP Rest API Calls
 *
 * @param    object  $object The object to convert
 * @return      array
 *
 */

namespace WPC\API;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


final class ApiRoutes
{
    public function __construct()
    {
        // Initialize the Menu Locations.
        add_action('init', [$this, 'registe_menu_locations']);
        add_action('rest_api_init', [$this, 'register_api_routes']);
    }

    public function registe_menu_locations()
    {
        register_nav_menus(
            array(
                'cta' => __('CTA Buttons'),
                'copyright' => __('Copyright Menu'),
                'megaFooter' => __('SubMenu Footer Menu'),
            )
        );
    }
    public function register_api_routes()
    {
        register_rest_route('wp/v2', '/menus/location/(?P<loc>\w+)', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_menu_by_location'],
        ));
        register_rest_route('wp/v2', '/allNav', array(
            'methods' => 'GET',
            'callback' => [$this, 'getAllNav'],
        ));
        register_rest_route('wp/v2', '/el/(?P<id>\w+)', [
            'methods' => 'GET',
            'callback' => [$this, 'getElItem'],
        ]);
    }

    public function getElItem(\WP_REST_Request $req)
    {
        $post_ID = $req->get_param("id");
        $the_post = get_post($post_ID);
        $contentElementor = "";

        if (class_exists("\\Elementor\\Plugin")) {
            $pluginElementor = \Elementor\Plugin::instance();
            $contentElementor = $pluginElementor->frontend->get_builder_content($post_ID);
        }


        return $contentElementor;
    }


    public function get_menu_by_location($req)
    {
        $menu_items = [];
        $menu_slug  = $req['loc'];
        $locations = get_nav_menu_locations();
        if (($locations = get_nav_menu_locations()) && isset($locations[$menu_slug]) && $locations[$menu_slug] != 0) {
            $menu = get_term($locations[$menu_slug]);
            $menus = wp_get_nav_menu_items($menu->term_id);
            $menu_items = $menus;
        } else {
            return false;
        }
        return $menu_items;
    }

    public function getAllNav()
    {
        $menus = [];

        $locs = get_registered_nav_menus();
        foreach ($locs as $loc => $name) {
            $menu = $this->get_menu_by_location(["loc" => $loc]);

            if (!$menu == false) {
                $menus[$loc] = $menu;
            }
        }
        return $menus;
    }
}
new ApiRoutes();
