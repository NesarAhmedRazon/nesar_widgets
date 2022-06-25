<?php

namespace WPC\Widgets;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class ListParagraphControl extends List_Paragraph
{
    public function paraList_settings($args)
    {
        $id = $args['id'] . '_li';
        $title = $args['label'];
        $parent = $args['selector']['parent'];
        $child = $args['selector']['child'];;
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
            $id . '_type',
            [
                'label' => esc_html__('Style', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'num' => [
                        'title' => esc_html__('Number', 'nesar-widgets'),
                        'icon' => 'nw-list-ol',
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
                'default' => 'num',
                'toggle' => false,
            ]
        );
        $this->add_control(
            $id . '_icon',
            [
                'label' => esc_html__('Icon', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'nw-Tallyfy_icon',
                    'library' => 'solid',
                ],
                'condition' => [$id . '_type' => 'icon'],
            ],
        );
        $this->add_control(
            $id . '_li_gap',
            [
                'label' => esc_html__('Item Spacing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $parent . ' ' . $child => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $parent . ' ' . $child . ':last-of-type' => 'margin-bottom: 0{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    public function the_list($args)
    {
        $id = $args['id'];
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
        $rep = new \Elementor\Repeater();
        $rep->add_control(
            $id . '_t_show',
            [
                'label' => esc_html__('Show Heading', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'nesar-widgets'),
                'label_off' => esc_html__('Hide', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $rep->add_control(
            $id . '_title',
            [
                'label' => esc_html__('Heading', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('List Heading', 'nesar-widgets'),
                'label_block' => true,
            ]
        );
        $rep->add_control(
            $id . '_b_show',
            [
                'label' => esc_html__('Show Body', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'nesar-widgets'),
                'label_off' => esc_html__('Hide', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $rep->add_control(
            $id . '_body',
            [
                'label' => esc_html__('Paragraph', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('', 'nesar-widgets'),


            ]
        );

        $this->add_control(
            $id . '_list',
            [
                'label' => esc_html__('Lists', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $rep->get_controls(),
                'default' => [
                    [
                        $id . '_title' => esc_html__($title . ' #1', 'nesar-widgets'),

                    ],
                ],
                'title_field' => '{{{ ' . $id . '_title }}}',
                'show_label' => false,
            ]
        );
        $this->end_controls_section();
    }


    public function in_array_r($item, $array)
    {
        return preg_match('/"' . preg_quote($item, '/') . '"/i', json_encode($array));
    }

    public function text_settings($args)
    {

        $id = $args['id'];
        $title = $args['label'];
        $selector = $args['selector'];
        $child = '';
        $add = [];

        if (!empty($args['tab'])) {
            $tab = $args['tab'];
        } else {
            $tab = \Elementor\Controls_Manager::TAB_STYLE;
        }
        if (!empty($args['remove'])) {
            $dis = $args['remove'];
        }

        if (!empty($args['add'])) {
            $add = $args['add'];
        }

        if (!empty($args['child'])) {
            $child = $args['child'];
        }
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__($title, 'nesar-widgets'),
                'tab' => $tab,
            ]
        );
        if (in_array("tag", $add)) {

            $this->add_control(
                $id . '_tag',
                [
                    'label' => esc_html__('Heading Tag', 'nesar-widgets'),
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
                    ],
                ]
            );
        }
        if (in_array("font", $add)) {
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => $id . '_typography',
                    'label' => 'Font',
                    'selector' => '{{WRAPPER}} ' . $selector,
                ]
            );
        }
        if (in_array("color", $add)) {
            $this->add_control(
                $id . '_color',
                [
                    'label' => esc_html__('Text Color', 'nesar-widgets'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ' . $selector => 'color: {{VALUE}}',
                    ],
                    'default' => '#6d7882',
                ]
            );
        }
        if (in_array("align", $add)) {
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
                        '{{WRAPPER}} ' . $selector => 'text-align: {{VALUE}}',
                    ],
                ]
            );
        }
        if (in_array("li_indent", $add)) {
            $this->add_responsive_control(
                $id . '_sub_ol',
                [
                    'label' => esc_html__('Inner List Indent', 'nesar-widgets'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', 'em'],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                        'em' => [
                            'min' => 0,
                            'max' => 5,
                            'step' => 0.1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'em',
                        'size' => 0.3,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} ' . $selector . ' ul' => 'padding-inline-start: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} ' . $selector . ' ol' => 'padding-inline-start: {{SIZE}}{{UNIT}};',

                    ],
                ]
            );
        }


        if (in_array("li_marker_font", $add)) {
            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => $id . '_typography',
                    'label' => 'Font',
                    'selector' => '{{WRAPPER}} ' . $selector . ' ' . $child . '>li::marker',
                    'exclude' => ['text_transform', 'text_decoration', 'word_spacing', 'letter_spacing', 'line_height', 'font_style'],
                    'fields_options' => [
                        'font_weight' => [
                            'default' => '600',
                        ],
                    ],
                ]
            );
        }
        if (in_array("margin", $add)) {
            $this->add_responsive_control(
                $id . '_margin',
                [
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'label' => esc_html__('Margin', 'nesar-widgets'),
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'default' => [
                        'bottom' => '1',
                        'unit' => 'em',
                        'isLinked' => false,
                    ],
                ]
            );
        }
        $this->end_controls_section();
    }
    public function spacer($val)
    {
        var_dump($val);
        $space = '';
        for ($i = 1; $i <= $val; $i++) {
            $space += '\a0';
        }
        echo $space;
    }
    public function icon_settings($args)
    {
        $id = $args['id'];
        $title = $args['label'];
        $selector = $args['selector'];
        $dis = [];
        if (!empty($args['tab'])) {
            $tab = $args['tab'];
        } else {
            $tab = \Elementor\Controls_Manager::TAB_STYLE;
        }
        if (!empty($args['remove'])) {
            $dis = $args['remove'];
        }
        $this->start_controls_section(
            $id . '_section',
            [
                'label' => esc_html__($title, 'nesar-widgets'),
                'tab' => $tab,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $id . '_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} ' . $selector,
                'exclude' => ['font_family', 'text_transform', 'text_decoration', 'word_spacing', 'letter_spacing'],
                'fields_options' => [
                    'font_weight' => [
                        'default' => '700',
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => 1.2
                        ]
                    ]
                ],
            ]
        );
        $this->add_control(
            $id . '_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}}',
                ],
                'default' => '#6d7882',


            ]
        );
        $this->add_control(
            $id . '_ind_gap',
            [
                'label' => esc_html__('Indent Size', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector  => 'padding-right: {{SIZE}}{{UNIT}};',

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
                    '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }
}
