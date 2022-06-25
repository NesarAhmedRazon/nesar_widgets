<?php

namespace WPC\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class TitleIconSettings extends HeadingWithIcon
{
    public function buttonSettings($args = [])
    {
        $disable = [];
        if (!empty($args['tab'])) {
            $tab = $args['tab'];
        } else {
            $tab = \Elementor\Controls_Manager::TAB_SETTINGS;
        }
        $title = $args['label'];
        $id = $args['id'];
        $class = $args['selector'];
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
        $this->add_responsive_control(
            $id  . '_h_align',
            [
                'label' => esc_html__('Horizontal Alignment', 'itprix_elw'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'itprix_elw'),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'itprix_elw'),
                        'icon' => ' eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'itprix_elw'),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'itprix_elw'),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__('Space Between', 'itprix_elw'),
                        'icon' => 'eicon-justify-space-evenly-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__('Space Between', 'itprix_elw'),
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
                'label' => esc_html__('Vertical  Alignment', 'itprix_elw'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'itprix_elw'),
                        'icon' => 'eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'itprix_elw'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'itprix_elw'),
                        'icon' => 'eicon-align-end-v',
                    ],
                    'baseline' => [
                        'title' => esc_html__('Baseline', 'itprix_elw'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .' . $class['parent'] => 'align-items: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            $id . '_underline',
            [
                'label' => esc_html__('Underline', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'nesar-widgets'),
                'label_off' => esc_html__('Hide', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            $id . '_icon_only',
            [
                'label' => esc_html__('Icon Only', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'nesar-widgets'),
                'label_off' => esc_html__('No', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            $id . '_icon_only_height',
            [
                'label' => esc_html__('View', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => 'traditional',
                'selectors' => [
                    '{{WRAPPER}}  .hIcon_icon' => 'height:unset;width:unset',
                ],
                'condition' => [
                    $id . '_icon_only' => 'yes'
                ],
            ]
        );
        $this->add_control(
            $id . '_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hIcon_title:after' => 'background-color: {{VALUE}}',
                ],
                'default' => '#369C4E',
                'alpha' => true,
                'condition' => [$id . '_underline' => 'yes'],

            ]
        );
        $this->add_control(
            $id . '_uline_height',
            [
                'label' => esc_html__('Size', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hIcon_title:after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [$id . '_underline' => 'yes'],
            ]
        );
        $this->add_responsive_control(
            $id . '_uline_width',
            [
                'label' => esc_html__('Width', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 9999,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hIcon_title:after' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [$id . '_underline' => 'yes'],
            ]
        );
        $this->add_control(
            $id . '_uline_space',
            [
                'label' => esc_html__('Spacing', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hIcon_title:after' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [$id . '_underline' => 'yes'],
            ]
        );
        $this->end_controls_section();
    }
}
