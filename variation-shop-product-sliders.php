<?php
/*
	 Plugin Name: Variation Shop Product Sliders
	 Plugin URI:
	 Description: With the "variation shop product sliders" plugin you could display your products variation as mini sliders on your shop page. 
	 Author: Gabriel Alfaro
	 Version: 1.1
	 Author URI:
	 License: GPLv2
*/

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

/*------------------------------------------  Variation Shop Page Sliders Function -------------------------------------------*/
//Create variation slider and button options
function vsps_product_colors() {
	global $product;

	$product_ID = get_the_ID();
	$attachment_id = get_post_thumbnail_id($product_ID);
			
	if( $product->is_type( 'simple' ) ){
		// No variations products
		// Get product id and display single product
		$url = wp_get_attachment_image_src( $attachment_id, $size = 'woocommerce_thumbnail')[0];
		// create container for slides for all the products in shop page
		echo "<div class='' style='text-align: center'>";
			// Display slider images and surround them with the product page link
			echo "<a href='" . get_permalink($product_ID) . "'>";
				echo '<div class="" style="padding-bottom: 55px;">';
				echo "<img src='" . $url . "' >";
				echo '</div>';
			echo "</a>";
		echo "<div>";
	} elseif( $product->is_type( 'variable' ) ){
		// Product has variations
		// Get product id and variable products
		$product = new WC_Product_Variable( $product_ID );
		
		$variations = $product->get_available_variations();

		// create array to contain attributes
		$attributes = array();

		// create container for slides for all the products in shop page
		echo "<div class='vsps-slideshow-container' style='text-align: center'>";
			// Display slider images and surround them with the product page link
			echo "<a href='" . get_permalink($product_ID) . "'>";
				foreach ( $variations as $variation ) {
					echo '<div class="vspsSlides vsps_slider_fade">';
					echo "<img src='" . $variation['image']['src'] . "' >";
					echo '</div>';					
				}
			echo "</a>";
		
			// Create images/dots which change the prodcut varation image when clicked
			$i = 0;
			echo "<div class='vsps-slider-container'>";
			foreach ( $variations as $variation ) {
				if($i == 5) break;
				// get attribute
				$vColor = $variation['attributes']['attribute_color'];

				// build attributes array
				if(!in_array($vColor, $attributes, true)){

				// For center zoomed imaged
				//echo "<span class='vsps-dot vsps-dot-color-selected' style='background: url(" . $variation['image']['thumb_src'] . ");' title='$vColor'></span>"
				echo "<span class='vsps-dot vsps-dot-color-selected' style='background: $vColor'></span>";
				$i++;
					array_push($attributes, $vColor);
				}				
			}
			echo "</div>";
		echo "<div>";
	}
}
// Remove default feature page to replace with slider created
function VarShoProSli_remove_defaults(){
	// Remove default feature image to replace with slider
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
	// Remove surrounding links
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
}
add_action('init', 'VarShoProSli_remove_defaults');
// Display Variation Slider
add_action( 'woocommerce_before_shop_loop_item_title', 'vsps_product_colors', 30, 0 );
/*------------------------------------------  End Of Variation Slider Function -------------------------------------------*/

/*------------------------------------------  Enque Scripts & Styles Slider Function -------------------------------------------*/
/*------ Add css and javascript files to website pages ---------*/
function VarShoSli_style_enqueue() {
	wp_enqueue_style( 'WSSstyles', plugins_url( 'css/styles.css', __FILE__ ), false );
	wp_enqueue_script( 'WSSscripts', plugins_url( 'js/scripts.js', __FILE__ ), '', '', true );
}
add_action( 'wp_enqueue_scripts', 'VarShoSli_style_enqueue' );
?>