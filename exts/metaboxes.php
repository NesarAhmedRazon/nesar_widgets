<?php

// Tallyfy Meta Boxes

namespace WPC\MetaBoxes;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class MetaBoxes
{
    public function __construct()
    {
        add_filter('wp_setup_nav_menu_item', [$this, 'add_image_to_menuItem']);
        add_action('wp_update_nav_menu_item', [$this, 'save_image_to_menuItem'], 10, 3);
        add_filter('wp_edit_nav_menu_walker', [$this, 'walker_image_to_menuItem'], 10, 2);
    }
    public function add_image_to_menuItem($menus)
    {
        $menus->navIcon = get_post_meta($menus->ID, '_menu_item_navIcon', true);
        return $menus;
    }
    public function save_image_to_menuItem($id, $db_id, $args)
    {
        if (is_array($_REQUEST['menu-item-navIcon'])) {
            $navIcon = $_REQUEST['menu-item-navIcon'][$db_id];
            update_post_meta($db_id, '_menu_item_navIcon', $navIcon);
        }
    }
    public function walker_image_to_menuItem($walker, $menu_id)
    {
        return 'Walker_Nav_Menu_Edit_Custom';
    }
}
//new MetaBoxes();
                                                                //TODO:need to develop
