<?php
/**
 * File header placeholder
 */

class ApisearchAdminMetrics
{
    /**
     * Settings page
     *
     * @param string $pluginName
     * @param array  $storedOptions
     */
    public static function show(
        $pluginName,
        array $storedOptions
    )
    {
        include_once( 'partials/apisearch-admin-metrics.php' );
    }
}