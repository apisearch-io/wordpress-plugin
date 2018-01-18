<?php
/**
 * File header placeholder
 */

class UserTransformer
{
    /**
     * User To item
     *
     * @param string $userId
     * @param string $userData
     *
     * @return array
     */
    public static function toItem(
        $userId,
        $userData
    )
    {
        return [
            'uuid' => self::toItemUUID($userId, $userData),
            'metadata' => [
                'name' => $userData['user_name'],
                'author' => $userData['user_author'],
                'guid' => $userData['guid'],
            ],
            'indexed_metadata' => [
                'status' => $userData['user_status'],
                'tags' => array_map('trim', $userData['tags_input']),
                'comment_count' => $userData['comment_count'],
            ],
            'searchable_metadata' => array(
                'title' => $userData['user_title'],
                'content' => $userData['user_content'],
            )
        ];
    }

    /**
     * User To item
     *
     * @param string $userId
     * @param string $userData
     *
     * @return array
     */
    public static function toItemUUID(
        $userId,
        $userData
    )
    {
        return [
            'id' => $userId,
            'type' => $userData['user_type'],
        ];
    }
}