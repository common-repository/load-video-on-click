<?php
/*
Plugin Name: Load video on click
Description: No matter how many videos, they will load on click, no performance loss any more.
Author: Jose Mortellaro
Author URI: https://josemortellaro.com
Domain Path: /languages/
Text Domain: load-video-on-click
Version: 0.0.5
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

//Definitions
define( 'LOAD_VIDEO_ON_CLICK_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'LOAD_VIDEO_ON_CLICK_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

add_shortcode( 'load_video_on_click','eos_load_on_click_shortcode' );
//Add shortcode
function eos_load_on_click_shortcode( $atts,$content = null ){
  require LOAD_VIDEO_ON_CLICK_PLUGIN_DIR.'/inc/lvoc-shortcode.php';
  return $output;
}


add_action( 'plugins_loaded','eos_load_on_click_integrations' );
//LOad integrations with supported page builders
function eos_load_on_click_integrations(){
  if( ( is_admin() || isset( $_GET['vc_editable'] ) ) && function_exists( 'vc_map' ) ){
    require_once LOAD_VIDEO_ON_CLICK_PLUGIN_DIR.'/inc/integrations/lvoc-wpbakery.php';
  }
}

add_action( 'admin_head',function(){
  if( function_exists( 'vc_map' ) ){
    echo '<style id="lvoc-css-admin">.icon-eosb-video-icon{background-image: url('.LOAD_VIDEO_ON_CLICK_PLUGIN_URL.'/assets/img/element-icon-video.svg) !important}</style>';
  }
} );

add_filter( 'render_block',function( $block_content,$block ){
  if( in_array( $block['blockName'],array( 'core/embed','core/video' ) ) ){
    $attrs = $block['attrs'];
    if( isset( $attrs['loadOnClick'] ) && apply_filters( 'load_video_on_click_for_blocks',$attrs['loadOnClick'] ) ){
      $args = array(
        'link' => 'core/video' === $block['blockName'] ? wp_get_attachment_url( absint( $attrs['id'] ) ) : esc_url( $attrs['url'] )
      );
      if( isset( $attrs['className'] ) ){
        $args['el_class'] = esc_attr( $attrs['className'] );
      }
      $image_placeholder = apply_filters( 'load_video_on_click_image_placeholder',false,$attrs );
      if( $image_placeholder && $image_placeholder === esc_url( $image_placeholder ) ){
        $args['image_placeholder'] = esc_url( $image_placeholder );
      }
      elseif( false !== strpos( $block_content,'poster="' ) ){
        $arr = explode( 'poster="',$block_content );
        if( isset( $arr[1] ) ){
          $arr = explode( '"',$arr[1] );
          if( $arr[0] === esc_url( $arr[0] ) ){
            $args['image_placeholder'] = esc_url( $arr[0] );
          }
        }
      }
      return eos_load_on_click_shortcode( $args );
    }
  }
  return $block_content;
},20,2 );

add_action( 'enqueue_block_editor_assets',function() {
  $url = LOAD_VIDEO_ON_CLICK_PLUGIN_URL.'/assets/js/editor-block.js';
  wp_enqueue_script( 'load-video-on-click-block',$url,array( 'wp-blocks','wp-element','wp-i18n' ),filemtime( $url ) );
} );
