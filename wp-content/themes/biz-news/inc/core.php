<?php
/*
 * Essential actions
 * since 1.0
 */

function biz_news_do_home_slider(){
	if((is_front_page() || is_home()) && get_theme_mod('slider_in_home_page' , 1)) {
		get_template_part('templates/header', 'slider' );
		}

}
add_action('biz_news_home_slider', 'biz_news_do_home_slider');

function biz_news_do_before_header(){
	get_template_part( 'templates/header', 'banner' ); 
}

add_action('biz_news_before_header', 'biz_news_do_before_header');


function biz_news_do_header(){

		get_template_part( 'templates/contact', 'section' );
		
		do_action('biz_news_before_header');
		
		$biz_news_header = get_theme_mod('header_layout', 1);
		
		if ($biz_news_header == 0) {
			echo '<div id="site-header-main" class="site-header-main">';
			get_template_part( 'templates/header', 'default' );
			//woocommerce layout
		} else if($biz_news_header == 1 && class_exists('WooCommerce')){
			get_template_part( 'templates/woocommerce', 'header' ); 
			//list layout
		} else if ($biz_news_header == 2){
			get_template_part( 'templates/header', 'list' );
		} else {
			//default layout
			echo '<div id="site-header-main" class="site-header-main">';
			get_template_part( 'templates/header', 'default' );
		}
		
		if(is_front_page()){
			get_template_part( 'templates/header', 'hero' );
			get_template_part( 'templates/header', 'shortcode' );
		}
		
		/* end header div in default header layouts */
		if ($biz_news_header == 0) {
			echo '</div><!-- .site-header-main -->';
		}

}

add_action('biz_news_header', 'biz_news_do_header');

