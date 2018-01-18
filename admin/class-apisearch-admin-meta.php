<?php
/**
 * File header placeholder
 */

class ApisearchAdminMeta
{
    /**
     * Settings page
     *
     * @param $object
     */
    public static function showMetadata($object)
    {
        include_once('partials/apisearch-admin-post-metadata-box.php');
    }

    /**
     * Save meta
     *
     * @param string $postId
     * @param array $post
     */
    public static function saveMetadata(
        $postId,
        array $post
    ) {
        if (
            !isset($_POST["apisearch_metabox_nonce"]) ||
            !wp_verify_nonce($_POST["apisearch_metabox_nonce"], basename(__FILE__ . '/partials/apisearch-admin-post-metadata-box.php'))
        ) {
            return;
        }

        update_post_meta(
            $postId,
            "apisearch_searchable_disabled",
            (bool) ($_POST['apisearch-searchable-disabled'] ?? false)
        );
    }
}

