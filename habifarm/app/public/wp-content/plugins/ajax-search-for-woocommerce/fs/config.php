<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Create a helper function for easy SDK access.
function dgoraAsfwFs()
{
    global  $dgoraAsfwFs ;
    
    if ( !isset( $dgoraAsfwFs ) ) {
        // Include Freemius SDK.
        require_once dirname( __FILE__ ) . '/lib/start.php';
        // Activate multisite network integration.
        if ( !defined( 'WP_FS__PRODUCT_700_MULTISITE' ) ) {
            define( 'WP_FS__PRODUCT_700_MULTISITE', true );
        }
        $dgoraAsfwFs = fs_dynamic_init( array(
            'id'             => '700',
            'slug'           => 'ajax-search-for-woocommerce',
            'type'           => 'plugin',
            'public_key'     => 'pk_f4f2a51dbe0aee43de0692db77a3e',
            'is_premium'     => false,
            'premium_suffix' => 'Pro',
            'has_addons'     => false,
            'has_paid_plans' => true,
            'menu'           => array(
            'slug'        => 'dgwt_wcas_settings',
            'parent'      => array(
            'slug' => 'woocommerce',
        ),
            'account'     => false,
            'contact'     => false,
            'support'     => false,
            'pricing'     => false,
            'affiliation' => false,
        ),
            'is_live'        => true,
        ) );
    }
    
    return $dgoraAsfwFs;
}

// Init Freemius.
dgoraAsfwFs();
// Signal that SDK was initiated.
do_action( 'dgoraAsfwFs_loaded' );
dgoraAsfwFs()->add_filter( 'plugin_icon', function () {
    return dirname( dirname( __FILE__ ) ) . '/assets/img/logo-128.png';
} );