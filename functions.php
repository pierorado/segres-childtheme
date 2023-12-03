<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION
// =========================================================================
// DROPDOWN FILTER SHORTCODE 
// =========================================================================
function dropdown_filter_shortcode(){
    ob_start();
        include('ajax-dropdown/dropdown-filter.php');
    return ob_get_clean();
}
add_shortcode('dropdown-filter', 'dropdown_filter_shortcode');
// =========================================================================
// PROCESS THE REQUEST 
// =========================================================================
function wpflames_filter_function(){
	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'] // ASC or DESC
	);
 
	// for taxonomies / categories
	if( isset( $_POST['categoryfilter'] ) )
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'categoria-soluciones',
				'field' => 'id',
				'terms' => $_POST['categoryfilter']
			)
		);
	
	// if you want to use multiple checkboxed, just duplicate the above 5 lines for each checkbox
 
	$query = new WP_Query( $args );
 
	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
			echo '<h2>' . $query->post->post_title . '</h2>';
		endwhile;
		wp_reset_postdata();
	else :
		echo 'No posts found';
	endif;
 
	die();
}
add_action('wp_ajax_myfilter', 'wpflames_filter_function'); 
add_action('wp_ajax_nopriv_myfilter', 'wpflames_filter_function');
// DEFINE CONSTANTS
// =============================================================
define('THEME', get_stylesheet_directory_uri());

// =============================================================
// ENQUEUE SCRIPTS
// =============================================================
function add_custom_scripts() {
    wp_enqueue_script( 'ajax_term', THEME . '/ajax-dropdown/dropdown-filter.js', array('jquery'), NULL, true );
    wp_localize_script( 'ajax_term', 'wpAjax', array('ajaxUrl' => admin_url('admin-ajax.php')));	
}
add_action( 'wp_enqueue_scripts', 'add_custom_scripts' );
// =========================================================================
// AJAX FILTER CALLBACK FUNCTION
// =========================================================================
require_once('ajax-dropdown/callback.php');
// AJAX FILTER FORM CPT TAXONOMIES SHORTCODE
// =========================================================================
function ajax_filter_shortcode_terms(){
    ob_start();
		include('ajax-dropdown/filter.php');
    return ob_get_clean();
}
add_shortcode('ajax_filter_terms', 'ajax_filter_shortcode_terms');