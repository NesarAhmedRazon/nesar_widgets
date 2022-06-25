<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class ButtonSettings extends PricingTable
{
    public function button_normal()
    {
        $title = 'Button';
        $id = 'prs_button';
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__($title . " Settings : Normal", 'nesar-widgets'),
                'tab' => 'panel_style_button',

            ]
        );
        $this->add_control(
            'buy_button_text',
            [
                'label' => esc_html__($title . ' Text', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Your Text', 'nesar-widgets'),
                'placeholder' => esc_html__('Type your text here', 'nesar-widgets'),
            ]
        );
        $this->add_responsive_control(
            $id . '_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $id . '_link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ',

                ],
                'default' => [
                    'top' => '0.5',
                    'bottom' => '0.5',
                    'left' => '1',
                    'right' => '1',
                    'unit' => 'em',
                    'isLinked' => false,
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => $title . ' Font',
                'selector' => '{{WRAPPER}} .prs_button_link',
                'exclude' => ['line_height', 'word_spacing'],
            ]
        );
        $id = 'button';
        $class = '.prs_button';



        $this->add_control(
            'hr2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
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
                    '{{WRAPPER}} ' . $class . '_link' => 'color: {{VALUE}}',
                ],
                'default' => null,

            ]
        );
        $this->add_control(
            $id . '_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $class . '_link' => 'background-color: {{VALUE}}',
                ],
                'default' => null,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id . 'box_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} ' . $class . '_link',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $id . '_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'label_block' => true,
                'show_label' => true,
                'selector' =>
                '{{WRAPPER}} ' . $class . '_link',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            $id = $id . '_hover_tab',
            [
                'label' => esc_html__('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $id . '_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $class . '_link:hover' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            $id . '_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $class . '_link:hover' => 'background-color: {{VALUE}}',
                ],
                'default' => null,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $id . 'hbox_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} ' . $class . '_link:hover',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $id . '_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' =>
                '{{WRAPPER}} ' . $class . '_link',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'hr3',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $id = 'button';
        $class = '.prs_button';
        $this->add_responsive_control(
            $id . '_borderRadius',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'nesar-widgets'),
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} ' . $class . '_link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
            $id . '_align',
            [
                'label' => esc_html__($title . ' Alignment', 'nesar-widgets'),
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
                    '{{WRAPPER}} ' . $class => 'justify-content: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
    }
    public function button_featured($title)
    {
        $id = 'btn_featured';
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__("Button Settings: " . $title, 'nesar-widgets'),
                'tab' => 'panel_style_button',
            ]
        );
        $this->add_control(
            $id . '_text',
            [
                'label' => esc_html__('Button Text', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__($title, 'nesar-widgets'),
                'placeholder' => esc_html__('Type your text here', 'nesar-widgets'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .prs_button_link.featured',
                'exclude' => ['line_height', 'word_spacing'],
            ]
        );
        $this->add_control(
            $id . 'hr1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->start_controls_tabs(
            $id . '_tabs'
        );
        //Normal Tab Start
        $this->start_controls_tab(
            $idx = $id . '_normal_tab',
            [
                'label' => esc_html__('Normal', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $idx . '_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .prs_button_link.featured' => 'color: {{VALUE}}',
                ],
                'default' => null,

            ]
        );
        $this->add_control(
            $idx . '_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .prs_button_link.featured' => 'background-color: {{VALUE}}',
                ],
                'default' => null,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $idx . 'box_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .prs_button_link.featured',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $idx . '_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' =>
                '{{WRAPPER}} .prs_button_link.featured',
            ]
        );
        $this->end_controls_tab();
        // Hover Tab Start
        $this->start_controls_tab(
            $idx = $id . '_hover_tab',
            [
                'label' => esc_html__('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $idx . '_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .prs_button_link.featured:hover' => 'color: {{VALUE}}',
                ],
                'default' => null,

            ]
        );
        $this->add_control(
            $idx . '_bgcolor',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .prs_button_link.featured:hover' => 'background-color: {{VALUE}}',
                ],
                'default' => null,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $idx . 'box_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .prs_button_link.featured:hover',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $idx . '_border',
                'label' => esc_html__('Border', 'nesar-widgets'),
                'selector' =>
                '{{WRAPPER}} .prs_button_link.featured:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
