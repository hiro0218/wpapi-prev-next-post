<?php
/**
* Plugin Name: wpapi-prev-next-post
* Plugin URI: https://github.com/hiro0218/wpapi-prev-next-post
* Description: Add links of previous and next post to WP API.
* Version: 1.0.0
* Author: hiro
* Author URI: https://b.0218.jp/
* License: GPLv2 or later
**/

class Wpapi_Prev_Next_Post {

  function __construct() {
    add_action('rest_api_init', array($this, 'add_prev_post'));
    add_action('rest_api_init', array($this, 'add_next_post'));
  }

  public function add_prev_post() {
      register_rest_field('post', 'prev_post', array(
        'get_callback'    => array($this, 'get_prev_post'),
        'update_callback' => null,
        'schema'          => null,
      ));
  }
  public function add_next_post() {
    register_rest_field('post', 'next_post', array(
      'get_callback'    => array($this, 'get_next_post'),
      'update_callback' => null,
      'schema'          => null,
    ));
  }

  public function get_prev_post($object, $request) {
    global $post;
    $post = get_post($object['id']);
    $prev_post = get_previous_post();

    if (empty($prev_post)) {
      return;
    }

    $prev_object = (object) array(
      'id'    => $prev_post->ID,
      'slug'  => $prev_post->post_name,
      'title' => $prev_post->post_title,
    );

    return $prev_object;
  }

  public function get_next_post($object, $request) {
    global $post;
    $post = get_post($object['id']);
    $next_post = get_next_post();

    if (empty($next_post)) {
      return;
    }

    $next_object = (object) array(
      'id'    => $next_post->ID,
      'slug'  => $next_post->post_name,
      'title' => $next_post->post_title,
    );

    return $next_object;
  }

}

$Wpapi_Prev_Next_Post = new Wpapi_Prev_Next_Post();
