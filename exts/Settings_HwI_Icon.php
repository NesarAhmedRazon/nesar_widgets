<?php

namespace WPC\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class Settings extends HeadingWithIcon
{
    public function icon_setings($args = [])
    {
        $disable = [];
        if (!empty($args['tab'])) {
            $tab = $args['tab'];
        } else {
            $tab = \Elementor\Controls_Manager::TAB_CONTENT;
        }

        $title = $args['label'];
        $id = $args['id'];
        $class = $args['selector'];
        $add = $args['settings'];
        if (isset($args['id'])) {
            $id = $args['id'];
        }
        if (isset($args['remove'])) {
            $disable = $args['remove'];
        }
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__($title, 'nesar-widgets'),
                'tab' => $tab,
            ]
        );
        $this->add_control(
            $id . '_type',
            [
                'label' => esc_html__('Icon Type ', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'text' => [
                        'title' => esc_html__('Text', 'nesar-widgets'),
                        'icon' => 'eicon-text-area',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'nesar-widgets'),
                        'icon' => 'eicon-star',
                    ],
                    'ban' => [
                        'title' => esc_html__('No Icon', 'nesar-widgets'),
                        'icon' => 'eicon-ban',
                    ],
                ],
                'default' => 'icon',
                'toggle' => false,


            ]
        );

        $this->add_control(
            $id . '_icon',
            [
                'label' => esc_html__('Icon', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'condition' => [$id  . '_type' => 'icon'],
            ],
        );
        $this->add_control(
            $id . '_text',
            [
                'label' => esc_html__('Text Input', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Your Text', 'nesar-widgets'),
                'placeholder' => esc_html__('Type your text here', 'nesar-widgets'),
                'condition' => [$id  . '_type' => 'text'],
            ]
        );
        $this->add_control(
            $id . '_color',
            [
                'label' => esc_html__('Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $class['child'] => 'color: {{VALUE}}',
                ],
                'default' => '#6d7882',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            $id . '_direction',
            [
                'label' => esc_html__('Position ', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column' => [
                        'title' => esc_html__('Stack', 'nesar-widgets'),
                        'icon' => 'eicon-ellipsis-v',
                    ],
                    'row' => [
                        'title' => esc_html__('Side by Side', 'nesar-widgets'),
                        'icon' => 'eicon-ellipsis-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $class['parent'] => 'flex-direction: {{VALUE}}',
                ],
                'default' => 'row',
                'toggle' => false,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                    ],
                ],

            ]
        );

        $this->add_control(
            $id . '_dirtb',
            [
                'label' => esc_html__('Placement ', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'nesar-widgets'),
                        'icon' => 'nw-icon_top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'nesar-widgets'),
                        'icon' => 'nw-icon_bot',
                    ],
                ],
                'default' => 'start',
                'toggle' => false,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                        [
                            'name' => $id  . '_direction',
                            'operator' => '==',
                            'value' => 'column',
                        ],
                    ],
                ],

            ]
        );
        $this->add_control(
            $id . '_dirlr',
            [
                'label' => esc_html__('Placement ', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'nw-icon_left',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'nw-icon_right',
                    ],
                ],
                'default' => 'start',
                'toggle' => false,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],

                        [
                            'name' => $id  . '_direction',
                            'operator' => '==',
                            'value' => 'row',
                        ],
                    ],
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .' . $class['child'],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '==',
                            'value' => 'text',
                        ],
                    ],
                ],

            ]
        );
        $this->add_responsive_control(
            $id . '_icon_size',
            [
                'label' => esc_html__('Icon Size', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [

                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $class['child']  => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '==',
                            'value' => 'icon',
                        ],
                    ],
                ],

            ]
        );

        $this->add_control(
            $id . '_bg_color',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $class['child'] => 'background-color: {{VALUE}}',
                ],
                'default' => '',
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                    ],
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $id . '_border',
                'label' => esc_html__(
                    'Border',
                    'nesar-widgets'
                ),
                'selector' => '{{WRAPPER}}  .' . $class['child'],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                    ],
                ],
            ]
        );
        $this->add_control(
            $id . '_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,

                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                    ],
                ],
            ]

        );
        $this->add_responsive_control(
            $id . '_cornerRadius',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'nesar-widgets'),
                'size_units' => ['em', 'px', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $class['child'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'right' => '5',
                    'unit' => 'em',
                    'isLinked' => false,
                ],

                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                    ],
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
                    '{{WRAPPER}} .' . $class['child'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0.5',
                    'bottom' => '0.5',
                    'left' => '0.5',
                    'right' => '0.5',
                    'unit' => 'em',
                    'isLinked' => true,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            $id . '_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $class['child'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'bottom' => '1',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => $id  . '_type',
                            'operator' => '!=',
                            'value' => 'ban',
                        ],
                    ],
                ],
            ]
        );
        $this->end_controls_section();
    }

    public function heading_setings($args = [])
    {
        $disable = [];
        if (!empty($args['tab'])) {
            $tab = $args['tab'];
        } else {
            $tab = \Elementor\Controls_Manager::TAB_CONTENT;
        }

        $title = $args['label'];
        $id = $args['id'];
        $class = $args['selector'];
        $add = $args['settings'];
        if (isset($args['id'])) {
            $id = $args['id'];
        }
        if (isset($args['remove'])) {
            $disable = $args['remove'];
        }
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__($title, 'nesar-widgets'),
                'tab' => $tab,
                'condition' => [
                    'ti_settings_icon_only!' => 'yes'
                ],
            ]
        );
        $this->add_control(
            $id . '_text',
            [
                'label' => esc_html__('Title', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('The Title', 'nesar-widgets'),
                'placeholder' => esc_html__('Type your title here', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'div',
                'options' => [
                    'h1'  => esc_html__('H1', 'nesar-widgets'),
                    'h2' => esc_html__('H2', 'nesar-widgets'),
                    'h3' => esc_html__('H3', 'nesar-widgets'),
                    'h4' => esc_html__('H4', 'nesar-widgets'),
                    'h5' => esc_html__('H5', 'nesar-widgets'),
                    'h6' => esc_html__('H6', 'nesar-widgets'),
                    'div' => esc_html__('div', 'nesar-widgets'),
                    'span' => esc_html__('span', 'nesar-widgets'),
                    'p' => esc_html__('p', 'nesar-widgets'),
                    'a' => esc_html__('a', 'nesar-widgets'),
                ],
            ]
        );
        $this->add_control(
            $id . '_url',
            [
                'label' => esc_html__('Link', 'nesar-widgets'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'nesar-widgets'),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
                'condition' => [$id . '_tag' => 'a'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .' . $class['child']

            ]
        );
        $this->add_control(
            $id . '_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $class['child'] => 'color: {{VALUE}}',
                ],
                'default' => '#6d7882',


            ]
        );
        $this->add_responsive_control(
            $id  . '_fill',
            [
                'label' => esc_html__('Fill', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [

                    '1' => [
                        'title' => esc_html__('Column', 'nesar-widgets'),
                        'icon' => 'eicon-grow',
                    ],
                ],
                'default' => 'unset',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .' . $class['parent'] . ' .' . $class['child'] => 'flex-grow: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            $id . '_align',
            [
                'label' => esc_html__('Alignment', 'nesar-widgets'),
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .' . $class['child'] => 'text-align: {{VALUE}}',
                ],
                'condition' => [$id  . '_fill' => '1'],
            ]
        );
        $this->add_responsive_control(
            $id . '_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $class['child'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'bottom' => '1',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();
    }
}
