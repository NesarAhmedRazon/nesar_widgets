<?php

namespace WPC\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class FilterSettings extends PricingTable
{
    public function filter_controls()
    {
        $title = 'Filter';
        $id = 'filterx';
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__($title . " Button", 'nesar-widgets'),
                'tab' => 'panel_style_button',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .filter',
                'exclude' => ['text_decoration', 'line_height', 'word_spacing'],

            ]
        );

        $this->add_responsive_control(
            $id . '_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ',

                ],
                'default' => [
                    'top' => '1',
                    'bottom' => '1',
                    'left' => '2',
                    'right' => '2',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );
        $this->add_responsive_control(
            $id . '_borders',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'nesar-widgets'),
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .filter:first-of-type' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-bottom-left-radius:{{LEFT}}{{UNIT}} ',
                    '{{WRAPPER}} .filter:last-of-type' => 'border-top-right-radius: {{RIGHT}}{{UNIT}};border-bottom-right-radius:{{BOTTOM}}{{UNIT}} ',
                ],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'right' => '5',
                    'isLinked' => false,
                ],
            ]
        );
        $this->add_control(
            'hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->start_controls_tabs(
            $id . '_tabs'
        );
        //Normal Tab
        $this->start_controls_tab(
            $id . '_normal_tab',
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
                    '{{WRAPPER}} .filter' => 'color: {{VALUE}}',
                ],
                'default' => '#333',
            ]
        );
        $this->add_control(
            $id . '_background',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .filter' => 'background-color: {{VALUE}}',
                ],
                'default' => '#e5e5e5',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'Border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .filter ',
            ]
        );
        $this->end_controls_tab();
        //Hover Tab
        $this->start_controls_tab(
            $id . '_hover_tab',
            [
                'label' => esc_html__('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_hcolor',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .filter:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .filter.active' => 'color: {{VALUE}}',
                ],
                'default' => '#333',
            ]
        );
        $this->add_control(
            $id . '_hbackground',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .filter:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .filter.active' => 'background-color: {{VALUE}}',
                ],
                'default' => '#e5e5e5',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'Hover Border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' =>
                '{{WRAPPER}} .filter:hover ,{{WRAPPER}} .filter.active',


            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'hr1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_responsive_control(
            $id . '_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'bottom' => '1',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );
        $this->add_control(
            $id . '_align',
            [
                'label' => esc_html__('Alignment', 'nesar-widgets'),
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
                    '{{WRAPPER}} .filters' => 'justify-content: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
    }
}
