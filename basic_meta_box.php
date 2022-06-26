<?php

namespace WPC\Widgets;

/**
 * Register a meta box using a class.
 */
class WPDocs_Custom_Meta_Box
{

    /**
     * Constructor.
     */
    var $someVar;
    public function __construct($post_type)
    {
        $this->someVar  = $post_type;
        if (is_admin()) {

            add_action('admin_enqueue_scripts', array($this, 'add_metabox'));
            do_action('admin_enqueue_scripts', $this->someVar);
            // do_action( 'load-post-new.php', $this->someVar );
        }
    }

    /**
     * Meta box initialization.
     */
    public function init_metabox()
    {

        add_action('admin_enqueue_scripts', array($this, 'add_style'));
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post',      array($this, 'save_metabox'), 10, 2);
    }

    /**
     * Adds the meta box.
     */
    public function add_style()
    {
        //var_dump($this->someVar);
        wp_register_style('nesar_radioButton', plugin_dir_url(__FILE__) . 'style/decor_radioButton.css');
        wp_enqueue_style('nesar_radioButton');
    }
    public function add_metabox()
    {
        //var_dump($this->someVar);
        add_meta_box(
            'tallyfy_link_view',
            __('Show  Link in Tallyfy Card', 'nesar-widgets'),
            array($this, 'render_metabox'),
            'post',
            'side',
            'default'
        );
    }

    /**
     * Renders the meta box.
     */
    public function render_metabox($post)
    {
        // Add nonce for security and authentication.
        wp_nonce_field('cc_nonce_action', 'xx_nonce');
        $value = get_post_meta($post->ID, 'link_check_value', true);
?>
<div class="tallyfy_meta tallyfy_radio">
    <div class="tallyfy_radio">
        <div class="label">Choose Visibility</div>
        <div class="radio_field">
            <input type="radio" id="radio-one" name="link_check_value" value="on" checked
                <?php checked($value, 'on'); ?> />
            <label for="radio-one">On</label>
            <input type="radio" id="radio-two" name="link_check_value" value="off" <?php checked($value, 'off'); ?> />
            <label for="radio-two">Off</label>
        </div>
    </div>


    <div class="caps">This will toggle the visibility of the Tallyfy card 'Read More' Link</div>
</div>


<?php

    }

    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox($post_id, $post)
    {
        // Add nonce for security and authentication.
        $nonce_name   = isset($_POST['xx_nonce']) ? $_POST['xx_nonce'] : '';
        $nonce_action = 'cc_nonce_action';

        // Check if nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action)) {
            return;
        }

        // Check if user has permissions to save data.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Check if not an autosave.
        if (wp_is_post_autosave($post_id)) {
            return;
        }

        // Check if not a revision.
        if (wp_is_post_revision($post_id)) {
            return;
        }
        if (isset($_POST['link_check_value'])) { // Input var okay.
            update_post_meta($post_id, 'link_check_value', sanitize_text_field(wp_unslash($_POST['link_check_value']))); // Input var okay.
        }
    }
}
