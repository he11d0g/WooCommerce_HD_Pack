<?php

/*
Plugin Name: WooCommerce HD Pack
Plugin URI: http://netsquad.ru
Description: A brief description of the Plugin.
Version: 0.1
Author: he11d0g
Author URI: http://netsquad.ru
License: A "Slug" license name e.g. GPL2
*/
if ( ! defined( 'ABSPATH' ) ) exit;
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    define('WCHP_PATH',__DIR__);

    if ( ! class_exists( 'WCHP' ) ) {

        /**
         * Localisation
         **/
        load_plugin_textdomain( 'wchp', false, dirname( plugin_basename( __FILE__ ) ) . '/' );

        class WCHP {

            public function __construct() {
                include( 'includes/wchp-db.php' );

                register_activation_hook( __FILE__, array( &$this, 'install' ) );
                // called only after woocommerce has finished loading
                add_action( 'woocommerce_init', array( &$this, 'woocommerce_loaded' ) );
                // called after all plugins have loaded
                add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );

                // called just before the woocommerce template functions are included
                add_action( 'init', array( &$this, 'include_functions' ), 20 );

                // indicates we are running the admin
                if ( is_admin() ) {
                    // ...
                }

                // indicates we are being served over ssl
                if ( is_ssl() ) {
                    // ...
                }

                // take care of anything else that needs to be done immediately upon plugin instantiation, here in the constructor
            }


            public function install()
            {
                WCHP_Db::install();
            }


            /**
             * Take care of anything that needs woocommerce to be loaded.
             * For instance, if you need access to the $woocommerce global
             */
            public function woocommerce_loaded() {

            }

            /**
             * Take care of anything that needs all plugins to be loaded
             */
            public function plugins_loaded() {
                $this->register_styles();
                include( 'includes/wchp-uploader.php' );
                include( 'includes/wchp-helper.php' );
            }


            /**
             * Override any of the template functions from woocommerce/woocommerce-template.php
             * with our own template functions file
             */
            public function include_functions() {
                include( 'includes/wchp-action.php' );
                include( 'includes/wchp-filter.php' );
            }

            public function register_styles()
            {
                wp_register_style('wchp_main_css', WP_PLUGIN_URL . '/woocommerce_hd_pack/assets/css/main.css');
                wp_enqueue_style('wchp_main_css');
            }
        }

        // finally instantiate our plugin class and add it to the set of globals
        $GLOBALS['wchp'] = new WCHP();
    }
}
