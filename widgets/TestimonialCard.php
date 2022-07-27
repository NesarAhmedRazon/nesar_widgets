<?php

// Tallyfy Testimonial Card

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
}
class TestimonialCard extends Widget_Base
{
    public $id = 'tesCard';
    public function get_name()
    {
        return 'itp_testimonial_card';
    }
    public function get_title()
    {
        return esc_html__('Testimonial Card', 'nesar-widgets');
    }
    public function get_icon()
    {
        return 'eicon-comments';
    }
    public function get_categories()
    {
        return ['basic'];
    }
    public function get_style_depends()
    {
        wp_register_style('itp-tesCard', plugin_dir_url(__DIR__) . 'style/TestimonialCard.css');
        return [
            'itp-tesCard'
        ];
    }
    public function get_post_types()
    {
        $items = [];
        $ignors = ['attachment', 'elementor-thhf'];
        $args = array(
            'public'   => true,
        );
        $post_types = get_post_types($args, 'objects');
        foreach ($ignors as $ignor) {
            unset($post_types[$ignor]);
        }
        if ($post_types) {
            foreach ($post_types  as $post_type) {
                $name = $post_type->name;
                if (!preg_match("/^element|^cms|^woodmart/i", $name)) {
                    $k = $post_type->name;
                    $v = $post_type->label;
                    $items[$k] = esc_html__($v, 'nesar-widgets');
                }
            }
            return $items;
        }
    }
    protected function register_controls()
    {
        $set = new TesCardSettings();
        $set->settings();
        $set->cardstyles();
        $set->textstyles('msg', 'Message', 'tesText');
        $set->textstyles('nam', 'Name', 'tesName', ['size']);
        $set->textstyles('des', 'Designation', 'tesDes', ['size']);
        $set->custImage('img', 'Image', 'tesImg');
    }
    protected function render()
    {
        $tool = new TesCardSettings();
        $set = $this->get_settings_for_display();
        $data_type = $set[$this->id . 'data_types'];
        $msize = $set[$this->id . '_msg_size']['size'];
        $img_align = $set[$this->id . '_image_align'];
        $attrs = $this->get_render_attribute_string($this->id . '_link');
        $url = '';
        $image = [];

?>

<?php
        if ($data_type == 'dynamic') {

            $post_type = $set[$this->id . 'post_types'];
            $postID = $set[$this->id . 'posts_' . $post_type];
            if ($postID !== "") {
                $meta = $tool->get_meta_data('user_review', $postID);
                $message = $tool->excerptforPost($meta, $msize);
                $name = $tool->get_meta_data('user_name', $postID);
                $desig = $tool->get_meta_data('user_designation', $postID);
                $attrs = 'href="' . esc_url(get_permalink($postID)) . '"';
                $image = get_the_post_thumbnail($postID, 'thumbnail', array('class' => 'cusImg'));
                echo '<a class="tesCard"' . $attrs . '>';
                if ($img_align == 'left') {
                    echo '<div class="tesImg">' . $image . '</div>';
                    echo '<div class="tesInfo">';
                    echo '<div class="tesName">' . $name . '</div><div class="tesDes">' . $desig . '</div></div><div class="tesText">' . $message . '</div>';
                }
                if ($img_align == 'right') {
                    echo '<div class="tesInfo">';
                    echo '<div class="tesText">' . $message . '</div><div class="tesName">' . $name . '</div><div class="tesDes">' . $desig . '</div></div>';
                    echo '<div class="tesImg">' . $image . '</div>';
                }
                echo '</a>';
            }
        } else {
            $name = $set[$this->id . '_name'];
            $desig = $set[$this->id . '_designation'];
            $url = $set[$this->id . '_link'];
            if (!empty($url['url'])) {
                $this->add_link_attributes($this->id . '_link', $url);
            }

            $meta = $set[$this->id . '_message'];
            $message = $tool->excerptforPost($meta, $msize);
            $image = $set[$this->id . '_image'];

            echo '<a class="tesCard" ' . $attrs . '>';
            if ($img_align == 'left') {
                echo '<div class="tesImg"><img src="' . $image['url'] . '" alt="' . ((in_array('alt', $image)) ? $image['alt'] : "Image of " . $name) . '" class="cusImg"></div>';
                echo '<div class="tesInfo">';
                echo '<div class="tesName">' . $name . '</div><div class="tesDes">' . $desig . '</div></div><div class="tesText">' . $message . '</div>';
            }

            if ($img_align == 'right') {
                echo '<div class="tesInfo">';
                echo '<div class="tesText">' . $message . '</div><div class="tesName">' . $name . '</div><div class="tesDes">' . $desig . '</div></div>';
                echo '<div class="tesImg"><img src="' . $image['url'] . '" alt="' . ((in_array('alt', $image)) ? $image['alt'] : "Image of " . $name) . '" class="cusImg"></div>';
            }
            echo '</a>';
        }
    }
}

class TesCardSettings extends TestimonialCard
{

    public function get_meta_data($field, $id = false)
    {
        $meta = get_post_meta($id, $field, true);
        return $meta;
    }
    public function get_post_types()
    {
        $items = [];
        $ignors = ['attachment', 'elementor-thhf'];
        $args = array(
            'public'   => true,
        );
        $post_types = get_post_types($args, 'objects');
        foreach ($ignors as $ignor) {
            unset($post_types[$ignor]);
        }

        if ($post_types) {
            foreach ($post_types  as $post_type) {
                $name = $post_type->name;

                if (!preg_match("/^element|^cms|^woodmart/i", $name)) {
                    $k = $post_type->name;
                    $v = $post_type->label;
                    if (!empty($this->allPost($k))) {
                        $items[$k] = esc_html__($v, 'nesar-widgets');
                    }
                }
            }
            return $items;
        }
    }
    protected function allPost($slug_name, $order = 'ASC', $orderby = 'date')
    {

        $items = [];
        $args = [
            'post_type' => $slug_name,
            'posts_per_page' => -1,
            'orderby'          => $orderby,
            'order'            => $order,
            'public'   => true,
        ];
        $all_posts = get_posts($args);

        if ($all_posts) {
            foreach ($all_posts  as $post_type) {
                $name = $post_type->name;
                if (!preg_match("/^element|^cms|^woodmart/i", $name)) {
                    $k = $post_type->ID;
                    $v = $post_type->post_title;
                    $items[$k] = esc_html__($v, 'nesar-widgets');
                }
            }

            return $items;
        }
    }

    public function excerptforPost($text, $num = 50)
    {
        $limit = $num + 1;
        $excerpt = explode(" ", $text, $limit);
        array_pop($excerpt);
        $excerpt = implode(' ', $excerpt) . '...';
        return $excerpt;
    }

