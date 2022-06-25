<?php

namespace WPC\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class BasicControls extends PricingTable
{
    public function basic_setings($args = [])
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

        if (in_array('visiblity', $add)) {
            $this->add_control(
                $id . '_show',
                [
                    'label' => esc_html__('Show ' . $title, 'nesar-widgets'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Show', 'nesar-widgets'),
                    'label_off' => esc_html__('Hide', 'nesar-widgets'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
        }
        if (in_array('text_box', $add)) {
            $this->add_control(
                $id . '_text',
                [
                    'label' => esc_html__('Text Input', 'nesar-widgets'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__('Your Text', 'nesar-widgets'),
                    'placeholder' => esc_html__('Type your text here', 'nesar-widgets'),
                ]
            );
        }

        if (in_array('group_margin', $add)) {
            if (!in_array('group_margin', $disable)) {
                $this->add_responsive_control(
                    $id . '_features_margin',
                    [
                        'type' => \Elementor\Controls_Manager::DIMENSIONS,
                        'label' => esc_html__('Margin', 'nesar-widgets'),
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .features' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        'default' => [
                            'top' => '1',
                            'unit' => 'em',
                            'isLinked' => false,
                        ],
                    ]
                );
            }
        }
        if (in_array('text_style', $add)) {
            if (!in_array('text_font', $disable)) {
                $condition = '';
                if (in_array('visiblity', $add)) {
                    $condition = [$id . '_show' => 'yes'];
                }
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => $id . '_typography',
                        'label' => 'Font',
                        'selector' => '{{WRAPPER}} .' . $class,
                        'exclude' => ['text_decoration', 'line_height', 'word_spacing'],
                        'condition' => $condition,
                    ]
                );
            }
            if (!in_array('text_color', $disable)) {
                $condition = '';
                if (in_array('visiblity', $add)) {
                    $condition = [$id . '_show' => 'yes'];
                }
                $this->add_control(
                    $id . '_color',
                    [
                        'label' => esc_html__('Text Color', 'nesar-widgets'),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .' . $class => 'color: {{VALUE}}',
                        ],
                        'condition' => $condition,

                    ]
                );
            }
            if (!in_array('text_align', $disable)) {
                $condition = '';
                if (in_array('visiblity', $add)) {
                    $condition = [$id . '_show' => 'yes'];
                }
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
                            'justify' => [
                                'title' => esc_html__('Justify', 'nesar-widgets'),
                                'icon' => 'eicon-text-align-justify',
                            ],
                        ],
                        'default' => 'center',
                        'toggle' => true,
                        'selectors' => [
                            '{{WRAPPER}} .' . $class => 'text-align: {{VALUE}}',
                        ],
                        'condition' => $condition,
                    ]
                );
            }
            if (in_array('border', $add)) {
                $this->add_group_control(
                    \Elementor\Group_Control_Border::get_type(),
                    [
                        'name' => $id . '_border',
                        'label' => esc_html__(
                            'Border',
                            'nesar-widgets'
                        ),
                        'selector' => '{{WRAPPER}} .' . $class,
                    ]
                );
                $this->add_control(
                    $id . '_hr',
                    [
                        'type' => \Elementor\Controls_Manager::DIVIDER,
                    ]
                );
            }
        }


        if (in_array('image_size', $add)) {
            $condition = '';
            if (in_array('visiblity', $add)) {
                $condition = [$id . '_show' => 'yes'];
            }
            $this->add_control(
                $id . '_imagewidth',
                [
                    'label' => esc_html__('Image Width', 'nesar-widgets'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['%'],
                    'range' => [

                        '%' => [
                            'min' => 10,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 75,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .' . $class . ' .img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => $condition,
                ]
            );
        }

        if (in_array('image_align', $add)) {
            $condition = '';
            if (in_array('visiblity', $add)) {
                $condition = [$id . '_show' => 'yes'];
            }
            $this->add_control(
                $id . '_imagealign',
                [
                    'label' => esc_html__('Image Alignment', 'nesar-widgets'),
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
                    'default' => 'center',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .' . $class => 'justify-content: {{VALUE}}',
                    ],
                    'condition' => $condition,
                ]
            );
        }


        if (in_array('spacing', $add)) {
            $condition = '';
            if (in_array('visiblity', $add)) {
                $condition = [$id . '_show' => 'yes'];
            }
            if (!in_array('padding', $disable)) {
                $this->add_responsive_control(
                    $id . '_padding',
                    [
                        'type' => \Elementor\Controls_Manager::DIMENSIONS,
                        'label' => esc_html__('Padding', 'nesar-widgets'),
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .' . $class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        'default' => [
                            'top' => '0.3',
                            'bottom' => '0.3',
                            'unit' => 'em',
                            'isLinked' => false,
                        ],
                        'condition' => $condition,

                    ]
                );
            }
            if (!in_array('margin', $disable)) {
                $this->add_responsive_control(
                    $id . '_margin',
                    [
                        'type' => \Elementor\Controls_Manager::DIMENSIONS,
                        'label' => esc_html__('Margin', 'nesar-widgets'),
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .' . $class => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        'default' => [
                            'bottom' => '1',
                            'unit' => 'em',
                            'isLinked' => false,
                        ],
                        'condition' => $condition,
                    ]
                );
            }
        }


        $this->end_controls_section();
    }
}
