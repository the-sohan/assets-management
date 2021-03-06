<?php
/**
 * Plugin Name:       Assets Management
 * Plugin URI:        https://example.com/plugins/tinyslider/
 * Description:       This is practise plugin.
 * Version:           1.0
 * Author:            Sohan
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       assetsninja
 * Domain Path:       /languages
 */

define( 'ASN_ASSETS_PUBLIC_DIR', plugin_dir_url( __FILE__ )."assets/public/" );
define( 'ASN_ASSETS_ADMIN_DIR', plugin_dir_url( __FILE__ )."assets/admin/" );

class AssetsNinja{
    function __construct() {

        $this->version = time();

        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'load_front_assets' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
    }

    function load_textdomain() {
        load_plugin_textdomain( 'assetsninja', false, plugin_dir_url(__FILE__)."/languages" );
    }

    function load_admin_assets($screen){
        $_screen = get_current_screen();

        if( 'edit.php' == $screen && 'page' == $_screen->post_type ) {
            wp_enqueue_style( 'asn-admin-css', ASN_ASSETS_ADMIN_DIR ."css/admin.css", null, time() );
            wp_enqueue_script( 'asn-admin-js', ASN_ASSETS_ADMIN_DIR ."js/admin.js", array('jquery'), $this->version, true );
        }
        

    } 
    function load_front_assets(){
        wp_enqueue_style( 'asn-main-css', ASN_ASSETS_PUBLIC_DIR ."css/main.css", null, time() );

        wp_enqueue_script( 'asn-main-js', ASN_ASSETS_PUBLIC_DIR ."js/main.js", array('jquery'), $this->version, true );

        $js_files = array(
            'asn-main-js' => array('path'=>  ASN_ASSETS_PUBLIC_DIR ."js/main.js", 'dep'=>array('jquery'))
        );
        foreach( $js_files as $handle=>$fileinfo ){
            wp_enqueue_script( $handle, $fileinfo['path'], $fileinfo['dep'] );
        }        

        $data = [
            "name" => "sohan",
            "url" => "sohan.com"
        ];
        $more_data = [
            "name" => "sohan Chowdhury",
            "url" => "sohan.com2"
        ];
        $translated_string = [
            "greeting" => __( 'Hello world', 'assetsninja'),
        ];

        wp_localize_script( 'asn-main-js', 'sitedata', $data );
        wp_localize_script( 'asn-main-js', 'more_data', $more_data );
        wp_localize_script( 'asn-main-js', 'translated_data', $translated_string );

    }
}

New AssetsNinja;





