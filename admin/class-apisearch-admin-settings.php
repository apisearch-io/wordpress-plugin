<?php
/**
 * File header placeholder
 */

class ApisearchAdminSettings
{
    /**
     * Settings page
     *
     * @param string $pluginName
     */
    public static function show($pluginName)
    {
        include_once( 'partials/apisearch-admin-settings.php' );
    }

    /**
    *
    * admin/class-wp-cbf-admin.php
    *
    **/
    public static function validate($input) {
        // All checkboxes inputs
        $valid = array();

        //Cleanup
        $valid['app_id'] = sanitize_text_field($input['app_id']);
        $valid['index_id'] = sanitize_text_field($input['index_id']);
        $valid['admin_token'] = sanitize_text_field($input['admin_token']);
        $valid['read_only_token'] = sanitize_text_field($input['read_only_token']);

        add_filter(
            'wp_redirect',
            function($location) use ($valid) {
                return self::checkCredentials(
                    $valid,
                    $location
                );
            },
            99
        );

        return $valid;
    }

    /**
     * Validate credentials
     *
     * @param array $config
     * @param string $location
     *
     * @return string
     */
    public static function checkCredentials(
        array $config,
        $location
    )
    {
        $temporalApisearchClient = new ApisearchClient('http://localhost:8999', 'v1');
        $temporalApisearchClient->setCredentials(
            $config['app_id'],
            $config['index_id'],
            $config['admin_token']
        );

        $indexChecked = $temporalApisearchClient->checkIndex();

        return add_query_arg(array('credentials_verified' => (int) $indexChecked), $location);
    }
}

