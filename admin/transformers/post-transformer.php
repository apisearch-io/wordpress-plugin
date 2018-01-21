<?php
/**
 * File header placeholder
 */

class PostTransformer
{
    /**
     * Post To item
     *
     * @param string $postId
     * @param string $postData
     *
     * @return array
     */
    public static function toItem(
        $postId,
        $postData
    )
    {
        return [
            'uuid' => self::toItemUUID($postId, $postData),
            'metadata' => [
                'name' => $postData['post_name'],
                'title' => $postData['post_title'],
                'author' => $postData['post_author'],
                'guid' => $postData['guid'],
            ],
            'indexed_metadata' => [
                'status' => $postData['post_status'],
                'tags' => array_map('trim', $postData['tags_input']),
                'comment_count' => $postData['comment_count'],
            ],
            'searchable_metadata' => array(
                'title' => $postData['post_title'],
                'content' => $postData['post_content'],
            )
        ];
    }

    /**
     * Post To item
     *
     * @param string $postId
     * @param string $postData
     *
     * @return array
     */
    public static function toItemUUID(
        $postId,
        $postData
    )
    {
        return [
            'id' => $postId,
            'type' => $postData['post_type'],
        ];
    }
}