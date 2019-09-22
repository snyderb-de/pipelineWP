<?php

//disable query strings
function _remove_script_version( $src ){
    $parts = explode( '?ver', $src );
        return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );


//Disable Emoji's; they're dumb.
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );


function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}


//older code & test code below
/**
//Set minimum order amount in WooCommerce
add_action( 'woocommerce_checkout_process', 'wc_minimum_order_amount' );
add_action( 'woocommerce_before_cart' , 'wc_minimum_order_amount' );
function wc_minimum_order_amount() {
	// Set this variable to specify a minimum order value
	$minimum = 200;
	if ( WC()->cart->total < $minimum ) {
		if( is_cart() ) {
			wc_print_notice(
				sprintf( 'You must have an order with a minimum of %s to place your order, your current order total is %s.' ,
					woocommerce_price( $minimum ),
					woocommerce_price( WC()->cart->total )
				), 'error'
			);
		} else {
			wc_add_notice(
				sprintf( 'You must have an order with a minimum of %s to place your order, your current order total is %s.' ,
					woocommerce_price( $minimum ),
					woocommerce_price( WC()->cart->total )
				), 'error'
			);
		}
	}
}
*/

/**
//Update the order meta with field value
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['billing_acct-rep'] ) ) {
        update_post_meta( $order_id, 'billing_acct-rep', sanitize_text_field( $_POST['billing_acct-rep'] ) );
    }
}
*/

/**
//Add the field to order emails

add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');
function my_custom_checkout_field_order_meta_keys( $keys ) {
	$keys['Your Account Rep'] = 'billing_acct-rep';
	return $keys;
}
*/

/**
//Display field value on the order edit page
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
function my_custom_checkout_field_display_admin_order_meta($order){
    print '<p><strong>'.__('Rep').':</strong> ' . get_post_meta( $order->id, 'billing_acct-rep', true ) . '</p>';
}
*/
