<?php
/**
 * File header placeholder
 */

class ApisearchAdminApi
{
    /**
     * Settings page
     *
     * @param ApisearchClient $client
     *
     * @return bool
     */
    public static function checkCredentials(ApisearchClient $client)
    {
        return $client->checkIndex();
    }

    /**
     * Index post
     *
     * @param ApisearchClient $client
     * @param string $postId
     * @param string $postData
     */
    public static function indexPost(
        ApisearchClient $client,
        $postId,
        $postData
    )
    {
        if (
            in_array($postData['post_status'], array('publish')) &&
            get_post_meta($postId, "apisearch_searchable_disabled", true) == false
        ) {
            $client->addItem(PostTransformer::toItem($postId, $postData));
        } else {
            $client->deleteItem(PostTransformer::toItemUUID($postId, $postData));
        }
    }

    /**
     * Index page
     *
     * @param ApisearchClient $client
     * @param string $pageId
     * @param string $pageData
     */
    public static function indexPage(
        ApisearchClient $client,
        $pageId,
        $pageData
    )
    {
        if (
            in_array($pageData['page_status'], array('publish')) &&
            get_page_meta($pageId, "apisearch_searchable_disabled", true) == false
        ) {
            $client->addItem(PageTransformer::toItem($pageId, $pageData));
        } else {
            $client->deleteItem(PageTransformer::toItemUUID($pageId, $pageData));
        }
    }
}