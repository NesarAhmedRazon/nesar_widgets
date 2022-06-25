<?php

//List With Paragraph

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}


class List_Paragraph extends Widget_Base
{
    public function get_name()
    {
        require_once(__DIR__ . '/../exts/ListParagraphControl.php');
        return 'nesar_list_paragraph';
    }
    public function get_title()
    {
        return esc_html__('Paragraph List', 'nesar-widgets');
    }
    public function get_icon()
    {
        return 'nw-list-paragraph';
    }
    public function get_categories()
    {
        return ['basic'];
    }
    public function get_style_depends()
    {
        wp_register_style('nesar_wid_listpara', plugin_dir_url(__DIR__) . 'style/List_Paragraph.css');
        return [
            'nesar_wid_listpara'
        ];
    }
    // public function get_script_depends()
    // {

    //     wp_register_script('nesar_wid_listpara', plugins_url('../js/List_Paragraph.js', __FILE__));
    //     return [
    //         'nesar_wid_listpara',
    //     ];
    // }

    protected function register_controls()
    {
        $id = 'nw_para_list';
        $control = new ListParagraphControl();


        $control->the_list(
            [
                'id' => $id,
                'label' => 'The List',
                'selector' => '.lTitle',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $control->paraList_settings(
            [
                'id' => $id,
                'label' => 'List Settings',
                'selector' => [
                    'parent' => '.uList',
                    'child' => '.lItem'
                ],
            ]
        );
        $control->icon_settings(
            [
                'id' => $id . '_i',
                'label' => 'Icon',
                'selector' => '.listIcon',
            ]
        );
        $control->text_settings(
            [
                'id' => $id . '_h',
                'label' => 'Heading',
                'selector' => '.lTitle',
                'add' => ['tag', 'margin', 'color', 'font'],
            ]
        );
        $control->text_settings(
            [
                'id' => $id . '_p',
                'label' => 'Paragraph',
                'selector' => '.lPara',
                'add' => ['align', 'color', 'font'],

            ]
        );

        $control->text_settings(
            [
                'id' => $id . '_list',
                'label' => 'Paragraph Inner List',
                'selector' => '.lPara',
                'child' => 'ol',
                'add' => ['li_indent', 'li_marker_font'],
            ]
        );
    }

    protected function render()
    {
        $id = 'nw_para_list';
        $set = $this->get_settings_for_display();
        $lists = $set[$id . '_list'];
        $tag = $set[$id . '_h_tag'];
        $listType = $set[$id . '_li_type'];
        $num = 1;

        echo '<div class="listContainer">';
        if ($lists) {
            echo '<div class="uList">';
            foreach ($lists as $list) {
                echo '<div class="lItem">';
                echo '<div class="listIcon">';
                switch ($listType) {
                    case 'icon':
                        \Elementor\Icons_Manager::render_icon($set[$id . '_li_icon'], ['aria-hidden' => 'true']);
                        break;
                    case 'num':
                        echo $num++ . '.';
                        break;
                    default:
                        break;
                }
                echo '</div>';
                echo '<div class="rCol">';
                if ($list[$id . '_t_show'] == 'yes') {
                    echo '<' . $tag . ' class="lTitle">' . $list[$id . '_title'] . '</' . $tag . '>';
                }
                if ($list[$id . '_b_show'] == 'yes') {
                    echo '<div class="lPara">' . $list[$id . '_body'] . '</div>';
                }
                echo '</div></div>';
            }
            echo '</div>';
        }
        echo '</div>';
    }
}
