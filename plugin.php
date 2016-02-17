<?php
  /*
  * Plugin Name: WP REST API: Client-Java Meta Plugin
  * Description:  Enables meta endpoints required by wp-api-2.0-beta12+
  * Version:  0.1
  * Author: Afrozaar Consulting
  * Plugin URI: https://github.com/Afrozaar/wp-api-v2-client-java-meta-plugin
  */
  include_once ABSPATH.'wp-admin/includes/plugin.php';
if (!is_plugin_active('rest-api/plugin.php')) {
    add_action('admin_notices', 'pim_draw_notice_rest_api');
    return;
}

if (!is_plugin_active()) {
    add_action('admin_notices', 'pim_draw_notice_rest_api_meta_endpoints');
    return;
}

// Draws notice in case parent plugin not available
function pim_draw_notice_rest_api()
{
    echo "<div id='message' class='error fade'><p style='line-height: 150%'>";
    _e('<strong>WP REST API - Afrozaar Extras</strong></a> requires the WP REST API plugin to be activated. Please <a href="http://wordpress.org/plugins/rest-api/">install / activate WP REST API</a> first.', 'rest-api');
    echo '</p></div>';
}

function pim_draw_notice_rest_api_meta_endpoints()
{
    echo "<div id='message' class='error fade'><p style='line-height: 150%'>";
    _e('<strong>WP REST API: Client-Java Meta Plugin</strong></a> requires the WP REST API Meta Endpoints plugin to be activated. Please <a href="http://wordpress.org/plugins/rest-api-meta-endpoints/">install / activate WP REST API Meta Endpoints</a> first.', 'rest-api-meta-endpoints');
    echo '</p></div>';
}

// BAOBAB INGESTOR CONFIG
/*
* meta keys are not available by default, we need this to interact with the site to set custom fields.
*/
function baobab_allow_meta_query($valid_vars)
{
    $valid_vars = array_merge($valid_vars, array('meta_key', 'meta_value', 'meta_compare'));
    return $valid_vars;
}
add_filter('rest_query_vars', 'baobab_allow_meta_query');
// BAOBAB BACKEND CONFIG END
