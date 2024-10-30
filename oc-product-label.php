<?php
/**
* Plugin Name: Improved badges for woocommerce
* Description: This plugin allows create Improved badges for woocommerce plugin.
* Version: 1.0.1
* Copyright: 2020
* Text Domain: improved-badges-for-woocommerce
* Domain Path: /languages
*/

if (!defined('ABSPATH')) {
	die('-1');
}
if (!defined('IBFW_PLUGIN_NAME')) {
  	define('IBFW_PLUGIN_NAME', 'Improved badges for woocommerce');
}
if (!defined('IBFW_PLUGIN_VERSION')) {
  	define('IBFW_PLUGIN_VERSION', '1.0.0');
}
if (!defined('IBFW_PLUGIN_FILE')) {
  	define('IBFW_PLUGIN_FILE', __FILE__);
}
if (!defined('IBFW_PLUGIN_DIR')) {
  	define('IBFW_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('IBFW_BASE_NAME')) {
    define('IBFW_BASE_NAME', plugin_basename(IBFW_PLUGIN_FILE));
}
if (!defined('IBFW_DOMAIN')) {
  	define('IBFW_DOMAIN', 'improved-badges-for-woocommerce');
}

if (!class_exists('IBFW')) {

  	class IBFW {

	    protected static $IBFW_instance;
	    function __construct() {
	        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	        //check plugin activted or not
	        add_action('admin_init', array($this, 'IBFW_check_plugin_state'));
	    }


	    function IBFW_check_plugin_state() {
	      	if ( ! ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
	        	set_transient( get_current_user_id() . 'ibfwerror', 'message' );
	      	}
	    }


	    function init() {
	      	add_action( 'admin_notices', array($this, 'IBFW_show_notice'));
	      	add_action( 'admin_enqueue_scripts', array($this, 'IBFW_load_admin'));
	      	add_action( 'wp_enqueue_scripts',  array($this, 'IBFW_load_front'));
	      	add_filter( 'plugin_row_meta', array( $this, 'IBFW_plugin_row_meta' ), 10, 2 );
	    }



	    function IBFW_show_notice() {
	        if ( get_transient( get_current_user_id() . 'ibfwerror' ) ) {

	          	deactivate_plugins( plugin_basename( __FILE__ ) );

	          	delete_transient( get_current_user_id() . 'ibfwerror' );

	          	echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=woocommerce">WooCommerce</a> plugin installed and activated.</p></div>';
	        }
	    }


	    function IBFW_load_admin() {
	      	wp_enqueue_style( 'IBFW_admin_style', IBFW_PLUGIN_DIR . '/includes/css/ocpl_admin_style.css', false, '1.0.0' );
	      	wp_enqueue_script( 'IBFW_admin_script', IBFW_PLUGIN_DIR . '/includes/js/ocpl_admin_script.js', array( 'jquery', 'select2') );
	      	wp_localize_script( 'ajaxloadpost', 'ajax_postajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	      	wp_enqueue_style( 'woocommerce_admin_styles-css', WP_PLUGIN_URL. '/woocommerce/assets/css/admin.css',false,'1.0',"all");
	      	wp_enqueue_style( 'wp-color-picker' );
        	wp_enqueue_script( 'wp-color-picker-alpha', IBFW_PLUGIN_DIR . '/includes/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true );
        	wp_enqueue_media();
           
            $badge_define = get_post_meta(get_the_ID() ,'badge_define',true );
            $ibfw_background=get_post_meta(get_the_ID(), 'ibfw_background' ,true );
            $ocpl_image_position=get_post_meta(get_the_ID(), 'ocpl_image_position' ,true );
            wp_localize_script('IBFW_admin_script', 'ibfwDATA', array(
            	'badge_define' => $badge_define,
            	'ibfw_background' =>  $ibfw_background,
            	'ocpl_image_position'=>$ocpl_image_position,
			));
	    }


	    function IBFW_load_front() {
	    	wp_enqueue_style( 'IBFW_front_style', IBFW_PLUGIN_DIR . '/includes/css/ocpl_front_style.css', false, '1.0.0' );
	    }
	   

	    function IBFW_plugin_row_meta( $links, $file ) {
            if ( IBFW_BASE_NAME === $file ) {
                $row_meta = array(
                    'rating'=>'<a href="https://oceanwebguru.com/improved-badges-for-woocommerce/" target="_blank">Documentation</a> | <a href="https://oceanwebguru.com/contact-us/" target="_blank">Support</a> | <a href="https://wordpress.org/support/plugin/improved-badges-for-woocommerce/reviews/?filter=5" target="_blank"><img src="'.IBFW_PLUGIN_DIR.'/includes/images/star.png" class="ibfw_rating_div"></a>',
                );

                return array_merge( $links, $row_meta );
            }
            return (array) $links;
      	}


	    function includes() {
		    include_once('admin/backend_menu.php');
		    include_once('admin/ibfw_kit.php');
		    include_once('front/front.php');
	    }


	    public static function IBFW_instance() {
	      	if (!isset(self::$IBFW_instance)) {
	        	self::$IBFW_instance = new self();
	        	self::$IBFW_instance->init();
	        	self::$IBFW_instance->includes();
	      	}
	      	return self::$IBFW_instance;
	    }
  	}

  	add_action('plugins_loaded', array('IBFW', 'IBFW_instance'));
}

add_action( 'plugins_loaded', 'IBFW_load_textdomain' );
function IBFW_load_textdomain() {
    load_plugin_textdomain( 'improved-badges-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

function IBFW_load_my_own_textdomain( $mofile, $domain ) {
    if ( 'improved-badges-for-woocommerce' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'IBFW_load_my_own_textdomain', 10, 2 );