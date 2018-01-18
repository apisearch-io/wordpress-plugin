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
    <div class="row">
        <div class="col-xs-12 col-lg-6">
            <div class="card card-full last-events">
                <h2>Events</h2>
                <div class="inside"></div>
            </div>
            <div class="card card-full found-vs-not-found">
                <h2>Events</h2>
                <div class="inside"></div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-6">
            <div class="card card-full raw-events">
                <h2>Last events</h2>
                <div class="inside"></div>
            </div>
        </div>
    </div>
</div>