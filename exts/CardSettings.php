<?php

namespace WPC\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class CardSettings extends PricingTable
{
    public function settings($args = [])
    {
        $disable = [];
        $id = date('m');
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

        if (in_array('background', $add)) {
            $this->add_control(
                $id . '_bgcolor',
                [
                    'label' => esc_html__('Background Color', 'nesar-widgets'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .' . $class => 'background-color: {{VALUE}}',
                    ],
                    'default' => '#fff',
                ]
            );
        }
        if (in_array('direction', $add)) {
            
        $this->add_responsive_control(
			$id.'_direction',
			[
				'label' => esc_html__( 'Direction', 'nesar-widgets'),
				'type' => \Elementor\CustomControl\Direction_Control::Direction,
                
				'options' => [
                    'row' => [
						'title' => esc_html__('Hirizontal', 'text-domain'),
						'icon' => 'eicon-h-align-center',
					],
                    'column' => [
						'title' => esc_html__('Vertical', 'text-domain'),
						'icon' => 'eicon-v-align-middle',
					],
                ],
                'selectors' => [
                        '{{WRAPPER}} .prices' => 'flex-direction: {{VALUE}}',
                ],
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
        if (in_array('spacing', $add)) {
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

                    ]
                );
            }
        }

        $this->end_controls_section();
    }
}
