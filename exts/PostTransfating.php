<?php

if (!defined('ABSPATH')) {
    exit;
}

class PostTransfating
{
    public function __construct()
    {
        $this->init();
    }
    public function init()
    {
        add_action('admin_menu', [$this, 'settings_page']);
        add_action('admin_init', [$this, 'move_post_register_setting']);
        add_action('wp_ajax_get_all_post', [$this, 'get_all_post']);
        add_action('wp_ajax_move_post', [$this, 'move_post']);
    }

    public function settings_page()
    {
        add_options_page(
            __( 'Change Post Type','nesar-widgets'),// page <title>Title</title>
            __( 'Move Post','nesar-widgets'), // menu link text
            'administrator', // capability to access the page
            'change_post_type', // page URL slug
            [$this, 'page_html'], // callback function /w content
            
        );
    }
    public function move_post_register_setting()
    {
        wp_enqueue_style('nw_admin', WP_PLUGIN_URL . '/nesar_widgets/style/admin.css');
        register_setting(
            'move_post_settings', // settings group name
            'select_content_type', // option name
            'sanitize_text_field' // sanitization function
        );
        add_settings_section(
            'content_type_section', // section ID
            'Move Post', // title (if needed)
            '', // callback function (if needed)
            'change_post_type' // page slug
        );
        add_settings_field(
            'select_content_type',
            'Old Post Type',
            [$this, 'ct_select_html'], // function which prints the field
            'change_post_type', // page slug
            'content_type_section', // section ID
            array(
                'label_for' => 'select_content_type',
                'class' => 'old_type', // for <tr> element
            )
        );
        add_settings_field(
            'select_content_new',
            'New Post Type',
            [$this, 'new_post_type'], // function which prints the field
            'change_post_type', // page slug
            'content_type_section', // section ID
            array(
                'label_for' => 'select_content_new',
                'class' => 'new_type', // for <tr> element
            )
        );

        // Choose Posts
        register_setting(
            'choose_post_settings', // settings group name
            'choose_content_post', // option name
            'sanitize_text_field' // sanitization function
        );
        add_settings_field(
            'choose_content_post',
            'Select Post',
            [$this, 'ct_choose_html'], // function which prints the field
            'change_post_type', // page slug
            'content_type_section', // section ID
            array(
                'label_for' => 'choose_content_post',
                'class' => 'mpt-class', // for <tr> element
            )
        );

        
        
    }
    public function page_html()
    {
        ?>
        <div class="wrap">
            <h1>Change Post Type</h1>
            <p><em>Change any post's type to another post type</em></p>
            <form id="move_post_types">
                <?php
                settings_fields('move_post_settings'); // settings group name
                do_settings_sections('change_post_type'); // just a page slug
                $other_attributes = array('disabled' => 'disabled', 'id' => 'nw_submit_button');
        submit_button(__('Move!', 'nesar-widgets'), '', '', true, $other_attributes); ?>
            </form>
        </div>
<?php
    wp_enqueue_script('nw_admin', WP_PLUGIN_URL . '/nesar_widgets/js/admin.js');
    wp_localize_script(
            'nw_admin',
            'post_datas',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wp-nonce'),
                'is_user_logged_in' => is_user_logged_in(),
            ]
        );
    }

    public function get_all_postTypes()
    {
        $items = [];
        $ignors = ['attachment', 'elementor_library', 'elementor-thhf', 'e-landing-page'];
        $args = array(
            'public'   => true,
        );
        $post_types = get_post_types($args, 'objects');
        foreach ($ignors as $ignor) {
            unset($post_types[$ignor]);
        }


        if ($post_types) {
            foreach ($post_types  as $post_type) {
                $k = $post_type->name;
                $v = $post_type->label;
                $items[$k] = esc_html__($v, 'nesar-widgets');
            }

            return $items;
        }
    }

    public function ct_select_html()
    {
        $posts = $this->get_all_postTypes();

        echo '<select class="select_content_type"  name="select_content_type" id="old_type">';
        echo '<option value="disabled" selected disabled hidden>Select Type</option>';
        foreach ($posts as $key => $value) {
            echo '<option value="' . $key . '">' . $value . '</option>';
        }
        echo '</select>';
        //var_dump($posts);
    }
    public function new_post_type()
    {
        $posts = $this->get_all_postTypes();
        echo '<select class="select_content_type" name="select_content_type" id="new_type">';
        echo '<option value="disabled" selected disabled hidden>Select Type</option>';
        foreach ($posts as $key => $value) {
            echo '<option value="' . $key . '">' . $value . '</option>';
        }
        echo '</select>';
    }
    public function ct_choose_html()
    {
        echo '<div class="field_set toggler" id="toggler"></div>';
        echo '<div class="list" id="post_list"></div>';
    }

    public function get_all_post($slug_name)
    {
        $slug_name = $_POST["post_type"];
        $logedIn = $_POST["loged_in"];

        if ($slug_name !== "" && $logedIn) {
            $args = [
                'post_type' => $slug_name,
                'posts_per_page' => -1, 
                'orderby'          => 'date',
                'order'            => 'DESC',
            ];
            $all_posts = get_posts($args);

            wp_send_json($all_posts);
            wp_die();
        } else {
            return false;
        }
    }

    public function move_post()
    {
        $postId = explode(",",$_POST['post']);;
        $newType = $_POST['type'];
        $item = [];
        foreach ($postId as $post) {
            if (set_post_type($post, $newType)) {
                $item[$post] = esc_html__('ok', 'nesar-widgets');
            } else {
                $item[$post] = esc_html__('error', 'nesar-widgets');
            }
        }
        
        wp_send_json($item);
        wp_die();
    }
}
