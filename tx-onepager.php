<?php
/**
 * Plugin Name:       TX OnePager
 * Plugin URI:        http://themexpert.com/wordpress-plugins/xpert-wponepager
 * Description:       Onepage Builder that helps you to make one page website seamlessly. Beautifully
 * Version:           1.0.0
 * Author:            ThemeXpert
 * Author URI:        http://www.themexpert.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tx-onepager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

define( 'ONEPAGER_VERSION', '1.0' );
define( 'ONEPAGER_PHP_VERSION', '5.4' );

define( 'ONEPAGER_URL', plugins_url( '', __FILE__ ) );
define( 'ONEPAGER_PATH', dirname( __FILE__ ) );

function onepager_php_version_check() {
  if ( ! version_compare( PHP_VERSION, ONEPAGER_PHP_VERSION, '<' ) ) {
    return;
  }

  $notice =
    'You are running ancient version of PHP-<strong>%s</strong>.
    Onepager requires at least PHP <strong>%s</strong> to run smoothly.
    <br/>Please update your PHP version to run this plugin and keep you website secure.';

  wp_die( sprintf( $notice, PHP_VERSION, ONEPAGER_PHP_VERSION ) );
}

onepager_php_version_check();


require( ONEPAGER_PATH . '/app/inc/constants.php' );
require( ONEPAGER_PATH . '/app/inc/support.php' );
require( ONEPAGER_PATH . '/src/functions.php' );
require( ONEPAGER_PATH . '/src/theme_helpers.php' );
require( ONEPAGER_PATH . '/vendor/autoload.php' );

require( ONEPAGER_PATH . '/app/Onepager.php' );
require( ONEPAGER_PATH . '/app/bootstrap.php' );

require( ONEPAGER_PATH . '/app/Api/routes.php' );
require( ONEPAGER_PATH . '/app/OptionsPanel/settings.php' );
require( ONEPAGER_PATH . '/app/Metabox/metabox.php' );
require( ONEPAGER_PATH . '/app/Dashboard/dashboard.php' );
