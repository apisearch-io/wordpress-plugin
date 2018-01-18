<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://apisearch.io
 * @since      1.0.0
 *
 * @package    Apisearch
 * @subpackage Apisearch/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="cleanup_options" action="options.php">
        <?php settings_fields($pluginName); ?>
        <?php $options = get_option($pluginName); ?>

        <p>
            You can configure your Apisearch credentials here.
        </p>
        <p>
            No Apisearch account yet? <a href="https://admin.apisearch.io/register/wordpress">Follow this link</a> and create a new account for free.
        </p>

        <table class="form-table">
            <tr>
                <th>App ID</th>
                <td>
                    <input type="text" id="<?php echo $pluginName; ?>-app_id" name="<?php echo $pluginName; ?>[app_id]" value="<?php if(!empty($options['app_id'])) echo $options['app_id']; ?>"/>
                    <p class="description">You App ID. This value is unique and can be public</p>
                </td>
            </tr>

            <tr>
                <th>Index ID</th>
                <td>
                    <input type="text" id="<?php echo $pluginName; ?>-index_id" name="<?php echo $pluginName; ?>[index_id]" value="<?php if(!empty($options['index_id'])) echo $options['index_id']; ?>"/>
                    <p class="description">You Index ID. This value is unique and can be public</p>
                </td>
            </tr>

            <tr>
                <th>Admin token</th>
                <td>
                    <input class="regular-text" type="password" id="<?php echo $pluginName; ?>-admin_token" name="<?php echo $pluginName; ?>[admin_token]" value="<?php if(!empty($options['admin_token'])) echo $options['admin_token']; ?>"/>
                    <p class="description">You Admin token. This value is unique and <b>can NEVER be</b> public</p>
                </td>
            </tr>

            <tr>
                <th>Read-only token</th>
                <td>
                    <input class="regular-text" type="text" id="<?php echo $pluginName;?>-read_only_token" name="<?php echo $pluginName; ?>[read_only_token]" value="<?php if(!empty($options['read_only_token'])) echo $options['read_only_token']; ?>"/>
                    <p class="description">You Read only token. This value is unique and can be public</p>
                </td>
            </tr>
        </table>

        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>

</div>