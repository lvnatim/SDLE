<?php

if( of_get_option("store_open") !== "1" ){
  add_filter( 'woocommerce_is_purchasable', false);
}

//Remove margin top CSS
function remove_admin_login_header() {
  remove_action('wp_head', '_admin_bar_bump_cb');
}

//Load Assets
function asset_pipeline(){
  remove_action('wp_head', '_admin_bar_bump_cb');
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap-3.3.7-dist/css/bootstrap.css');
  wp_enqueue_style('style', get_stylesheet_uri());
  wp_register_script( 'moment', get_template_directory_uri() . '/assets/moment.min.js');
  wp_register_script( 'moment-timezone-with-data', get_template_directory_uri() . '/assets/moment-timezone-with-data.min.js');
  wp_register_script( 'countdown', get_template_directory_uri() . '/assets/jquery.countdown.min.js');
  wp_register_script( 'main', get_template_directory_uri() . '/main.js', array( 'moment' ));
  wp_enqueue_script('moment');
  wp_enqueue_script('moment-timezone-with-data');
  wp_enqueue_script('countdown');
  wp_enqueue_script('main');
  wp_localize_script( 'main', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

function get_listings(){
  if ( isset($_REQUEST) ) {
    $id = $_REQUEST['page_num'];
    $listings = get_template_part('listings');  
    echo $description;
  }
  die();
}

function get_listings_count(){
  echo wp_count_posts('product')->publish;
  die();
}

add_action( 'wp_ajax_get_listings_count', 'get_listings_count' );
add_action( 'wp_ajax_nopriv_get_listings_count', 'get_listings_count' );
add_action( 'wp_ajax_get_listings', 'get_listings' );
add_action( 'wp_ajax_nopriv_get_listings', 'get_listings' );
add_action( 'wp_enqueue_scripts', 'asset_pipeline' );

?>