    public function settings()
    {

        $this->start_controls_section(
            $this->id . '_section',
            [
                'label' => esc_html__('Settings', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            $this->id . 'data_types',
            [
                'label' => esc_html__('Testimonial Type', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'static' => 'Static',
                    'dynamic' => 'Dynamic',
                ],
                'default' => 'static',
            ]
        );
        $postTypes = $this->get_post_types();
        $this->add_control(
            $this->id . 'post_types',
            [
                'label' => esc_html__('Post Type', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $postTypes,
                'condition' => [
                    $this->id . 'data_types' => 'dynamic'
                ],
            ]
        );
        foreach ($postTypes as $i => $postType) {

            $list = $this->allPost($i);
            if (!empty($list)) {
                $this->add_control(
                    $this->id . 'posts_' . $i,
                    [
                        'label' => esc_html__('Select Post', 'nesar-widgets'),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => $list,
                        'conditions' => [
                            'relation' => 'and',
                            'terms' => [
                                ['name' => $this->id . 'data_types', 'operator' => '===', 'value' => 'dynamic'],
                                ['name' => $this->id . 'post_types', 'operator' => '===', 'value' => $i],
                            ],
                        ],
                    ]
                );
            }
        }
        $this->add_control(
            $this->id . '_name',
            [
                'label' => esc_html__('Name', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Name', 'nesar-widgets'),
                'label_block' => true,
                'placeholder' => esc_html__('Name of customer', 'nesar-widgets'),
                'condition' => [
                    $this->id . 'data_types' => 'static'
                ],
            ]
        );

        $this->add_control(
            $this->id . '_designation',
            [
                'label' => esc_html__('Designation', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Designation', 'nesar-widgets'),
                'label_block' => true,
                'placeholder' => esc_html__('Designation of customer', 'nesar-widgets'),
                'condition' => [
                    $this->id . 'data_types' => 'static'
                ],
            ]
        );
        $this->add_control(
            $this->id . '_link',
            [
                'label' => esc_html__('URL', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::URL,

                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'condition' => [
                    $this->id . 'data_types' => 'static'
                ],

            ]
        );
        $this->add_control(
            $this->id . '_message',
            [
                'label' => esc_html__('Message', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__('Here goes Customer Message', 'nesar-widgets'),
                'placeholder' => esc_html__('Message', 'nesar-widgets'),
                'condition' => [
                    $this->id . 'data_types' => 'static'
                ],
            ]
        );

        $this->add_control(
            $this->id . '_image',
            [
                'label' => esc_html__('Choose Image', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    $this->id . 'data_types' => 'static'
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function cardstyles()
    {
        $this->start_controls_section(
            $this->id . '_card_styles',
            [
                'label' => esc_html__('Card', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            $this->id . '_image_align',
            [
                'label' => esc_html__('Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'nesar-widgets'),
                        'icon' => 'nw-icon_left_customer',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'nesar-widgets'),
                        'icon' => 'nw-icon_right_customer',
                    ],
                ],
                'default' => 'right',

            ]
        );
        $this->add_control(
            $this->id . '_card_gap',
            [
                'label' => esc_html__('Content Spacing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 5,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 0.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tesCard' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            $this->id . '_card_hover_time',
            [
                'label' => esc_html__('Hover Timing', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['ms', 's'],
                'range' => [
                    'ms' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 100,
                    ],
                    's' => [
                        'min' => 0,
                        'max' => 60,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'ms',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tesCard' => 'transition-duration: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            $this->id . '_card_tabs',

        );
        $this->start_controls_tab(
            $this->id . '_card_normal_tab',
            [
                'label' => esc_html('Normal', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $this->id . '_card_n_background',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tesCard' => 'background-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $this->id . '_card_n_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tesCard',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            $this->id . '_card_hover_tab',
            [
                'label' => esc_html('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $this->id . '_card_h_background',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tesCard:hover' => 'background-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $this->id . '_card_h_shadow',
                'label' => esc_html__('Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .tesCard:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            $this->id . '_card_radious',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Corner Radious', 'nesar-widgets'),
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tesCard' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            $this->id . '_card_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tesCard' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],


            ]
        );
        $this->end_controls_section();
    }
    public function textstyles($name, $title, $class, $dis = [])
    {
        $this->start_controls_section(
            $this->id . '_' . $name . '_styles',
            [
                'label' => esc_html__($title, 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $this->id . '_' . $name . '_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .' . $class,
            ]
        );
        $this->add_responsive_control(
            $this->id . '_' . $name . '_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'nesar-widgets'),
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],


            ]
        );
        $this->add_responsive_control(
            $this->id . '_' . $name . '_align',
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
                'selectors' => [
                    '{{WRAPPER}} .' . $class => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->start_controls_tabs(
            $this->id . '_' . $name . '_tabs',

        );
        $this->start_controls_tab(
            $this->id . '_' . $name . '_normal_tab',
            [
                'label' => esc_html('Normal', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $this->id . '_' . $name . '_n_color',
            [
                'label' => esc_html__('Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $class => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            $this->id . '_' . $name . '_hover_tab',
            [
                'label' => esc_html('Hover', 'nesar-widgets'),
            ]
        );
        $this->add_control(
            $this->id . '_' . $name . '_h_color',
            [
                'label' => esc_html__('Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $class => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        if (!in_array('size', $dis)) {
            $this->add_control(
                $this->id . '_' . $name . '_size',
                [
                    'label' => esc_html__($title . ' Size', 'nesar-widgets'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['w'],
                    'range' => [
                        'w' => [
                            'min' => 0,
                            'max' => 500,
                            'step' => 10,
                        ],
                    ],
                    'default' => [
                        'unit' => 'w',
                        'size' => 50,
                    ],
                ]
            );
        }
        $this->end_controls_section();
    }

    public function custImage($name, $title, $class)
    {
        $this->start_controls_section(
            $this->id . '_' . $name . '_thumb',
            [
                'label' => esc_html($title, 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            $this->id . '_' . $name . '_width',
            [
                'label' => esc_html__('Width', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'em', 'vh'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $class . ' img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            $this->id . '_' . $name . '_height',
            [
                'label' => esc_html__('Height', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'em', 'vh'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $class . ' img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $this->id . '_' . $name . '_border',
                'label' => esc_html__(
                    'Border',
                    'nesar-widgets'
                ),
                'selector' => '{{WRAPPER}}  .' . $class . ' img',

            ]
        );
        $this->add_responsive_control(
            $this->id . '_' . $name . '_borderRadius',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'nesar-widgets'),
                'size_units' => ['em', 'px', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .' . $class . ' img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'default' => [
                    'top' => '50',
                    'bottom' => '50',
                    'left' => '50',
                    'right' => '50',
                    'unit' => '%',
                ],

            ]
        );
        $this->add_responsive_control(
            $this->id . '_' . $name . '_valign',
            [
                'label' => esc_html__('Vertical Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'nesar-widgets'),
                        'icon' => 'eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => 'eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'nesar-widgets'),
                        'icon' => 'eicon-align-end-v',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .' . $class  => 'align-items: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            $this->id . '_' . $name . '_halign',
            [
                'label' => esc_html__('Horizontal Alignment', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'nesar-widgets'),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'nesar-widgets'),
                        'icon' => 'eicon-align-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'nesar-widgets'),
                        'icon' => 'eicon-align-end-h',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .' . $class  => 'justify-content: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
    }
}
