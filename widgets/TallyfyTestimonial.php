<?php

// Tallyfy Testimonial Widget

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

//require_once(__DIR__ . '/basic_meta_box.php');

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class TallyfyTestimonial extends Widget_Base
{
    public function get_meta_data($field, $id = false)
    {
        $meta = get_field($field, $id, false);
        return $meta;
    }

    public function get_taxes($post_type)
    {
        $taxonomies = get_object_taxonomies($post_type);
        return $taxonomies;
    }

    public function get_all_postTypes()
    {
        $items = [];
        $ignors = ['attachment', 'elementor_library', 'elementor-thhf'];
        $args = array(
            'public'   => true,
            'capability_type' => 'post',
        );
        $post_types = get_post_types($args, 'objects');
        foreach ($ignors as $ignor) {
            unset($post_types[$ignor]);
        }


        if ($post_types) {
            foreach ($post_types  as $post_type) {
                $k = $post_type->name;
                $v = $post_type->label;
                $items[$k] = esc_html__($v, 'nesar-widgets');
            }

            return $items;
        }
    }

    public function get_style_depends()
    {
        wp_register_style('nesar_wid_testimonial', plugin_dir_url(__DIR__) . 'style/TallyfyTestimonial.css');
        return [
            'nesar_wid_testimonial'
        ];
    }
    public function get_script_depends()
    {
        wp_register_script('nesar_testimonial_cat_filter', plugin_dir_url(__DIR__) . 'js/wid_testimonial_cat_filter.js');
        wp_register_script('nesar_testimonial_cat_filter_plugin', plugin_dir_url(__DIR__) . 'js/mixitup.min.js');
        return [
            'nesar_testimonial_cat_filter_plugin',
            'nesar_testimonial_cat_filter',
        ];
    }
    public function get_name()
    {
        return 'tallyfy_testimonial';
    }
    public function get_title()
    {
        return esc_html__('Tallyfy Testimonial', 'nesar-widgets');
    }
    public function get_icon()
    {
        return 'eicon-testimonial-carousel';
    }
    public function get_categories()
    {
        return ['basic'];
    }



    protected function register_controls()
    {
        $this->start_controls_section(
            'settigns_section',
            [
                'label' => esc_html__('Settings', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $postTypes = $this->get_all_postTypes();

        $first_value = reset($postTypes);
        $this->add_control(
            'post_types',
            [
                'label' => esc_html__('Select Post Type', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $postTypes,
            ]
        );
        $this->add_control(
            'show_cats',
            [
                'label' => esc_html__('Show Filter', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'nesar-widgets'),
                'label_off' => esc_html__('Off', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'heading_link',
            [
                'label' => esc_html__('Heading Link', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('on', 'nesar-widgets'),
                'label_off' => esc_html__('Off', 'nesar-widgets'),
                'return_value' => 'on',
                'default' => 'off',
            ]
        );
        $this->add_control(
            'show_link',
            [
                'label' => esc_html__('Show Link', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'nesar-widgets'),
                'label_off' => esc_html__('Hide', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'link_text',
            [
                'label' => esc_html__('Link Text', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'nesar-widgets'),
                'placeholder' => esc_html__('Type text for link', 'nesar-widgets'),
                'condition' => ['show_link' => 'yes']
            ]
        );

        $this->end_controls_section();

        //End of Settings Section -----------------------------------------------


        $this->start_controls_section(
            'container_style',
            [
                'label' => esc_html__('Container Style'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Card Columns', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['pcs'],
                'range' => [
                    'pcs' => [
                        'min' => 1,
                        'max' => 6,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'pcs',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_containers' => 'grid-template-columns:repeat({{SIZE}}, minmax(0, 1fr))',
                ],
            ]
        );

        $this->add_responsive_control(
            'spacing',
            [
                'label' => esc_html__('Card Spacing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['em'],
                'range' => [
                    'em' => [
                        'min' => 1,
                        'max' => 6,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_containers' => 'gap:{{SIZE}}{{UNIT}}',

                ],
            ]
        );


        $this->add_responsive_control(
            'card_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Card Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__('Card Border', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tallyfy_item',
            ]
        );
        $this->add_control(
            'border_rad',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Corner Radious', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'column_shadow',
                'label' => esc_html__('Card Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tallyfy_item',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section( //Filter Settings Start
            'filter_style',
            [
                'label' => esc_html__('Filter'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'filter_typography',
                'label' => esc_html__('Font', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tallyfy_cat',
            ]
        );
        $this->add_responsive_control(
            'filter_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',


                ],
            ]
        );
        $this->add_responsive_control(
            'filter_x_gap',
            [
                'label' => esc_html__('Horizontal Spacing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'step' => 1,
                'default' => 1,
            ]
        );
        $this->add_responsive_control(
            'filter_y_gap',
            [
                'label' => esc_html__('Vertical Spacing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'step' => 1,
                'default' => 1,
            ]
        );
        $this->add_control(
            'hr2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->start_controls_tabs(
            'filter_tabs'
        );
        $this->start_controls_tab(
            'filter_normal_tab',
            [
                'label' => esc_html__('Normal', 'plugin-name'),
            ]
        );
        $this->add_control(
            'filter_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_cat' => 'color: {{VALUE}}',
                ],
                'default' => '#333',
            ]
        );
        $this->add_control(
            'filter_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_cat' => 'background-color: {{VALUE}}',
                ],
                'default' => null,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filter_border',
                'label' => esc_html__('Border', 'plugin-name'),
                'selector' => '{{WRAPPER}} .tallyfy_cat',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'filter_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tallyfy_cat',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'filter_h_tab',
            [
                'label' => esc_html__('Hover', 'plugin-name'),
            ]
        );
        $this->add_control(
            'filter_h_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_cat:hover' => 'color: {{VALUE}}',
                ],
                'default' => '#3fb65b',

            ]
        );
        $this->add_control(
            'filter_h_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_cat:hover' => 'background-color: {{VALUE}}',
                ],
                'default' => null,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filter_h_border',
                'label' => esc_html__('Border', 'plugin-name'),
                'selector' => '{{WRAPPER}} .tallyfy_cat:hover',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'filter_h_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tallyfy_cat:hover',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'filter_a_tab',
            [
                'label' => esc_html__('Active', 'plugin-name'),
            ]
        );
        $this->add_control(
            'filter_a_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_cat.active' => 'color: {{VALUE}}',
                ],
                'default' => '#3fb65b',

            ]
        );
        $this->add_control(
            'filter_a_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_cat.active' => 'background-color: {{VALUE}}',
                ],
                'default' => null,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filter_a_border',
                'label' => esc_html__('Border', 'plugin-name'),
                'selector' => '{{WRAPPER}} .tallyfy_cat.active',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'filter_a_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tallyfy_cat.active',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_responsive_control(
            'filter_rad',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Border
        $this->add_control(
            'hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_responsive_control(
            'filter_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_catFilter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_align',
            [
                'label' => esc_html__('Alignment', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'plugin-name'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'plugin-name'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'plugin-name'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'plugin-name'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,

            ]
        );

        $this->end_controls_section();  //Heading Settings End

        $this->start_controls_section( //Heading Settings Start
            'heading_style',
            [
                'label' => esc_html__('Heading'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Font', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tallyfy_item_title',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item_title' => 'color: {{VALUE}}',
                ],
                'default' => '#68717e',

            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        //Start of Sub Heading style Settings
        $this->start_controls_section(
            'subTitle_style',
            [
                'label' => esc_html__('Sub Heading'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'subTitle_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item_subTitle' => 'color: {{VALUE}}',
                ],
                'default' => '#68717e',

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subTitle_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .tallyfy_item_subTitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item_subTitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        //Start of Message Text style Settings
        $this->start_controls_section(
            'message_style',
            [
                'label' => esc_html__('Message'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ],
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'message_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .tallyfy_item_body .msg',
            ]
        );
        $this->add_control(
            'message_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item_body .msg' => 'color: {{VALUE}}',
                ],
                'default' => '#505b6a',

            ]
        );
        $this->add_responsive_control(
            'message_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item_body .msg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',


                ],
            ]
        );
        $this->end_controls_section();

        //Start of Link Text style Settings
        $this->start_controls_section(
            'link_style',
            [
                'label' => esc_html__('Link Text'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_link' => 'yes']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .tallyfy_item_footer',
            ]
        );
        $this->add_control(
            'link_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item_footer' => 'color: {{VALUE}}',
                ],
                'default' => '#3fb65b',

            ]
        );
        $this->add_responsive_control(
            'link_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tallyfy_item_footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Choose icon', 'nesar-widgets'),
                'label_block' => false,
                'type' => \Elementor\Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => 'svg',
                'default' => [
                    'value' => 'icon icon-quote1',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['em'],
                'range' => [
                    'em' => [
                        'min' => 1.5,
                        'max' => 6,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-wrapper' => 'font-size:{{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'icon_horizontal_margin',
            [
                'label' => esc_html__('Icon horizontal position', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['em'],
                'range' => [
                    'em' => [
                        'min' => -2,
                        'max' => 2,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => -0.25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-wrapper' => 'top:{{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'icon_vertical_margin',
            [
                'label' => esc_html__('Icon vertical Position', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['em'],
                'range' => [
                    'em' => [
                        'min' => -2,
                        'max' => 2,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => -0.25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-wrapper' => 'left:{{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .icon-wrapper' => 'color: {{VALUE}}',
                ],
                'default' => '#f3f4f5',
            ]
        );
        $this->add_control(
            'icon_align',
            [
                'label' => esc_html__('Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
            ]
        );
        $this->end_controls_section();
    }

    protected function tf_tax_query($slug)
    {
        $taxonomies = get_object_taxonomies($slug, 'names');
        return $taxonomies[0];
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slug_name = $settings['post_types'];
        $show_cats = $settings['show_cats'];
        $filter_align = $settings['filters_align'];
        $filter_x_gap = $settings['filter_x_gap'];
        $filter_y_gap = $settings['filter_y_gap'];



        if ($slug_name !== "") {
            $taxan = $this->tf_tax_query($slug_name);
            $args = [
                'post_type' => $slug_name,
                'posts_per_page' => -1,
                'orderby'          => 'date',
                'order'            => 'DESC',
            ];
            $all_posts = new \WP_Query($args);

            if ($all_posts->have_posts()) :

                //Start of filter section
                if ($show_cats === "yes") {
                    $tax = $this->get_taxes($slug_name);
                    $terms = get_terms(array(
                        'taxonomy' => $taxan,
                        'hide_empty' => true,
                        'orderby' => 'name',
                    ));
                    $tax_terms = get_terms($tax, array('hide_empty' => false));
                    $terms_list = [];
                    echo '<div class="tallyfy_catFilter controls ' . $filter_align . '" style="column-gap:' . $filter_x_gap . 'em;row-gap:' . $filter_y_gap . 'em;">';
                    foreach ($terms as $term) {
                        $terms_list[] = $term->slug;
                        echo '<div class="tallyfy_cat control " data-filter=".' . $term->slug . '">' . $term->name . '</div>';
                    }
                    echo '<div class="tallyfy_cat control" data-filter="all">All</div>';
                    echo '</div>';
                }
                //end of filter section
                echo '<div style="clear:both;"></div>';
                echo '<div class="tallyfy_containers">'; // Start Card Container


                // Start loop
                while ($all_posts->have_posts()) : $all_posts->the_post();
                    $id = get_the_ID();
                    $view = $this->get_meta_data('link_check_value', $id);
                    $msg = $this->get_meta_data('user_review', $id);
                    $ico = $settings['icon'];
                    if (!in_array($msg, array(" ", "", '', null))) {
                        $cats = '';
                        if ($show_cats === "yes") {
                            $terms_byPOst = get_the_terms($id, $taxan);
                            if ($terms_byPOst && !is_wp_error($terms_byPOst)) {

                                foreach ($terms_byPOst as $tbp) {
                                    $cats_list[] = $tbp->slug;
                                }
                                $cats = join(" ", $cats_list);
                            }
                        } ?>
                        <div class="tallyfy_item mix <?php echo $cats; ?>">

                            <div class="tallyfy_item_body">
                                <p class="msg"><?php echo $msg; ?></p>
                                <div class="icon-wrapper">
                                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                                </div>

                            </div>
                            <?php
                            if ('on' !== $settings['heading_link']) {
                            ?>
                                <div class="tallyfy_item_title"><?php echo $this->get_meta_data('user_name', $id); ?></div>
                            <?php
                            } else { ?>
                                <a href="<?php the_permalink(); ?>" class="tallyfy_item_title"><?php echo $this->get_meta_data('user_name', $id); ?></a>
                            <?php } ?>
                            <p class="tallyfy_item_subTitle"><?php echo $this->get_meta_data('user_designation', $id); ?></p>

                            <?php
                            if (('yes' === $settings['show_link']) && !in_array($view, array('Off', 'off'))) {
                            ?>
                                <a class="tallyfy_item_footer" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $settings['link_text']; ?></a>
                            <?php
                            } ?>


                        </div>

                <?php
                    }
                // End entry loop
                endwhile; ?>
                </div>
<?php
                wp_reset_postdata();
            endif;
        }
    }
}
