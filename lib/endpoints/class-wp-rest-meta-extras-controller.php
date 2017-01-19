<?php

  class WP_REST_Meta_Extras_Controller extends WP_REST_Meta_Posts_Controller {

    protected $parent_base = null;
    protected $parent_post_type = null;

    public function __construct( $parent_post_type = 'post') {
      parent::__construct($parent_post_type);
    }

    public function register_routes() {

      register_rest_route( $this->namespace, '/' . $this->parent_base . '/(?P<parent_id>[\d]+)/' . $this->rest_base . '/(?P<id>[\d]+)' . '/delete', array(
        array(
          'methods'             => WP_REST_Server::CREATABLE,
          'callback'            => array( $this, 'delete_item' ),
          'permission_callback' => array( $this, 'delete_item_permissions_check'),
          'args'                => array(
            'force' => array(
              'default'     => false,
              'description' => __( 'Required to be true, as resource does not support trashing.' ),
            ),
          ),
        ),
      ) );

    }

  }
