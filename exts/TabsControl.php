<?php

namespace WPC\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class TabsControl extends Tabs
{
    public function get_all_postTypes()
    {
        $items = [];
        //$ignors = ['attachment', 'post', 'page'];
        $args = array(
            'public'   => true,
            'capability_type' => 'post',
        );
        $post_types = get_post_types($args, 'objects');
        // foreach ($ignors as $ignor) {
        //     unset($post_types[$ignor]);
        // }
        if ($post_types) {
            foreach ($post_types  as $post_type) {
                $k = $post_type->name;
                $v = $post_type->label;
                $items[$k] = esc_html__($v, 'nesar-widgets');
            }

            return $items;
        }
    }
    protected function post_list($order = 'ASC', $orderby = 'date')
    {
        $args = [
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
            'orderby'          => $orderby,
            'order'            => $order,
        ];
        $all_posts = get_posts($args);
        //var_dump($all_posts);
        if ($all_posts) {
            foreach ($all_posts  as $post_type) {
                $k = $post_type->ID;
                $v = $post_type->post_title;
                $items[$k] = esc_html__($v, 'nesar-widgets');
            }

            return $items;
        }
    }
    private function tabc($v)
    {
        var_dump($v);
        if ($v == 'none') {
            return 'display:block';
        }
        return 'display:none';
    }
    protected function button_settings($args)
    {
        $id = $args['id'] . '_b_';
        $class = $args['selector'];
        $title = $args['label'];
        if (!empty($args['tab'])) {
            $tab = $args['tab'];
        } else {
            $tab = \Elementor\Controls_Manager::TAB_STYLE;
        }
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__($title, 'nesar-widgets'),
                'tab' => $tab,
            ]
        );
        $this->add_control(
            $id . '_style',
            [
                'label' => esc_html__('Style', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'tabs' => [
                        'title' => esc_html__('Tab', 'nesar-widgets'),
                        'icon' => 'eicon-tabs',
                    ],
                    'accordion' => [
                        'title' => esc_html__('Accordion', 'nesar-widgets'),
                        'icon' => 'eicon-accordion',
                    ],
                ],
                'default' => 'tabs',
                'toggle' => false,
            ]
        );

        $this->add_control(
            $id . '_fill',
            [
                'label' => esc_html__('Fill', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => esc_html__('Auto Fill', 'nesar-widgets'),
                        'icon' => 'eicon-grow',
                    ],
                ],
                'default' => '',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}}  .tabItem' => 'flex-grow: {{VALUE}};flex-shrink: {{VALUE}}',
                    '{{WRAPPER}} .tabList' => 'justify-content: unset',
                ],


            ]
        );
        $this->add_control(
            $id . '_tabalign',
            [
                'label' => esc_html__('Tab Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .tabList' => 'justify-content: {{VALUE}}',
                ],
                'condition' => [$id . '_fill' => ''],
            ]
        );
        $this->add_control(
            $id . '_txtalign',
            [
                'label' => esc_html__('Text Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => ' eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .tabItem .tabText' => 'text-align: {{VALUE}}',
                ],
                'condition' => [$id . '_fill' => '1'],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .tabText',
                'exclude' => ['text_decoration', 'word_spacing'],
            ]
        );
        $this->add_control(
            $id . 'width',
            [
                'label' => esc_html__('Bar Width', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 32,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tabText::before ' => 'height: {{SIZE}}{{UNIT}};top: -{{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .tabText' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => '0.5',
                ],
            ]
        );
        $this->add_responsive_control(
            $id . '_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tabText' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0.5',
                    'bottom' => '0.5',
                    'left' => '0.5',
                    'right' => '0.5',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );

        $this->start_controls_tabs(
            $id . '_tabs'
        );
        $this->start_controls_tab(
            $id = $id . '_normal_tab',
            [
                'label' => esc_html__('Normal', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tabText' => 'color: {{VALUE}}',
                ],
                'default' => '#1e293b',

            ]
        );
        $this->add_control(
            $id . '_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tabItem' => 'background-color: {{VALUE}}',
                ],
                'default' => '#e2e8f0',
            ]
        );
        $this->add_control(
            $id . '_bar_color',
            [
                'label' => esc_html__('Bar Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tabText:before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .tabContents .tabText' => 'border-bottom-color: {{VALUE}}',
                ],
                'default' => '#94a3b8',

            ]
        );
        $this->end_controls_tab();
        // Hover Start

        $this->start_controls_tab(
            $id = $id . '_hover_tab',
            [
                'label' => esc_html__('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_h_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tabText:hover' => 'color: {{VALUE}}',
                ],
                'default' => '#1e293b',

            ]
        );
        $this->add_control(
            $id . '_h_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tabItem:hover' => 'background-color: {{VALUE}}',
                ],
                'default' => '#edeff3',
            ]
        );
        $this->add_control(
            $id . '_h_bar_color',
            [
                'label' => esc_html__('Bar Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tabText:hover:before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .tabText:hover' => 'border-bottom-color: {{VALUE}}',
                ],
                'default' => '#c2c8cf',

            ]
        );
        $this->end_controls_tab();
        // Avtive Start

        $this->start_controls_tab(
            $id = $id . '_active_tab',
            [
                'label' => esc_html__('Active', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_a_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .active .tabText' => 'color: {{VALUE}}',
                ],
                'default' => '#1e293b',

            ]
        );
        $this->add_control(
            $id . '_a_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .active' => 'background-color: {{VALUE}}',
                ],
                'default' => '#fff',
            ]
        );
        $this->add_control(
            $id . '_a_bar_color',
            [
                'label' => esc_html__('Bar Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .active .tabText:before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .active .tabText' => 'border-bottom-color: {{VALUE}}',
                ],
                'default' => '#61ce70',

            ]
        );
        $this->end_controls_tab();
        $this->end_controls_section();
    }

    protected function content_settings($args)
    {
        $id = $args['id'] . '_c_';
        $class = $args['selector'];
        $title = $args['label'];
        if (!empty($args['tab'])) {
            $tab = $args['tab'];
        } else {
            $tab = \Elementor\Controls_Manager::TAB_STYLE;
        }
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__($title, 'nesar-widgets'),
                'tab' => $tab,
            ]
        );
        $this->add_control(
            $id . '_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tabContents .tabData' => 'background-color: {{VALUE}}',
                ],
                'default' => '#f8fafc',
                'alpha' => true,


            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id . 'box_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}}',

            ]
        );
        $this->add_responsive_control(
            $id . '_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tabData' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '1',
                    'bottom' => '1',
                    'left' => '1',
                    'right' => '1',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function repeater($args)
    {
        $id = $args['id'] . '_r';
        $title = $args['label'];
        $rep = $args['repeater'];
        if (!empty($args['tab'])) {
            $tab = $args['tab'];
        } else {
            $tab = \Elementor\Controls_Manager::TAB_CONTENT;
        }
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__($title, 'nesar-widgets'),
                'tab' => $tab,
            ]
        );
        $rep = new \Elementor\Repeater();
        $rep->add_control(
            $id . '_title',
            [
                'label' => esc_html__('Title', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Tab Title', 'nesar-widgets'),
                'label_block' => false,
            ]
        );
        $posts = $this->post_list();
        //var_dump($posts);
        $rep->add_control(
            $id . '_templates',
            [
                'label' => esc_html__('Select Template', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $posts,
            ]
        );
        $this->add_control(
            $id . '_list',
            [
                'label' => esc_html__('All Tabs', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $rep->get_controls(),
                'default' => [
                    [
                        $id . '_title' => esc_html__('Tab #1', 'nesar-widgets'),

                    ],
                ],
                'title_field' => '{{{ ' . $id . '_title }}}',
            ]
        );

        $this->end_controls_section();
    }
}
