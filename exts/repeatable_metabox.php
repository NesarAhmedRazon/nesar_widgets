<?php

/**
 * Repeatable Custom Fields in a Metabox
 * Author: Helen Hou-Sandi
 *
 * From a bespoke system, so currently not modular - will fix soon
 * Note that this particular metadata is saved as one multidimensional array (serialized)
 */
function add_pricing_table_style()
{
    wp_register_style('nesar_pricing_table_backend', plugins_url('style/nesar_pricing_table_backend.css', __DIR__));
    wp_enqueue_style('nesar_pricing_table_backend');
}
add_action('admin_enqueue_scripts', 'add_pricing_table_style');


add_action('admin_init', 'hhs_add_meta_boxes', 1);
function hhs_add_meta_boxes()
{
    add_meta_box('repeatable-fields', 'Package Features', 'hhs_repeatable_meta_box_display', 'pricing_plane', 'normal', 'default');
}

function hhs_repeatable_meta_box_display()
{
    global $post;

    $repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);


    wp_nonce_field('hhs_repeatable_meta_box_nonce', 'hhs_repeatable_meta_box_nonce'); ?>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            add_id();
            $('#add-row').on('click', function() {
                var row = $('.empty-row.screen-reader-text').clone(true);
                row.removeClass('empty-row screen-reader-text');
                row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
                add_id();
                return false;
            });

            $('.remove-row').on('click', function() {
                $(this).parents('tr').remove();
                add_id();
                return false;
            });
            $('.toggller').on('click', function() {
                let tid = $(this).attr('id');
                let ti = parseInt(tid.replace(/[^0-9.]/g, ""));

                $('#ti_' + ti).text(function(i, v) {
                    return v === 'yes' ? 'no' : 'yes'
                }).val(function(i, v) {
                    return v === 'yes' ? 'no' : 'yes'
                });
                $(this).toggleClass('show');

            });

            function add_id() {
                $(".toggller").each(function(i) {
                    $(this).attr('id', 'toggle_' + i).siblings('input').attr('id', 'ti_' + i);
                });
            }

        });
    </script>

    <table id="repeatable-fieldset-one" width="100%">
        <thead>
            <tr>
                <th width="40%">Features</th>
                <th width="12%"></th>
                <th width="8%"></th>
            </tr>
        </thead>
        <tbody>
            <?php

            if ($repeatable_fields) {
                foreach ($repeatable_fields as $field) {

                    echo '<tr>';
                    if ($field['name'] != '') {
                        $val = esc_attr($field['name']);
                    } else {
                        $val = '';
                    }
                    $vis = esc_attr($field['allow']);
                    $view = '';
                    if ($vis == 'yes') {
                        $view = 'show';
                    }
                    echo '<td><input type="text" class="widefat" name="name[]" value="' . $val . '" /></td>'; ?>

                    <td>
                        <div class="toggller <?php echo $view; ?>">
                            <div class="yes">Yes</div>
                            <div class="no">No</div>
                        </div>
                        <input class="data" hidden name="allow[]" type="text" value="<?php echo $vis; ?>">
                    </td>



                    <td><a class="button remove-row" href="#">Remove</a></td>
                    </tr>
                <?php
                }
            } else {
                // show a blank one
                ?>
                <tr>
                    <td><input type="text" class="widefat" name="name[]" /></td>

                    <td>
                        <div class="toggller show">
                            <div class="yes">Yes</div>
                            <div class="no">No</div>
                        </div>
                        <input class="data" hidden name="allow[]" type="text" value="yes">
                    </td>


                    <td><a class="button remove-row" href="#">Remove</a></td>
                </tr>
            <?php
            } ?>

            <!-- empty hidden one for jQuery -->
            <tr class="empty-row screen-reader-text">
                <td><input type="text" class="widefat" name="name[]" /></td>

                <td>
                    <div class="toggller show">
                        <div class="yes">Yes</div>
                        <div class="no">No</div>
                    </div>
                    <input class="data" hidden name="allow[]" type="text" value="yes">
                </td>


                <td><a class="button remove-row" href="#">Remove</a></td>
            </tr>
        </tbody>
    </table>

    <p><a id="add-row" class="button" href="#">Add another</a></p>
<?php
}


add_action('save_post', 'hhs_repeatable_meta_box_save');
function hhs_repeatable_meta_box_save($post_id)
{
    if (
        !isset($_POST['hhs_repeatable_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['hhs_repeatable_meta_box_nonce'], 'hhs_repeatable_meta_box_nonce')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $old = get_post_meta($post_id, 'repeatable_fields', true);
    $new = array();


    $names = $_POST['name'];
    $checked = $_POST['allow'];


    $count = count($names);
    for ($i = 0; $i < $count; $i++) {
        if ($names[$i] != '') :
            $new[$i]['id'] = $i;
            $new[$i]['name'] = stripslashes(strip_tags($names[$i]));
            $new[$i]['allow'] = $checked[$i];




        // and however you want to sanitize
        endif;
    }

    if (!empty($new) && $new != $old) {

        update_post_meta($post_id, 'repeatable_fields', $new);
    } elseif (empty($new) && $old) {

        delete_post_meta($post_id, 'repeatable_fields', $old);
    }
    $e = $new;
    return $e;
}
?>