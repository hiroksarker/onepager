<?php

use ThemeXpert\View\View;

add_action( 'add_meta_boxes', 'tx_add_onepager_metabox', 1 );
add_action( 'admin_enqueue_scripts', 'tx_onepager_metabox_scripts' );

function tx_get_groups( $groups ) {
  return implode( "", array_map( function ( $group ) {
    return "og-" . $group;
  }, $groups ) );
}

function tx_add_onepager_metabox() {
  $template = function ( $post ) {
    $onepagerLayouts = onepager()->presetManager()->all();
    $groups          = array_unique( array_reduce( $onepagerLayouts, function ( $carry, $layout ) {
      return array_merge( $carry, $layout['group'] );
    }, [ ] ) );

    $sections = onepager()->section()->getAllValid( $post->ID );
    $editorUrl = getOpBuildModeUrl( get_permalink( $post->ID ), true );

    echo View::getInstance()->make(__DIR__ . "/page-meta.php",
      compact('onepagerLayouts','post', 'groups', 'sections', 'editorUrl'));
  };

  add_meta_box(
    'onepager_meta',
    __( 'Preset Templates', 'onepager' ),
    $template,
    'page',
    'normal', apply_filters( 'onepager_metabox_prio', 'high' )
  );
}

function tx_onepager_metabox_scripts( $hook ) {
  global $post;

  if ( ! ( $post && $post->post_type == "page" ) ) {
    return;
  }

  if ( ! ( $hook == 'post-new.php' || $hook == 'post.php' ) ) {
    return;
  }

  $data = array(
    'pageId'       => $post->ID,
    'buildModeUrl' => getOpBuildModeUrl( get_permalink( $post->ID ), true ),
  );

  wp_enqueue_script( 'tx-onepager-page-meta', asset( 'assets/meta.js' ), true );
  wp_enqueue_style( 'tx-lithium', asset( 'assets/css/lithium-builder.css' ) );
  wp_localize_script( 'tx-onepager-page-meta', 'onepager', $data );
}

