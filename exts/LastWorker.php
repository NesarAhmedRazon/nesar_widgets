<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class LastWorker
{
    public function __construct($post_type)
    {
        $this->post_type = $post_type;
        add_filter('manage_' . $post_type . '_posts_columns', [$this, 'last_worked']);
        add_action('manage_' . $post_type . '_posts_custom_column', [$this, 'last_worker_data'], 10, 2);
    }

    public function last_worked($data)
    {
        $data['last_worked']     = __('Last Worked', 'nesar-widgets');
        return $data;
    }

    public function last_worker_data($data, $post_id)
    {
        if ('last_worked' === $data) {
            $now_gmt = time();
            $rev = wp_get_post_revisions($post_id);
            if (count($rev) > 0) {
                foreach ($rev as $rd) {
                    $modified_gmt = strtotime($rd->post_modified_gmt . ' +0000');
                    $rev_data = array(
                        'id'         => $rd->ID,
                        'title'      => get_the_title($post_id),
                        'author'     => get_the_author_meta('display_name', $rd->post_author),
                        'timeAgo'    => sprintf(__('%s ago'), human_time_diff($modified_gmt, $now_gmt)),
                    );
                    echo $rev_data['author'] . ', ' . $rev_data['timeAgo'];
                    return;
                }
            }
        }
    }
}

class LastWorkerSettings
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'settingsPage']);
    }
    public function settingsPage()
    {
        register_setting(
            'general', // settings group name
            'last_worker_posts_type', // option name
            [
                'type'              => 'array',
                'group'             => 'last_worker_posts_type',
                'description'       => '',
                'sanitize_callback' => null,
                'show_in_rest'      => false,
            ] // sanitization function
        );
        add_settings_field(
            'last_worker_posts_type',
            'Last Worker Monitoring',
            [$this, 'html'], // function which prints the field
            'general', // page slug
            'default', // section ID
            array(
                'label_for' => 'last_worker_post',
                'class' => 'mpt-class', // for <tr> element
            )
        );
        $this->set_last_worker();
    }

    public function html()
    {

        $posts = $this->get_all_postTypes();
        foreach ($posts as $type => $name) {
            $checked = '';
            $opt = get_option('last_worker_posts_type');
            if (is_array($opt)) {
                if (in_array($type, $opt)) {
                    $checked = 'checked="checked"';
                }
            }

            echo '<fieldset><label for="type">';
            echo '<input name="last_worker_posts_type[]" type="checkbox" id="last_worker_posts_type" value="' . $type . '" ' . $checked . '>';
            echo $name . '</label></fieldset>';
        }
    }
    public function set_last_worker()
    {
        $opts = get_option('last_worker_posts_type');
        if (is_array($opts)) {
            foreach ($opts as $post_type) {
                new LastWorker($post_type);
            }
        }
    }
    public function get_all_postTypes()
    {
        $items = [];
        $ignors = ['attachment', 'elementor_library', 'elementor-thhf', 'e-landing-page', 'elementskit_content', 'elementskit_template'];
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
}
