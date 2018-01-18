<div class="wrap">
    <h2>
        <?php echo esc_html( get_admin_page_title() ); ?>
        <button type="button" class="button button-primary apisearch-index-all" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>?action=apisearch_index_all">
            <?php esc_html_e( 'Re-index all', 'apisearch' ); ?>
        </button>
    </h2>
</div>
