<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}
class ChildPostArchive extends Widget_Base
{
    public $id = 'cpa_arc';
    public function get_name()
    {
        return 'tf_ChildPostArchive';
    }
    public function get_title()
    {
        return esc_html__('Child Post Archive', 'nesar-widgets');
    }
    public function get_icon()
    {
        return 'eicon-products-archive';
    }
    public function get_categories()
    {
        return ['basic'];
    }
    public function get_style_depends()
    {
        wp_register_style('ChildPostArchive', plugin_dir_url(__DIR__) . 'style/ChildPostArchive.css');
        return [
            'ChildPostArchive'
        ];
    }
    protected function register_controls()
    {
        $set = new CpaSettings();
        $set->settings();
        $set->styles();
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
    protected function allPost($slug_name, $order = 'ASC', $orderby = 'date')
    {
        $args = [
            'post_type' => $slug_name,
            'posts_per_page' => -1,
            'orderby'          => $orderby,
            'order'            => $order,
        ];
        $all_posts = get_posts($args);
        return $all_posts;
    }
    protected function withoutParent($slug_name, $order = 'ASC', $orderby = 'date')
    {
        $args = [
            'post_type' => $slug_name,
            'posts_per_page' => -1,
            'orderby'          => $orderby,
            'order'            => $order,
            'post_parent' => 0,
        ];
        $all_posts = get_posts($args);
        return $all_posts;
    }
    protected function parents($slug_name, $order = 'ASC', $orderby = 'date')
    {
        $pars = [];
        $parent = [];

        $all_posts = $this->allPost($slug_name, $order, $orderby);
        if ($all_posts) {
            foreach ($all_posts  as $child) {
                if ($child->post_parent != 0) {
                    $p = $child->post_parent;
                    array_push($pars, $p);
                }
            }
            $pars = array_unique($pars);
            foreach ($pars as $par) {
                $post = get_post($par);
                $pk = $post->post_title;
                $pv = $par;
                $parent[$pv] = esc_html__($pk, 'nesar-widgets');
            }
            return $parent;
        }
    }
    protected function childPosts($type, $parent, $order = 'desc')
    {
        $childs = [];
        $args = [
            'post_type' => $type,
            'posts_per_page' => -1,
            'post_parent' => $parent,
            'order' => $order,
        ];
        $child_posts = get_posts($args);
        if ($child_posts) {
            return $child_posts;
        }
    }
    protected function render()
    {
        $set = $this->get_settings_for_display();
        $type = $set[$this->id . 'post_types'];
        $display = $set[$this->id . 'archive_types'];
        $auth = $set[$this->id . '_show_thumbnail'];
        $excerpt = [$set[$this->id . '_show_excerpt'], $set[$this->id . '_excerpt_size']];
        $skin = $set[$this->id . 'skin_types'];
        $order = $set[$this->id . '_post_order'];
        $thumbnail = $set[$this->id . '_show_post_tumbnail'];

        if ($display == 'child') {
            $parent = $set[$this->id . '_type_' . $type];
            if ($parent != 0) {
                $children = $this->childPosts($type, $parent, $order);
                $html = new CpaHtmls();
                if ($skin == 'grid') {
                    $html->gridLayout($children, $auth, $excerpt, $thumbnail);
                } elseif ($skin == 'rows') {
                    $html->rowLayout($children);
                }
            }
        } elseif ($display == 'parent') {
            $parents = $this->parents($type, $order);

            if (count($parents) != 0) {
                $posts = [];
                foreach ($parents as $parent => $id) {
                    $pars = get_post($parent);
                    array_push($posts, $pars);
                }

                $html = new CpaHtmls();
                if ($skin == 'grid') {
                    $html->gridLayout($posts, $auth, $excerpt, $thumbnail);
                } elseif ($skin == 'rows') {
                    $html->rowLayout($posts);
                }
            } else {
                echo 'No Parent Post in this Post type';
            }
        } elseif ($display == 'withoutchild') {
            $posts = $this->withoutParent($type, $order);
            if (count($posts) != 0) {
                $html = new CpaHtmls();
                if ($skin == 'grid') {
                    $html->gridLayout($posts, $auth, $excerpt, $thumbnail);
                } elseif ($skin == 'rows') {
                    $html->rowLayout($posts);
                }
            }
        } elseif ($display == 'all') {
            $posts = $this->allPost($type, $order);
            if (count($posts) != 0) {
                $html = new CpaHtmls();
                if ($skin == 'grid') {
                    $html->gridLayout($posts, $auth, $excerpt, $thumbnail);
                } elseif ($skin == 'rows') {
                    $html->rowLayout($posts);
                }
            }
        }
    }
}

class CpaSettings extends ChildPostArchive
{
    public $id = 'cpa_arc';

