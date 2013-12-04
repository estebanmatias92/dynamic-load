<?php
/**
 * Dynamic Load.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   Dynamic_Load
 * @author    Matias Esteban <estebanmatias92@gmail.com>
 * @license   MIT License
 * @link      http://example.com
 * @copyright 2013 Matias Esteban
 *
 * @wordpress-plugin
 * Plugin Name: Dynamic Load
 * Plugin URI:  TODO
 * Description: TODO
 * Version:     1.0.0
 * Author:      Matias Esteban
 * Author URI:  TODO
 * Text Domain: plugin-name-locale
 * License:     MIT License
 * License URI: http://opensource.org/licenses/MIT
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// TODO: replace `class-plugin-name.php` with the name of the actual plugin's class file
require_once( plugin_dir_path( __FILE__ ) . 'includes/helpers.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-dynamic-load.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-dynamic-load-script.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-dynamic-load-style.php' );
