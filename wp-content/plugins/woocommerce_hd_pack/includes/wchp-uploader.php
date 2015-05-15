<?php
/**
 * @author: he11d0g
 * @date:   14.05.15
 */

class WCHP_Uploader {
    public function get_wp_version() {
        global $wp_version;
        return $wp_version;
    }

    public function __construct(){
        add_action('whcp_product_cat_register_script', array($this,'admin_scripts_init'));
    }

//add media WP scripts
    public function admin_scripts_init() {
            //double check for WordPress version and function exists
            if(function_exists('wp_enqueue_media') && version_compare($this->get_wp_version(), '3.5', '>=')) {
                //call for new media manager
                wp_enqueue_media();
            }
            //old WP < 3.5
            else {
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_enqueue_style('thickbox');
            }
            //our script
            wp_register_script('wchp_uploader', WP_PLUGIN_URL . '/woocommerce_hd_pack/assets/js/wchp.uploader.js');
            wp_enqueue_script('wchp_uploader');

            //maybe..
            wp_enqueue_style('media');
    }
}

new WCHP_Uploader();