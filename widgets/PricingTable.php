<?php
// Tallyfy Pricing Table

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

require plugin_dir_path(NESAR_WIDGETS) . 'exts/ButtonSettings.php';
require plugin_dir_path(NESAR_WIDGETS) . 'exts/BasicControls.php';
require plugin_dir_path(NESAR_WIDGETS) . 'exts/FilterSettings.php';
require plugin_dir_path(NESAR_WIDGETS) . 'exts/CardSettings.php';

class PricingTable extends Widget_Base
{
    public function get_name()
    {
        return 'tallyfy_pricing_table';
    }
    public function get_title()
    {
        return esc_html__('Tallyfy Pricing Table', 'nesar-widgets');
    }
    public function get_icon()
    {
        return 'eicon-price-table';
    }
    public function get_categories()
    {
        return ['basic'];
    }
    public function get_style_depends()
    {
        wp_register_style('nesar_wid_priceTable', plugin_dir_url(__DIR__) . 'style/decor_priceTable.css');
        return [
            'nesar_wid_priceTable'
        ];
    }
    public function get_script_depends()
    {
        wp_register_script('nesar_pricing_filter', plugin_dir_url(__DIR__) . 'js/wid_pricing_filter.js');
        return [
            'nesar_pricing_filter',
        ];
    }



    protected function register_controls()
    {
        $bs = new BasicControls();
        $xs = new ButtonSettings();
        $fs = new FilterSettings();
        $cs = new CardSettings();

        $cs->settings(
            [
                'label' => 'Card',
                'id' => 'prs_column',
                'selector' => 'tf_price',
                'settings' => [
                    'spacing', 'background', 'border', 'direction'
                ],
            ]
        );
        $bs->basic_setings(
            [
                'id' => 'heading',
                'label' => 'Heading',
                'selector' => 'prs_title',
                'settings' => ['visiblity', 'text_style', 'spacing'],
                'remove' => ['padding']
            ]
        );
        $bs->basic_setings(
            [
                'id' => 'tagline',
                'label' => 'Tagline',
                'selector' => 'prs_tagline',
                'settings' => ['visiblity', 'text_style', 'spacing'],
                'remove' => ['padding']
            ]
        );
        $bs->basic_setings(
            [
                'id' => 'logo',
                'label' => 'Logo',
                'selector' => 'prs_img',
                'settings' => ['visiblity', 'spacing', 'image_align', 'image_size'],
                'remove' => ['padding']
            ]
        );
        $bs->basic_setings(
            [
                'id' => 'cost_sym',
                'label' => 'Currency Symbol',
                'selector' => 'cost .sym',
                'settings' => ['visiblity', 'text_style'],
                'remove' => ['text_align']
            ]
        );
        $bs->basic_setings(
            [
                'id' => 'cost_num',
                'label' => 'Price',
                'selector' => 'cost .num',
                'settings' => ['text_style'],
                'remove' => ['text_align']
            ]
        );
        $bs->basic_setings(
            [
                'id' => 'unit',
                'label' => 'Unit Text',
                'selector' => 'cost .txt',
                'settings' => ['visiblity', 'text_style', 'text_box'],
                'remove' => ['text_align']
            ]
        );
        $bs->basic_setings(
            [
                'id' => 'feature_n',
                'label' => 'Features',
                'selector' => 'prs_feature',
                'settings' => ['text_style', 'spacing', 'border', 'group_margin'],
                'remove' => ['margin'],
            ]
        );
        $bs->basic_setings(
            [
                'id' => 'feature_d',
                'label' => 'Features: Disabled',
                'selector' => 'prs_feature.disabled',
                'settings' => ['text_style'],
                'remove' => ['text_font', 'text_align'],
            ]
        );

        $fs->filter_controls();
        $xs->button_normal();
        $xs->button_featured('Featured');

        // Featured Card
        $cs->settings(
            [
                'tab' => 'prs_feature_style',
                'label' => 'Card',
                'id' => 'prs_f_column',
                'selector' => 'tf_price.featured',
                'settings' => [
                    'background', 'spacing', 'border'
                ],

            ]
        );
        $bs->basic_setings(
            [
                'tab' => 'prs_feature_style',
                'id' => 'heading_f',
                'label' => 'Heading',
                'selector' => 'featured .prs_title',
                'settings' => ['text_style'],
            ]
        );
        $bs->basic_setings(
            [
                'tab' => 'prs_feature_style',
                'id' => 'tagline_f',
                'label' => 'Tagline',
                'selector' => 'featured .prs_tagline',
                'settings' => ['text_style'],
            ]
        );
        $bs->basic_setings(
            [
                'tab' => 'prs_feature_style',
                'id' => 'logo_f',
                'label' => 'Logo',
                'selector' => 'featured .prs_img',
                'settings' => ['spacing', 'image_align', 'image_size'],
                'remove' => ['padding']
            ]
        );
        $bs->basic_setings(
            [
                'tab' => 'prs_feature_style',
                'id' => 'cost_sym_f',
                'label' => 'Currency Symbol',
                'selector' => 'featured .cost .sym',
                'settings' => ['text_style'],
            ]
        );
        $bs->basic_setings(
            [
                'tab' => 'prs_feature_style',
                'id' => 'cost_num_f',
                'label' => 'Price',
                'selector' => 'featured .cost .num',
                'settings' => ['text_style'],
            ]
        );
        $bs->basic_setings(
            [
                'tab' => 'prs_feature_style',
                'id' => 'unit_f',
                'label' => 'Unit Text',
                'selector' => 'featured .cost .txt',
                'settings' => ['text_style'],
            ]
        );
        $bs->basic_setings(
            [
                'tab' => 'prs_feature_style',
                'id' => 'feature_n_f',
                'label' => 'Features',
                'selector' => 'featured .prs_feature',
                'settings' => ['text_style', 'border'],
            ]
        );
        $bs->basic_setings(
            [
                'tab' => 'prs_feature_style',
                'id' => 'feature_d_f',
                'label' => 'Features: Disabled',
                'selector' => 'featured .prs_feature.disabled',
                'settings' => ['text_style'],
            ]
        );
        //Featured Card End
    }

