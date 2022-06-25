<?php

//Tallyfy Heading With Icon

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

require plugin_dir_path(NESAR_WIDGETS) . 'exts/TabsControl.php';

class Tabs extends Widget_Base
{
    public function get_name()
    {
        return 'nesar_w_tab';
    }
    public function get_title()
    {
        return esc_html__('Tf Tabs', 'nesar-widgets');
    }
    public function get_icon()
    {
        return 'eicon-button';
    }
    public function get_categories()
    {
        return ['basic'];
    }
    public function get_style_depends()
    {
        wp_register_style('nesar_wid_Tabs', plugin_dir_url(__DIR__) . 'style/tabs.css');
        return [
            'nesar_wid_Tabs'
        ];
    }
    public function get_script_depends()
    {

        wp_register_script('nesar_wid_Tabs_backend', plugin_dir_url(__DIR__) . 'js/tabs_editor.js');
        return [
            'nesar_wid_Tabs_backend',


        ];
    }


    protected function register_controls()
    {
        $id = 'nw_tabs';
        $tc = new TabsControl();

        $tc->repeater(
            [
                'id' => $id,
                'label' => 'Tabs',
                'selector' => '.tabList',
                'repeater' => 'Tabs',
            ]
        );
        $tc->button_settings(
            [
                'id' => $id,
                'label' => 'Tab Settings',
                'selector' => '.tabList',
            ]
        );
        $tc->content_settings(
            [
                'id' => $id,
                'label' => 'Content Settings',
                'selector' => '.tabContents',

            ]
        );
    }


    protected function render()
    {
        $id = 'nw_tabs';
        $sets = $this->get_settings_for_display();
        $tabs = $sets[$id . '_r_list'];
        $style = $sets[$id . '_b__style'];
        $lFirst = true;
        $cFirst = true;
        if ($tabs) {


            echo '<div class="tabsContainer">';
            if ($style == 'tabs') {
                echo '<div class="tabList">';
                foreach ($tabs as $tab) {
                    echo '<div class="tabItem' . ($lFirst == true ? ' active' : '') . '">';
                    echo '<div class="tabText">' . $tab[$id . '_r_title'] . '</div>';
                    echo '</div>';
                    $lFirst = false;
                }
                echo '</div>';
            }

            echo '<div class="tabContents ' . $style . '">';

            foreach ($tabs as $tab) {
                $tID = $tab[$id . '_r_templates'];
                $shortcode = '[elementor-template id="' . $tID . '"]';
                $shortcode = do_shortcode(shortcode_unautop($shortcode));
                echo '<div class="content' . ($cFirst == true ? ' active' : '') . '">';
                if ($style != 'tabs') {
                    echo '<div class="tabItem">';
                    echo '<div class="tabText">' . $tab[$id . '_r_title'] . '</div>';
                    echo '</div>';
                }
                echo '<div class="tabData">' . $shortcode . '</div>';
                echo '</div>';

                $cFirst = false;
            }
            echo '</div><!--tabContents--!>';
            echo '</div><!--tabsContainer--!>';
        } ?>
<?php
    }
}
