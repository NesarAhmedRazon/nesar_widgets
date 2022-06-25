<?php

// Tallyfy Multi Button

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

require plugin_dir_path(NESAR_WIDGETS) . 'exts/BasicControls_buttons.php';
class MultiButtons extends Widget_Base
{
    public function get_name()
    {
        return 'tallyfy_two_buttons';
    }
    public function get_title()
    {
        return esc_html__('Tallyfy Multi Button', 'nesar-widgets');
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
        wp_register_style('nesar_wid_MultiButtons', plugin_dir_url(__DIR__) . 'style/MultiButtons.css');
        return [
            'nesar_wid_MultiButtons'
        ];
    }
    protected function register_controls()
    {
        $bs = new BasicControls_buttons();
        $bs->basic_setings(
            [
                'id' => 'buttons',
                'label' => 'Button Settings',
                'repeater' => 'Buttons',
                'selector' => [
                    'parent' => 'multiButtons',
                    'child' => 'multiButtons_button',
                ],
                'settings' => ['link', 'text_style', 'background', 'spacing'],
                'remove' => ['padding']
            ]
        );
    }
    protected function render()
    {
        $id = 'buttons_buttons';
        $set = $this->get_settings_for_display();
        $buttons = $set['buttons_list'];
        if ($buttons) {
            echo '<div class="multiButtons">';
            foreach ($buttons as $button) {
                $url = $button[$id . '_links'];
                if (!empty($url['url'])) {
                    $this->add_link_attributes($id . '_links', $url);
                }
                $ishow = $button[$id . '_icon_show'];
                $elid = $button['_id'];
                $text = $button[$id . '_title'];
                $attrs = $this->get_render_attribute_string($id . '_links');
                $idir = $button[$id . '_direction'];



                echo '<a class="multiButtons_button elementor-repeater-item-' . $elid . '"' . $attrs . '>';

                if (($ishow == 'yes') && ($idir == 'row')) {
                    echo '<div class="btn_icon">';

                    \Elementor\Icons_Manager::render_icon($button[$id . '_icon'], ['aria-hidden' => 'true']);

                    echo '</div>';
                    echo '<div class="btn_text">' . $text . '</div>';
                } elseif (($ishow == 'yes') && ($idir == 'row-reverse')) {
                    echo '<div class="btn_text">' . $text . '</div>';
                    echo '<div class="btn_icon">';
                    \Elementor\Icons_Manager::render_icon($button[$id . '_icon'], ['aria-hidden' => 'true']);
                    echo '</div>';
                } else {
                    echo $text;
                }
            }

            echo '</a></div>';
        }
    }
    protected function content_template()
    {
    }
}