    public function settings()
    {
        $postTypes = $this->get_post_types();

        $this->start_controls_section(
            $this->id . '_section',
            [
                'label' => esc_html__('Settings', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            $this->id . 'post_types',
            [
                'label' => esc_html__('Select Post Type', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $postTypes,
            ]
        );
        $this->add_responsive_control(
            $this->id . '_post_order',
            [
                'label' => esc_html__('Post Order', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'desc' => [
                        'title' => esc_html__('Latest First', 'nesar-widgets'),
                        'icon' => 'nw-desc',
                    ],
                    'asc' => [
                        'title' => esc_html__('Oldest First', 'nesar-widgets'),
                        'icon' => ' nw-asc',
                    ],
                ],
                'default' => 'desc',
                'toggle' => false,

            ]
        );
        $this->add_control(
            $this->id . 'archive_types',
            [
                'label' => esc_html__('Content Type', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all'  => esc_html__('All', 'nesar-widgets'),
                    'withoutchild' => esc_html__('Without Child', 'nesar-widgets'),
                    'parent' => esc_html__('Parent Only', 'nesar-widgets'),
                    'child' => esc_html__('Child Only', 'nesar-widgets'),
                ],
                'default' => 'child',
            ]
        );

        foreach ($postTypes as $type => $title) {
            $parents = $this->parents($type);
            if (is_array($parents) && (sizeof($parents) != 0)) {
                $items = $parents;
            } else {
                $items = ['0' => 'No Parent Item'];
            }
            $this->add_control(
                $this->id . '_type_' . $type,
                [
                    'label' => esc_html__('Parent ' . $title, 'nesar-widgets'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => $items,
                    'default' => '0',
                    'condition' => [$this->id . 'post_types' => $type, $this->id . 'archive_types' => 'child'],
                ]
            );
        }

        $this->end_controls_section();
    }

    public function styles()
    {
        $this->start_controls_section(
            $this->id . '_styles',
            [
                'label' => esc_html__('Customization', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            $this->id . 'skin_types',
            [
                'label' => esc_html__('Archive Skin', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'grid' => 'Grid',
                    'rows' => 'Rows',
                ],
                'default' => 'grid',
            ]
        );
        $this->add_control(
            $this->id . '_show_post_tumbnail',
            [
                'label' => esc_html__('Fetured Image', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'nesar-widgets'),
                'label_off' => esc_html__('Hide', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            $this->id . '_show_excerpt',
            [
                'label' => esc_html__('Excerpt', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'nesar-widgets'),
                'label_off' => esc_html__('Hide', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->add_control(
            $this->id . '_show_thumbnail',
            [
                'label' => esc_html__('Author Thumbnail', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'nesar-widgets'),
                'label_off' => esc_html__('Hide', 'nesar-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        $this->gridStyles();
        $this->gridAuthorThumbnail();
        $this->titleStyle();
        $this->excerpt();
    }
    public function gridStyles()
    {
        $this->start_controls_section(
            $this->id . "_grid_style",
            [
                'label' => esc_html__("Grid Skin", 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->id . 'skin_types' => 'grid'
                ],
            ]
        );
        $this->add_responsive_control(
            $this->id . '_grid_item_cols',
            [
                'label' => esc_html__('Grid Columns', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['col'],
                'range' => [

                    'col' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'col',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-container'  => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
                ],

            ]
        );

        $this->add_responsive_control(
            $this->id . '_grid_item_gap',
            [
                'label' => esc_html__('Grid Gap', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [

                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 1.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-container'  => 'gap: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->start_controls_tabs(
            $this->id . '_grid_tabs'
        );
        $this->start_controls_tab($this->id . '_grid_normal_tab', [
            'label' => esc_html__('Normal', 'nesar-widgets'),
        ]);
        $this->add_control(
            $this->id . '_grid_bg_color',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-item' => 'background-color: {{VALUE}}',
                ],
                'default' => '#fff',

            ]
        );
        $this->add_control(
            $this->id . '_grid_border_color',
            [
                'label' => esc_html__('Border Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-item' => 'border-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $this->id . '_grid_shadow',
                'label' => esc_html__('Box Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .grid-item',

            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab($this->id . '_grid_hover_tab', [
            'label' => esc_html__('Hover', 'nesar-widgets'),
        ]);
        $this->add_control(
            $this->id . '_grid_h_bg_color',
            [
                'label' => esc_html__('Background Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-item:hover' => 'background-color: {{VALUE}}',
                ],
                'default' => '#fff',

            ]
        );
        $this->add_control(
            $this->id . '_grid_border_h_color',
            [
                'label' => esc_html__('Border Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-item:hover' => 'border-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $this->id . '_grid_h_shadow',
                'label' => esc_html__('Box Shadow', 'nesar-widgets'),
                'selector' => '{{WRAPPER}} .grid-item:hover',

            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            $this->id . '_grid_transition',
            [
                'label' => esc_html__('Transition Time(Seconds)', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [

                    's' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 0.1,
                    ]
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-container .grid-item'  => 'transition-duration: {{SIZE}}{{UNIT}};',
                ],


            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $this->id . '_grid_border',
                'label' => esc_html__(
                    'Border',
                    'nesar-widgets'
                ),
                'selector' => '{{WRAPPER}} .grid-item',

                'separator' => 'before',
                'exclude' => ['color'],
            ]
        );
        $this->add_responsive_control(
            $this->id . '_grid_borderRadius',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'nesar-widgets'),
                'size_units' => ['em', 'px', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],

            ]
        );
        $this->end_controls_section();
    }
    public function excerpt()
    {
        $this->start_controls_section(
            $this->id . '_excerpt_styles',
            [
                'label' => esc_html__('Excerpt', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->id . '_show_excerpt' => 'yes'
                ],
            ]
        );
        $this->add_responsive_control(
            $this->id . '_excerpt_size',
            [
                'label' => esc_html__('Excerpt Length', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['w'],
                'range' => [

                    'w' => [
                        'min' => 5,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'w',
                    'size' => 10,
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $this->id . '_excerpt_typography',
                'label' => 'Font',
                'selector' => '{{WRAPPER}} .post-excerpt',
            ]
        );
        $this->add_responsive_control(
            $this->id . '_excerpt_align',
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
                    '{{WRAPPER}} .post-excerpt' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->start_controls_tabs(
            $this->id . '_excerpt_tabs'
        );
        $this->start_controls_tab($this->id . '_excerpt_normal_tab', [
            'label' => esc_html__('Normal', 'nesar-widgets'),
        ]);
        $this->add_control(
            $this->id . '_excerpt_text_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-excerpt' => 'color: {{VALUE}}',
                ],


            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab($this->id . '_excerpt_hover_tab', [
            'label' => esc_html__('Hover', 'nesar-widgets'),
        ]);
        $this->add_control(
            $this->id . '_excerpt_h_text_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div:hover>.post-excerpt' => 'color: {{VALUE}}',
                ],


            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
    public function titleStyle()
    {
        $this->start_controls_section(
            $this->id . '_title_styles',
            [
                'label' => esc_html__('Post Title', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $this->id . '_title_typography',
                'label' => 'Title Font',
                'selector' => '{{WRAPPER}} .grid-container .grid-item .grid-info .post-title',
            ]
        );
        $this->add_responsive_control(
            $this->id . '_title_align',
            [
                'label' => esc_html__('Title Alignment', 'nesar-widgets'),
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
                    '{{WRAPPER}} .post-title' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->start_controls_tabs(
            $this->id . '_title_tabs'
        );
        $this->start_controls_tab($this->id . '_title_normal_tab', [
            'label' => esc_html__('Normal', 'nesar-widgets'),
        ]);
        $this->add_control(
            $this->id . '_title_text_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-title' => 'color: {{VALUE}}',
                ],


            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab($this->id . '_title_hover_tab', [
            'label' => esc_html__('Hover', 'nesar-widgets'),
        ]);
        $this->add_control(
            $this->id . '_title_h_text_color',
            [
                'label' => esc_html__('Text Color', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div:hover > .post-title' => 'color: {{VALUE}}',
                ],


            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            $this->id . '_show_thumbnail_style',
            [
                'label' => esc_html__('View', 'nesar-widgets'),
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => 'traditional',
                'selectors' => [
                    '{{WRAPPER}}  .post-title' => 'grid-column: span 5',
                ],
                'condition' => [
                    $this->id . '_show_thumbnail!' => 'yes'
                ],
            ]
        );
        $this->end_controls_section();
    }
    public function gridAuthorThumbnail()
    {
        $this->start_controls_section(
            $this->id . '_author_thumbnail',
            [
                'label' => esc_html('Author Thumbnail', 'nesar-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    $this->id . '_show_thumbnail' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $this->id . '_auth_border',
                'label' => esc_html__(
                    'Border',
                    'nesar-widgets'
                ),
                'selector' => '{{WRAPPER}}  .grid-author .author-thumb',

            ]
        );

        $this->add_responsive_control(
            $this->id . '_auth_borderRadius',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'nesar-widgets'),
                'size_units' => ['em', 'px', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}}  .grid-author .author-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
        $this->end_controls_section();
    }
}


class CpaHtmls extends ChildPostArchive
{
    public function gridLayout($posts, $authThumb, $excerpt, $thumb)
    {
?>
<div class="grid-container">
    <?php
            foreach ($posts as $post) { ?>
    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="grid-item">
        <?php
                    if ((has_post_thumbnail($post->ID)) && ($thumb == 'yes')) {
                        echo get_the_post_thumbnail($post->ID, 'full', ['class' => 'grid-thumb']);
                    }
                    $author = get_the_author_meta('display_name', $post->post_author);
                    ?>

        <div class="grid-info">
            <h3 class="post-title"><?php echo $post->post_title; ?></h3>
            <?php if ($authThumb == 'yes') { ?>
            <div class="grid-author">
                <img src="<?php echo esc_url(get_avatar_url($post->post_author)); ?>" alt="<?php echo $author; ?>"
                    class="author-thumb">
            </div>
            <?php } ?>
            <?php if (($excerpt[0] == 'yes') && (has_excerpt($post->ID))) {
                            echo '<div class="post-excerpt">';
                            $this->excerptforPost($post->ID, $excerpt[1]['size']);
                            echo '</div>';
                        } ?>
        </div>

    </a>
    <?php } ?>
</div>
<?php
    }
    public function rowLayout($post)
    {
        echo 'row'; //Will Make another Template Later
    }

    private function excerptforPost($id, $num = 50)
    {
        $limit = $num + 1;
        $excerpt = explode(' ', wp_strip_all_tags(get_the_excerpt($id)), $limit);
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . "... ";
        echo $excerpt;
    }
}
