<?php

//Tallyfy Heading With Icon

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}

require plugin_dir_path(NESAR_WIDGETS) . 'exts/Settings_HwI_Icon.php';
require plugin_dir_path(NESAR_WIDGETS) . 'exts/TitleIconSettings.php';

class HeadingWithIcon extends Widget_Base
{
    public function get_name()
    {
        return 'tallyfy_HeadingWithIcon';
    }
    public function get_title()
    {
        return esc_html__('Icon With Title', 'nesar-widgets');
    }
    public function get_icon()
    {
        return 'eicon-icon-box';
    }
    public function get_categories()
    {
        return ['basic'];
    }
    public function get_style_depends()
    {
        wp_register_style('nesar_wid_HeadingWithIcon', plugin_dir_url(__DIR__) . 'style/HeadingWithIcon.css');
        return [
            'nesar_wid_HeadingWithIcon'
        ];
    }
    protected function register_controls()
    {
        $tis = new TitleIconSettings();
        $tis->buttonSettings([
            'id' => 'ti_settings',
            'label' => 'Settings',
            'selector' => [
                'parent' => 'hIcon',
                'child' => 'hIcon_title',
            ],
        ]);
        $hs = new Settings();
        $hs->heading_setings(
            [
                'id' => 'heading',
                'label' => 'Heading',
                'selector' => [
                    'parent' => 'hIcon',
                    'child' => 'hIcon_title',
                ],
                'settings' => ['link', 'text_style', 'background', 'spacing'],
                'remove' => ['padding']
            ]
        );
        $is = new Settings();
        $is->icon_setings(
            [
                'id' => 'heading_icon',
                'label' => 'Icon',
                'selector' => [
                    'parent' => 'hIcon',
                    'child' => 'hIcon_icon',
                ],
                'settings' => ['link', 'text_style', 'background', 'spacing'],
                'remove' => ['padding']
            ]
        );
    }

    protected function render()
    {
        $set = $this->get_settings_for_display();
        $tcls = 'ti_settings';
        $iclass = 'heading_icon';

        $uline = $set[$tcls . '_underline'];
        $text = $set['heading_text'];
        $type = $set[$iclass . '_type'];
        $dir = $set[$iclass . '_direction'];
        $plcTb = $set[$iclass . '_dirtb'];
        $plcLr = $set[$iclass . '_dirlr'];
        $icoOnly = $set[$tcls . '_icon_only'];
        $pos = '';

        if ($plcTb == 'start' || $plcLr == 'start') {
            $pos = 'start';
        } elseif ($plcTb == 'end' || $plcLr == 'end') {
            $pos = 'end';
        }
        echo '<div class="hIcon">';
        if ($pos == 'start') {
            $this->make_icon($type, $iclass);
        }
        if ($icoOnly != 'yes') {
            $tag = $set['heading_tag'];
            if ($tag == 'a') {
                $url = $set['heading_url']['url'];
            }
            echo '<' . $tag . ($tag == 'a' ? (' href="' . $url . '"') : '') . ' class="hIcon_title' . ($uline == 'yes' ? ' uline' : '') . '">' . $text . '</' . $tag . '>';
        }
        if ($pos == 'end') {
            $this->make_icon($type, $iclass);
        }
        echo '</div>';
    }

    public function make_icon($type, $class)
    {
        $set = $this->get_settings_for_display();
        echo '<div class="hIcon_icon">';
        switch ($type) {
            case 'icon':
                \Elementor\Icons_Manager::render_icon($set[$class . '_icon'], ['aria-hidden' => 'true']);
                break;
            case 'text':
                echo '<span>' . $set[$class . '_text'] . '</span>';
                break;
            default:
                break;
        }
        echo '</div>';
    }
}
