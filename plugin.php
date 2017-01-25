<?php
  /*
  * Plugin Name: WP REST API - Client-Java Meta Plugin
  * Description:  Enables meta endpoints required by wp-api-2.0-beta12+
  * Version:  0.2
  * Author: Afrozaar Consulting
  * Plugin URI: https://github.com/Afrozaar/wp-api-v2-client-java-meta-plugin
  */
  include_once ABSPATH . 'wp-admin/includes/plugin.php';

  const REG_4_7 = "/4\\.7(\\.\\d+)?/i";
  const FILTER_QUERY_VARS_4_7 = "query_vars";
  const FILTER_QUERY_VARS_4_6 = "rest_query_vars";

  function merge_meta_query( $vars ) {
    return array_merge( $vars, array( 'meta_key', 'meta_value', 'meta_compare', /*'meta_query', *'tax_query'*/ ) );
  }

  if ( ! preg_match( REG_4_7, get_bloginfo( 'version' ) )) {
    /**
     * Wordpress < 4.7 (WP-REST not integrated in Core, rest-api plugin required)
     */
    if ( ! is_plugin_active( 'rest-api/plugin.php' )) {
      add_action( 'admin_notices', 'pim_draw_notice_rest_api_client_java' );
      return;
    }

    add_filter( FILTER_QUERY_VARS_4_6, 'merge_meta_query' );
  } else {
    /**
     * Wordpress >= 4.7 (WP-REST is integrated in Core)
     */

    add_filter( FILTER_QUERY_VARS_4_7, 'merge_meta_query' );
  }

  if ( ! is_plugin_active( 'rest-api-meta-endpoints/plugin.php' )) {
    add_action( 'admin_notices', 'pim_draw_notice_rest_api_meta_endpoints_client_java' );
    return;
  }

  require_once ABSPATH . 'wp-content/plugins/rest-api-meta-endpoints/lib/class-wp-rest-meta-controller.php';
  require_once ABSPATH . 'wp-content/plugins/rest-api-meta-endpoints/lib/class-wp-rest-meta-posts-controller.php';
  require_once dirname( __FILE__ ) . '/lib/endpoints/class-wp-rest-meta-extras-controller.php';

// Draws notice in case parent plugin not available
  function pim_draw_notice_rest_api_client_java() {
    echo "<div id='message' class='error fade'><p style='line-height: 150%'>";
    _e('<strong>WP REST API: Client-Java Meta Plugin</strong></a> requires the WP REST API plugin to be activated. Please <a href="http://wordpress.org/plugins/rest-api/">install / activate WP REST API</a> first.', 'rest-api');
    echo '</p></div>';
  }

  function pim_draw_notice_rest_api_meta_endpoints_client_java() {
    echo "<div id='message' class='error fade'><p style='line-height: 150%'>";
    _e( '<strong>WP REST API: Client-Java Meta Plugin</strong></a> requires the WP REST API Meta Endpoints plugin to be activated. Please <a href="http://wordpress.org/plugins/rest-api-meta-endpoints/">install / activate WP REST API Meta Endpoints</a> first.', 'rest-api-meta-endpoints' );
    echo '</p></div>';
  }

  add_action( 'rest_api_init', function () {

    //    // Meta extras
    $controller = new WP_REST_Meta_Extras_Controller();
    $controller->register_routes();

  } );
