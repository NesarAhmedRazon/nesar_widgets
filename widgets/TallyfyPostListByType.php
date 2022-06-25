<?php

/**
 * Tallyfy Post List By Type Widget

 */

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}


class TallyfyPostListByType extends Widget_Base
{
    public function get_style_depends()
    {
        wp_register_style('nesar_post_list_by_type', plugin_dir_url(__DIR__) . 'style/decor_post_list_by_type.css');
        return [
            'nesar_post_list_by_type'
        ];
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
    public function get_name()
    {
        return 'tallyfy_post_list_by_type';
    }
    public function get_title()
    {
        return esc_html__('Tallyfy Post List', 'nesar-widgets');
    }
    public function get_icon()
    {
        return 'eicon-post-list';
    }
    public function get_categories()
    {
        return ['basic'];
    }

    public function post_settings()
    {
        $id = 'nw';
        $postTypes = $this->get_all_postTypes();
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__('Settings', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'post_types',
            [
                'label' => esc_html__('Select Post Type', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $postTypes,
            ]
        );

        $this->add_control(
            'post_skin_type',
            [
                'label' => esc_html__('Skin', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'list',
                'options' => [
                    'list'  => esc_html__('List', 'nesar-widgets'),
                    'time_line' => esc_html__('Time Line', 'nesar-widgets'),
                ],
            ]
        );
        $this->add_control(
            'post_order',
            [
                'label' => esc_html__('Order', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC'  => esc_html__('Ascending ', 'nesar-widgets'),
                    'DESC' => esc_html__('Descending ', 'nesar-widgets'),
                ],
            ]
        );
        $this->add_control(
            'post_orderby',
            [
                'label' => esc_html__('Order By', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'ID'  => esc_html__('ID', 'nesar-widgets'),
                    'title' => esc_html__('Title', 'nesar-widgets'),
                    'date' => esc_html__('Date', 'nesar-widgets'),
                ],
            ]
        );
        $this->end_controls_section();
    }
    public function TimeLine_skin_control()
    {
        $id = 'post_skin';
        $postTypes = $this->get_all_postTypes();

        $this->start_controls_section(
            $id,
            [
                'label' => esc_html__('Time Line', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'post_skin_type' => 'time_line'
                ],
            ]
        );



        $this->add_control(
            $id . '_container_options',
            [
                'label' => esc_html__('Container Options', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,

            ]
        );
        $this->add_responsive_control(
            $id . '_align',
            [
                'label' => esc_html__('Content Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => ' eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .time_line_post' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => $id . '_bg_color',
                'label' => esc_html__('Background', 'nesar-widgets'),
                'types' => ['classic', 'gradient',],
                'selector' => '{{WRAPPER}} .time_line_post',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => ['default' => '#f8fafc'],
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $id . '_bg_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .time_line_post',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'color' => ['default' => '#e2e8f0'],
                    'width' => [
                        'default' => [
                            'top' => '0',
                            'bottom' => '1',
                            'left' => '0',
                            'right' => '0',
                            'isLinked' => false,
                        ]
                    ],
                ],

            ]
        );
        $this->add_responsive_control(
            $id . '_bg_radious',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Corner Radious', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .time_line_post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id . '_bg_shadows',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .time_line_post',
            ]
        );
        $this->add_responsive_control(
            $id . '_bg_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .time_line_post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '2',
                    'bottom' => '2',
                    'left' => '1',
                    'right' => '1',
                    'unit' => 'em',
                    'isLinked' => true,
                ],


            ]
        );
        $this->add_responsive_control(
            $id . '_bg_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .time_line_post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '1',
                    'left' => '0',
                    'right' => '0',
                    'unit' => 'em',
                    'isLinked' => false,
                ],


            ]
        );
        $this->add_control(
            $id . '_date_options',
            [
                'label' => esc_html__('Date Options', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',

            ]
        );
        $this->add_control(
            $id . '_date_formate',
            [
                'label' => esc_html__('Formate', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'  => esc_html__('March 17, 2022', 'nesar-widgets'),
                    '2' => esc_html__('Mar 17, 22', 'nesar-widgets'),
                    '3' => esc_html__('YYYY-MM-DD', 'nesar-widgets'),
                    '4' => esc_html__('MM/DD/YYYY', 'nesar-widgets'),
                    '5' => esc_html__('DD/MM/YYYY', 'nesar-widgets'),
                ],

            ]
        );
        $this->add_responsive_control(
            $id . '_date_direction',
            [
                'label' => esc_html__('Position ', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column' => [
                        'title' => esc_html__('Top', 'nesar-widgets'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'row' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .time_line_post' => 'flex-direction: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            $id . '_date_color',
            [
                'label' => esc_html__('Date Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .tl_date' => 'color: {{VALUE}}',
                ],



            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_date_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .tl_date',
                'exclude' => ['text_decoration', 'line_height', 'word_spacing'],

            ]
        );

        $this->add_control(
            $id . '_title_options',
            [
                'label' => esc_html__('Title Options', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',

            ]
        );
        $this->add_control(
            $id . '_title_color',
            [
                'label' => esc_html__('Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tl_title' => 'color: {{VALUE}}',
                ],
                'default' => '#334155',


            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_title_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .tl_title',
                'exclude' => ['text_decoration'],
                'default' => [
                    'font_weight' => '600',
                ],
            ]
        );
        $this->add_responsive_control(
            $id . '_title_margin',
            [
                'label' => esc_html__('Bottom Margin', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [

                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tl_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            $id . '_excerpt_options',
            [
                'label' => esc_html__('Excerpt Options', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            $id . '_excerpt_color',
            [
                'label' => esc_html__('Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tl_excerpt' => 'color: {{VALUE}}',
                ],
                'default' => '#64748b',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_excerpt_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .tl_excerpt',
                'exclude' => ['text_decoration'],
            ]
        );
        $this->add_responsive_control(
            $id . '_excerpt_margin',
            [
                'label' => esc_html__('Bottom Margin', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [

                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tl_excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            $id . '_button_options',
            [
                'label' => esc_html__('Button Options', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_button_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .tl_button',
                'exclude' => ['line_height', 'word_spacing'],
                'fields_options' => [
                    'font_weight' => [
                        'default' => '600',
                    ],
                    'font_size' => [
                        'default' => [
                            'size' => '1',
                            'unit' => 'em',
                        ],
                    ],
                    'text_decoration' => [
                        'default' => 'none',
                    ],
                ],
            ]
        );
        $this->start_controls_tabs(
            $id . '_tabs',
            [
                'condition' => [
                    'post_skin_type' => 'time_line'
                ],
            ]
        );
        $this->start_controls_tab(
            $id . '_normal_tab',
            [
                'label' => esc_html('Normal', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_n_button_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tl_button' => 'color: {{VALUE}}',
                ],
                'default' => '#fff',

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => $id . '_n_bg_color',
                'label' => esc_html__('Background', 'nesar-widgets'),
                'types' => ['classic', 'gradient',],
                'selector' => '{{WRAPPER}} .tl_button',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => ['default' => '#cbd5e1'],
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id . '_n_shadows',
                'separator' => 'before',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tl_button',
                'fields_options' => [
                    'box_shadow' => [
                        'default' =>
                        [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 10,
                            'spread' => 1,
                            'color' => 'rgba(0,0,0,0.1)'
                        ]
                    ]
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $id . '_n_button_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tl_button',

            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            $id . '_hover_tab',
            [
                'label' => esc_html('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_h_button_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tl_button:hover' => 'color: {{VALUE}}',
                ],
                'default' => '#fff',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => $id . '_h_bg_color',
                'label' => esc_html__('Background', 'nesar-widgets'),
                'types' => ['classic', 'gradient',],
                'selector' => '{{WRAPPER}} .tl_button:hover',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => ['default' => '#94a3b8'],
                ],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id . '_h_shadows',
                'separator' => 'before',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tl_button:hover',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $id . '_h_button_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tl_button:hover',

            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            $id . '_button_radious',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Corner Radious', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tl_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            $id . '_button_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tl_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0.7',
                    'bottom' => '0.7',
                    'left' => '2',
                    'right' => '2',
                    'unit' => 'em',
                    'isLinked' => false,
                ],


            ]
        );
        $this->end_controls_section();
    }
    public function List_skin_control()
    {
        $id = 'link';
        $this->start_controls_section(
            $id . '_style',
            [
                'label' => esc_html__('List', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'post_skin_type' => 'list'
                ],

            ]
        );
        $this->add_control(
            $id . '_container_options',
            [
                'label' => esc_html__('Container Options', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,

            ]
        );
        $this->add_responsive_control(
            $id . '_column_count',
            [
                'label' => esc_html__('Columns', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 6,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .list_post' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
                ],

            ]
        );
        $this->add_responsive_control(
            $id . '_c_gap',
            [
                'label' => esc_html__('Column Spacing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .list_post' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            $id . '_r_gap',
            [
                'label' => esc_html__('Row Spacing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .list_post' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control(
            $id . '_text_options',
            [
                'label' => esc_html__('Title Options', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_font',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .post',
                'exclude' => ['line_height', 'word_spacing'],
                'fields_options' => [
                    'font_weight' => [
                        'default' => '700',
                    ],
                    'font_size' => [
                        'default' => [
                            'size' => '1.5',
                            'unit' => 'em',
                        ],
                    ],
                ],

            ]
        );
        $this->start_controls_tabs(
            $id . '_text_tabs'
        );
        $this->start_controls_tab(
            $id . '_text_normal_tab',
            [
                'label' => esc_html('Normal', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_text_n_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post ' => 'color: {{VALUE}}',
                ],
                'default' => '#3FB65B',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            $id . '_text_hover_tab',
            [
                'label' => esc_html('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_text_h_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post:hover ' => 'color: {{VALUE}}',
                ],
                'default' => '#3fb65b',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            $id . '_icon_options',
            [
                'label' => esc_html__('Icon Options', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',

            ]
        );
        $this->add_control(
            $id . '_icon',
            [
                'label' => esc_html__('Icon', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'eicon-post',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_responsive_control(
            $id . '_icon_size',
            [
                'label' => esc_html__('Size', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            $id . '_icon_gap',
            [
                'label' => esc_html__('Spacing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->start_controls_tabs(
            $id . '_icon_tabs'
        );
        $this->start_controls_tab(
            $id . '_icon_normal_tab',
            [
                'label' => esc_html('Normal', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_icon_n_color',
            [
                'label' => esc_html__('Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .icon-wrapper ' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            $id . '_icon_hover_tab',
            [
                'label' => esc_html('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_icon_h_color',
            [
                'label' => esc_html__('Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .icon-wrapper:hover ' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_controls()
    {
        $this->post_settings();
        $this->TimeLine_skin_control();
        $this->List_skin_control();
    }



    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $type = $settings['post_types'];
        $skin = $settings['post_skin_type'];
        $postTypes = $this->get_all_postTypes();

        if ($skin == 'time_line') {
            $this->skin_time_line($type);
        } else {
            $this->skin_list($type);
        }
    }

    protected function content_template()
    {
    }

    protected function wp_post_list($slug_name, $order = 'ASC', $orderby = 'date')
    {
        $args = [
            'post_type' => $slug_name,
            'posts_per_page' => -1,
            'orderby'          => $orderby,
            'order'            => $order,
        ];
        return $all_posts = new \WP_Query($args);
    }
    protected function post_list($slug_name, $order = 'ASC', $orderby = 'date')
    {
        $args = [
            'post_type' => $slug_name,
            'posts_per_page' => -1,
            'orderby'          => $orderby,
            'order'            => $order,
        ];
        $all_posts = get_posts($args);
        return $all_posts;
    }
    public function skin_time_line($slug)
    {
        $st = $this->get_settings_for_display();
        $order = $st['post_order'];
        $orderby = $st['post_orderby'];
        $posts = $this->post_list($slug, $order, $orderby);

        echo '<div class="time_line">';
        foreach ($posts as $post) {
            //var_dump($post);
            switch (intval($st['post_skin_date_formate'])) {
                case 1:
                    $date = date("F j, Y", strtotime($post->post_date));
                    break;
                case 2:
                    $date = date("M j, Y", strtotime($post->post_date));
                    break;
                case 3:
                    $date = date("Y-m-d", strtotime($post->post_date));
                    break;
                case 4:
                    $date = date("m/d/Y", strtotime($post->post_date));
                    break;
                case 5:
                    $date = date("d/m/Y", strtotime($post->post_date));
                    break;
                default:
                    $date = date("F j, Y", strtotime($post->post_date));
                    break;
            }

            echo '<div class="time_line_post">';
            echo '<div class="tl_date">' . $date . '</div>';
            echo '<div class="tl_content">';
            echo '<h2 class="tl_title">' . $post->post_title . '</h2>';
            echo '<p class="tl_excerpt">' . $post->post_content . '</p>';
            echo '<a href="' . esc_url(get_permalink($post->ID)) . '" class="tl_button">Details</a>';

            echo '</div>';

            echo '</div>';
        }
        echo '<div class="content">';
        $all_posts = $this->wp_post_list($slug, $order, $orderby);
        if ($all_posts->have_posts()) :
            while ($all_posts->have_posts()) : $all_posts->the_post();
            // var_dump(the_content());
            endwhile;
        endif;
        echo '</div>';
        echo '</div>';
    }
    public function skin_list($slug)
    {
        $st = $this->get_settings_for_display();
        $order = $st['post_order'];
        $orderby = $st['post_orderby'];
        $posts = $this->post_list($slug, $order, $orderby);
        $icon = $st['link_icon'];

        echo '<div class="list_post">';
        foreach ($posts as $post) {
            echo '<div class="post">';
            echo '<div class="icon-wrapper" >';
            \Elementor\Icons_Manager::render_icon($st['link_icon'], ['aria-hidden' => 'true']);
            echo '</div>';
            echo '<a class=" link" title="' . $post->post_title . '" href="' . esc_url(get_permalink($post->ID)) . '">' . $post->post_title . '</a>';
            echo '</div>';
        }
        echo '</div>';
    }
}