    // Find The Categories for Pricing Plans

    public function find_plans()
    {
        $terms = get_terms(array(
            'taxonomy' => 'price_plans_type',
            'hide_empty' => true,
            'orderby' => 'name',
        ));
        return $terms;
    }
    public function all_post_by_term($term_slug)
    {
        $posts = get_posts(
            array(
                'showposts' => -1,
                'post_type' => 'pricing_plane',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'price_plans_type',
                        'field' => 'slug',
                        'terms' => $term_slug
                    )
                )
            )
        );
        return $posts;
    }
    // Rander the Pricing Plans
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        //$card_direction = $settings['prs_column_direction'];
        $show_title = $settings['heading_show'];
        $show_subtitle = $settings['tagline_show'];
        $show_logo = $settings['logo_show'];
        $show_sym = $settings['cost_sym_show'];
        $show_unit = $settings['unit_show'];
        $buttonText = $settings['buy_button_text'];
        $buttonTextF = $settings['btn_featured_text'];
        $perText = $settings['unit_text'];
        echo '<div class="priceTable">';
        echo '<div class="filters">'; //filter Start

        $terms = $this->find_plans();
        $active = true;
        foreach ($terms as $term) {
            if ($active) {
                echo '<div class="filter active" id="' . $term->slug . '">' . $term->name . '</div>';
                $active = false;
            } else {
                echo '<div class="filter" id="' . $term->slug . '">' . $term->name . '</div>';
            }
        }
        echo '</div>'; //Filter End

        $active = true;
        foreach ($terms as $term) {
            if ($active) {
                echo '<div class="prices active" id="' . $term->slug . '">';
                $active = false;
            } else {
                echo '<div class="prices " id="' . $term->slug . '">';
            }
            $id = $term->slug;
            $posts = $this->all_post_by_term($id);

            $x = 'featured';
            foreach ($posts as $post) {
                $id = $post->ID;
                $features = get_post_meta($id, 'repeatable_fields', true);
                $price = get_post_meta($id, 'na_price', true);
                $tagline = get_post_meta($id, 'plan_tagline', true);
                $featured = get_post_meta($id, 'na_featured', true);
                $buttonUrl = get_post_meta($id, 'plan_url', true);
                if ($buttonUrl) :
                    $link_url = $buttonUrl['url'] ? $buttonUrl['url'] : '#';
                    $link_target = $buttonUrl['target'] ? $buttonUrl['target'] : '_self';
                else :
                    $link_url = "#";
                    $link_target = '_self';
                endif; ?>

<div class="tf_price <?php echo $featured == 'yes' ? "featured" : ''; ?>">
    <?php if ($show_title == 'yes') {
                        echo '<p class="prs_title">' . $post->post_title . '</p>';
                    }


                    if (has_post_thumbnail($id) && $show_logo == 'yes') {
                        echo '<div class="prs_img"><img class="img" src="' . get_the_post_thumbnail_url($id) . '" alt="' . $post->post_title . '"/></div>';
                    } ?>

    <?php

                if ($tagline !== "" && $show_subtitle == 'yes') {
                    echo '<p class="prs_tagline">' . $tagline . '</p>';
                }

                echo '<div class="cost">';
                if ($show_sym == "yes") {
                    echo '<span class="sym">$</span> ';
                }
                echo '<span class="num">' . ($price != '' ? $price : '0') . '</span> ';
                if ($show_unit == "yes") {
                    echo '<span class="txt">' . $perText . '</span>';
                }

                echo '</div>';
                echo '<div class="features">';

                foreach ($features as $feature) {
                    echo '<div class="prs_feature ' . ($feature["allow"] != 'yes' ? 'disabled' : '') . '" >' . $feature["name"] . '</div>';
                }
                echo '</div>';

                echo '<div class="prs_button"><a class="prs_button_link ' . ($featured == 'yes' ? "featured" : '') . '" title="' . $post->post_title . '" href="' . $link_url . '" target="' . $link_target . '">' . ($featured == 'yes' ? $buttonTextF : $buttonText) . '</a></div> ';

                echo '</div>';

                $x = '';
            }
            echo '</div>'; //Panes Stop
        } ?>

    <?php

        echo '</div>';
    }


    protected function content_template()
    {
    }
}
