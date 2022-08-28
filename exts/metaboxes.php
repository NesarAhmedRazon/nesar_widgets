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
        add_filter('add_meta_boxes', [$this, 'add_image_to_menuItem']);
    }
    public function add_image_to_menuItem()
    {
        add_meta_box(
            'menu_image',                 // Unique ID
            'Icon/Image',      // Box title
            [$this, 'menu_image_html'],  // Content callback, must be of type callable
            'nav_menu_item'                           // Post type
        );
    }
    public function menu_image_html($post)
    {
?><label for="wporg_field">Description for this field</label><?php
                                                                    }
                                                                }
//new MetaBoxes(); TODO:need to develop
