<?php

namespace WPC\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class BasicControls_buttons extends MultiButtons
{

    public function flex($value)
    {
        if ($value = 1) {
            return "flex: 1 1 auto;width:100%;";
        }
    }
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
        $repeater = $args['repeater'];
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

        if (in_array('text_style', $add)) {
            if (!in_array('text_font', $disable)) {
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => $id . '_' . strtolower($repeater) . '_typography',
                        'label' => 'Font',
                        'selector' => '{{WRAPPER}} .multiButtons_button',

                    ]
                );

                $this->add_control(
                    $id . '_' . strtolower($repeater) . '_color',
                    [
                        'label' => esc_html__('Background Color', 'nesar-widgets'),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .multiButtons_button' => 'color: {{VALUE}}',
                        ],


                    ]
                );
            }

            if (!in_array('text_align', $disable)) {
                $this->add_control(
                    $id . '_' . strtolower($repeater) . '_align',
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
                            '{{WRAPPER}}  .multiButtons_button' => 'text-align: {{VALUE}}',
                        ],
                        'condition' => [$id . '_fill!' => '1'],

                    ]
                );
            }
        }
        $this->add_responsive_control(
            $id  . '_h_align',
            [
                'label' => esc_html__('Button Horizontal Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => ' eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'nesar-widgets'),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Between', 'nesar-widgets'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Between', 'nesar-widgets'),
                        'icon' => 'eicon-justify-space-around-h',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .' . $class['parent'] => 'justify-content: {{VALUE}}',
                ],

            ]
        );

        $this->add_responsive_control(
            $id  . '_v_align',
            [
                'label' => esc_html__('Button Vertical  Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'eicon-justify-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => ' eicon-justify-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'eicon-justify-end-v',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'nesar-widgets'),
                        'icon' => 'eicon-justify-space-between-v',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Between', 'nesar-widgets'),
                        'icon' => 'eicon-justify-space-evenly-v',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Between', 'nesar-widgets'),
                        'icon' => 'eicon-justify-space-around-v',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .' . $class['parent'] => 'align-items: {{VALUE}}',
                ],

            ]
        );

        $this->add_responsive_control(
            $id  . '_direction',
            [
                'label' => esc_html__('Button Direction', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'nesar-widgets'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'nesar-widgets'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'wrap' => [
                        'title' => esc_html__('Column', 'nesar-widgets'),
                        'icon' => 'eicon-wrap',
                    ],
                ],
                'default' => 'initial',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .' . $class['parent'] => 'flex-flow: {{VALUE}}',
                ],

            ]
        );

        $this->add_responsive_control(
            $id  . '_fill',
            [
                'label' => esc_html__('Fill', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    "1" => [
                        'title' => esc_html__('Fill', 'nesar-widgets'),
                        'icon' => 'eicon-grow',
                    ],
                ],
                'default' => '',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .' . $class['parent'] . ' .' . $class['child'] => $this->flex('{{VALUE}}'),
                ],

            ]
        );


        $reps = new \Elementor\Repeater();
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_title',
            [
                'label' => esc_html__('Button Text', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Button Text', 'nesar-widgets'),
                'label_block' => true,
            ]
        );

        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_links',
            [
                'label' => esc_html__('URLs', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::URL,

                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,

            ]
        );

        $reps->add_control(
            $id . 'hr2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_btn_align',
            [
                'label' => esc_html__('Text alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'justify-content: {{VALUE}}',
                ],


            ]
        );
        $reps->start_controls_tabs(
            $id . '_' . strtolower($repeater) . '_tabs'
        );

        $reps->start_controls_tab(
            $id . '_' . strtolower($repeater) . '_normal_tab',
            [
                'label' => esc_html__('Normal', 'nesar-widgets'),
            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_n_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
                ],
                'default' => '#ffffff',


            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_n_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
                ],
                'default' => '#3FB65B',
                'alpha' => true,


            ]
        );
        $reps->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id . '_' . strtolower($repeater) . '_n_box_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );
        $reps->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $id . '_' . strtolower($repeater) . '_n_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );
        $reps->end_controls_tab();

        // Hover Tab
        $reps->start_controls_tab(
            $id . '_' . strtolower($repeater) . '_hover_tab',
            [
                'label' => esc_html__('Hover', 'nesar-widgets'),
            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_h_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}}',
                ],
                'default' => '#ffffff',


            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_h_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}}',
                ],
                'default' => '#369C4E',
                'alpha' => true,

            ]
        );
        $reps->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id . '_' . strtolower($repeater) . '_h_box_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
            ]
        );
        $reps->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $id . '_' . strtolower($repeater) . '_h_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
            ]
        );
        $reps->end_controls_tab();
        $reps->end_controls_tabs();
        $reps->add_control(
            $id . 'hr3',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $reps->add_responsive_control(
            $id . '_' . strtolower($repeater) . '_cornerRadius',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'nesar-widgets'),
                'size_units' => ['em', 'px'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'right' => '5',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );

        $reps->add_responsive_control(
            $id . '_' . strtolower($repeater) . '_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'default' => [
                    'top' => '0.5',
                    'bottom' => '0.5',
                    'left' => '2',
                    'right' => '2',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );

        $reps->add_responsive_control(
            $id . '_' . strtolower($repeater) . '_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'default' => [
                    'left' => '0.5',
                    'right' => '0.5',
                    'top' => '0.5',
                    'bottom' => '0.5',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );
        $reps->add_control(
            'icon_settings',
            [
                'label' => esc_html__('Icon Settings', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_icon_show',
            [
                'label' => esc_html__('Show Icon', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'nesar-widgets'),
                'label_off' => esc_html__('Off', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_color',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .btn_icon' => 'color: {{VALUE}}',
                ],
                'condition' => [$id . '_' . strtolower($repeater) . '_icon_show' => 'yes'],

            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_icon',
            [
                'label' => esc_html__('Icon', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'condition' => [$id . '_' . strtolower($repeater) . '_icon_show' => 'yes'],

            ],
        );
        $reps->add_responsive_control(
            $id . '_' . strtolower($repeater) . '_icon_size',
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
                    '{{WRAPPER}} {{CURRENT_ITEM}} .btn_icon'  => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [$id . '_' . strtolower($repeater) . '_icon_show' => 'yes'],

            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_direction',
            [
                'label' => esc_html__('Position', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [

                    'row' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                ],
                'default' => 'row',
                'condition' => [$id . '_' . strtolower($repeater) . '_icon_show' => 'yes'],

            ]
        );
        $reps->add_control(
            $id . '_' . strtolower($repeater) . '_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['em',],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} > :not([hidden]) ~ :not([hidden])' => 'margin-left: calc((0.5 * {{SIZE}}{{UNIT}}) * calc(1 - 0));',
                ],
                'condition' => [$id . '_' . strtolower($repeater) . '_icon_show' => 'yes'],
            ]
        );

        $this->add_control(
            $id . '_list',
            [
                'label' => esc_html__($repeater, 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $reps->get_controls(),
                'title_field' => '{{{' . $id . '_' . strtolower($repeater) . '_title}}}',
                'default' => [
                    $id . '_' . strtolower($repeater) . '_title' => esc_html__('Button', 'nesar-widgets'),
                ]
            ]
        );

        $this->end_controls_section();
    }
}
