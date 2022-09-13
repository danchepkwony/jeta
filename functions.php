<?php

include('attendees.php');

/**
 * Enqueue scripts and styles.
 */
function jeta_enqueue_scripts() {
	wp_enqueue_style( 'jeta-styles', get_template_directory_uri() . '/assets/css/style.css', [], '1.0.0' );
	wp_enqueue_script( 'jeta-buttons', get_template_directory_uri() . '/assets/js/buttons.js', ['jquery'], '1.0.0' );
	wp_register_script( 'jeta-react', get_template_directory_uri() . '/assets/js/reactApp.js', [], '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'jeta_enqueue_scripts' );


/**
 * Path for image data
 */
if( !defined('THEME_IMG_PATH')){
	define('THEME_IMG_PATH', get_template_directory_uri() . '/assets/images' );
}

/**
 * Path for JSON data
 */
if( !defined('THEME_JSON_PATH')){
	define('THEME_JSON_PATH', get_template_directory_uri() . '/assets/text' );
}

/** 
 * Include primary navigation menu
 */
function init_jeta_nav() {
	register_nav_menus( array(
		'menu' => 'Primary Menu',
	) );
}
add_action( 'init', 'init_jeta_nav' );

/**
 * Remove gutenberg editor from custom post types
 */
function init_remove_editor(){
	remove_post_type_support( 'programs', 'editor');
	remove_post_type_support( 'locations', 'editor');
	remove_post_type_support( 'copy', 'editor');
	remove_post_type_support( 'staff', 'editor');
}
add_action( 'init', 'init_remove_editor',100);

/**
 * Allow react router to handle page requests on programs page
 */

function init_rewrite_rules() {
    add_rewrite_rule('^programs/(.+)?', 'index.php?pagename=programs', 'top');
}
add_action('init', 'init_rewrite_rules');

/**
 * Set up ACF Google Maps Location API 
 */

function acf_google_map_api( $api ){
	$config = include('config.php');
	$api['key'] = $config->maps_api_key;
	return $api;
}

add_filter('acf/fields/google_map/api', 'acf_google_map_api');

/**
 * Register Custom Post Types
 */

function cptui_register_my_cpts() {

	/**
	 * Post Type: Programs.
	 */

	$labels = [
		"name" => __( "Programs", "custom-post-type-ui" ),
		"singular_name" => __( "Program", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Programs", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "programs", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-calendar",
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "programs", $args );

	/**
	 * Post Type: Locations.
	 */

	$labels = [
		"name" => __( "Locations", "custom-post-type-ui" ),
		"singular_name" => __( "Location", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Locations", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "locations", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-location",
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "locations", $args );

	/**
	 * Post Type: Copy Text.
	 */

	$labels = [
		"name" => __( "Copy Text", "custom-post-type-ui" ),
		"singular_name" => __( "Copy", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Copy Text", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "copy", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-format-quote",
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "copy", $args );

	/**
	 * Post Type: Staff.
	 */

	$labels = [
		"name" => __( "Staff", "custom-post-type-ui" ),
		"singular_name" => __( "Staff", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Staff", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "staff", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-admin-users",
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "staff", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );
