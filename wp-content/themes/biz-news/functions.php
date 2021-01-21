<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if ( ! function_exists( 'agency_starter_default_settings' ) ) :

function agency_starter_default_settings($param){
	$values = array (
					 'background_color'=> '#fff', 
					 'page_background_color'=> '#fff', 
					 'woocommerce_menubar_color'=> '#fff', 
					 'woocommerce_menubar_text_color'=> '#333333', 
					 'link_color'=>  '#8e4403',
					 'main_text_color' => '#1a1a1a', 
					 'primary_color'=> '#ff7c09',
					 'header_bg_color'=> '#fff',
					 'header_text_color'=> '#333333',
					 'footer_bg_color'=> '#282828',
					 'footer_text_color'=> '#fff',
					 'header_contact_social_bg_color'=> '#ff7c09',
					 'footer_border' =>'1',
					 'hero_border' =>'1',
					 'header_layout' =>'1',
					 'heading_font' => 'Roboto', 
					 'body_font' => 'Google Sans'					 
					 );
					 
	return $values[$param];
}

endif;

/*
 * BEGIN ENQUEUE PARENT ACTION
 * AUTO GENERATED - Do not modify or remove comment markers above or below:
 */
 
/* Override parent theme help notice */



 
if ( !function_exists( 'biz_news_locale_css' ) ):
    function biz_news_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'biz_news_locale_css' );

if ( !function_exists( 'biz_news_parent_css' ) ):
    function biz_news_parent_css() {
        wp_enqueue_style( 'biz_news_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap','fontawesome' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'biz_news_parent_css', 10 );


if ( class_exists( 'WP_Customize_Control' ) ) {

	require get_template_directory() .'/inc/color-picker/alpha-color-picker.php';
}


function biz_news_wp_body_open(){
	do_action( 'wp_body_open' );
}

if ( ! function_exists( 'biz_news_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 */
	function biz_news_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

/**
 * @since 1.0.0
 * add home link.
 */
function biz_news_nav_wrap() {
  $wrap  = '<ul id="%1$s" class="%2$s">';
  $wrap .= '<li class="hidden-xs"><a href="/"><i class="fa fa-home"></i></a></li>';
  $wrap .= '%3$s';
  $wrap .= '</ul>';
  return $wrap;
}


/* 
 * add customizer settings 
 */
add_action( 'customize_register', 'biz_news_customize_register' );  
function biz_news_customize_register( $wp_customize ) {


	// banner image
	$wp_customize->add_setting( 'banner_image' , 
		array(
			'default' 		=> '',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'banner_image' ,
		array(
			'label'          => __( 'Banner Image', 'biz-news' ),
			'description'	=> __('Upload banner image', 'biz-news'),
			'settings'  => 'banner_image',
			'section'        => 'theme_header',
		))
	);
	
	$wp_customize->add_setting('banner_link' , array(
		'default'    => '#',
		'sanitize_callback' => 'esc_url_raw',
	));
	
	
	$wp_customize->add_control('banner_link' , array(
		'label' => __('Banner Link', 'biz-news' ),
		'section' => 'theme_header',
		'type'=> 'url',
	) );
	

	//breadcrumb 

	$wp_customize->add_section( 'breadcrumb_section' , array(
		'title'      => __( 'Header Breadcrumb', 'biz-news' ),
		'priority'   => 3,
		'panel' => 'theme_options',
	) );


	$wp_customize->add_setting( 'breadcrumb_enable' , array(
		'default'    => false,
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'agency_starter_sanitize_checkbox',
	));

	$wp_customize->add_control('breadcrumb_enable' , array(
		'label' => __('Enable | Disable Breadcrumb','biz-news' ),
		'section' => 'breadcrumb_section',
		'type'=> 'checkbox',
	));					
	
}

/**
 * @package twentysixteen
 * @subpackage biz-news
 * Converts a HEX value to RGB.
 */
function biz_news_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}


//load actions
require get_stylesheet_directory() .'/inc/core.php';
//load post widgets
require get_stylesheet_directory() .'/inc/widgets.php';



/**
 * Theme Breadcrumbs
*/
if( !function_exists('biz_news_page_header_breadcrumbs') ):
	function biz_news_page_header_breadcrumbs() { 	
		global $post;
		$homeLink = home_url();
		$biz_news_page_header_layout = get_theme_mod('biz_news_page_header_layout', 'biz_news_page_header_layout1');
		if($biz_news_page_header_layout == 'biz_news_page_header_layout1'):
			$breadcrumb_class = 'center-text';	
		else: $breadcrumb_class = 'text-right'; 
		endif;
		
		echo '<ul id="content" class="page-breadcrumb '.esc_attr( $breadcrumb_class ).'">';			
			if (is_home() || is_front_page()) :
					echo '<li><a href="'.esc_url($homeLink).'">'.esc_html__('Home','biz-news').'</a></li>';
					    echo '<li class="active">'; echo single_post_title(); echo '</li>';
						else:
						echo '<li><a href="'.esc_url($homeLink).'">'.esc_html__('Home','biz-news').'</a></li>';
						if ( is_category() ) {
							echo '<li class="active"><a href="'. esc_url( biz_news_page_url() ) .'">' . esc_html__('Archive by category','biz-news').' "' . single_cat_title('', false) . '"</a></li>';
						} elseif ( is_day() ) {
							echo '<li class="active"><a href="'. esc_url(get_year_link(esc_attr(get_the_time('Y')))) . '">'. esc_html(get_the_time('Y')) .'</a>';
							echo '<li class="active"><a href="'. esc_url(get_month_link(esc_attr(get_the_time('Y')),esc_attr(get_the_time('m')))) .'">'. esc_html(get_the_time('F')) .'</a>';
							echo '<li class="active"><a href="'. esc_url( biz_news_page_url() ) .'">'. esc_html(get_the_time('d')) .'</a></li>';
						} elseif ( is_month() ) {
							echo '<li class="active"><a href="' . esc_url( get_year_link(esc_attr(get_the_time('Y'))) ) . '">' . esc_html(get_the_time('Y')) . '</a>';
							echo '<li class="active"><a href="'. esc_url( biz_news_page_url() ) .'">'. esc_html(get_the_time('F')) .'</a></li>';
						} elseif ( is_year() ) {
							echo '<li class="active"><a href="'. esc_url( biz_news_page_url() ) .'">'. esc_html(get_the_time('Y')) .'</a></li>';
                        } elseif ( is_single() && !is_attachment() && is_page('single-product') ) {
						if ( get_post_type() != 'post' ) {
							$cat = get_the_category(); 
							$cat = $cat[0];
							echo '<li>';
								echo esc_html( get_category_parents($cat, TRUE, '') );
							echo '</li>';
							echo '<li class="active"><a href="' . esc_url( biz_news_page_url() ) . '">'. wp_title( '',false ) .'</a></li>';
						} }  
						elseif ( is_page() && $post->post_parent ) {
							$parent_id  = $post->post_parent;
							$breadcrumbs = array();
							while ($parent_id) {
							$page = get_page($parent_id);
							$breadcrumbs[] = '<li class="active"><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html( get_the_title($page->ID)) . '</a>';
							$parent_id  = $page->post_parent;
                            }
							$breadcrumbs = array_reverse($breadcrumbs);
							foreach ($breadcrumbs as $crumb) echo $crumb;
							echo '<li class="active"><a href="' .  esc_url( biz_news_page_url()) . '">'. esc_html( get_the_title() ).'</a></li>';
                        }
						elseif( is_search() )
						{
							echo '<li class="active"><a href="' . esc_url( biz_news_page_url() ) . '">'. get_search_query() .'</a></li>';
						}
						elseif( is_404() )
						{
							echo '<li class="active"><a href="' . esc_url( biz_news_page_url() ) . '">'.esc_html__('Error 404','biz-news').'</a></li>';
						}
						else { 
						    echo '<li class="active"><a href="' . esc_url( biz_news_page_url() ) . '">'. esc_html( get_the_title() ) .'</a></li>';
						}
					endif;
			echo '</ul>';
        }
endif;


/**
 * Theme Breadcrumbs Url
*/
function biz_news_page_url() {
	$page_url = 'http';
	if ( key_exists("HTTPS", $_SERVER) && (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ) ){
		$page_url .= "s";
	}
	$page_url .= "://";
	if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
		if(isset($_SERVER["SERVER_NAME"]) && isset($_SERVER["SERVER_PORT"]) && isset($_SERVER["REQUEST_URI"]) ){
			$page_url .=  wp_unslash($_SERVER["SERVER_NAME"]).":".wp_unslash($_SERVER["SERVER_PORT"]).wp_unslash($_SERVER["REQUEST_URI"]);
		}
	} else {
		if(isset($_SERVER["SERVER_NAME"]) && isset($_SERVER["REQUEST_URI"]) ){	
			$page_url .=  wp_unslash($_SERVER["SERVER_NAME"]).wp_unslash($_SERVER["REQUEST_URI"]) ;
		}
 }
 return $page_url;
}


/*
 * https://developer.wordpress.org/reference/hooks/admin_notices/
 * Displays theme info / quick help 
 */
if ( isset( $_GET['hide_admin_notice'] ) ) {
		update_option('agency_starter_hide_admin_notice', 'dispose');
} else {
	$agency_starter_info = get_option('agency_starter_hide_admin_notice', 'show');
	if ($agency_starter_info != 'dispose' || $agency_starter_info ==""){ 
		add_action( 'admin_notices', 'agency_starter_help_notice' );
	}
}



if(!function_exists('agency_starter_help_notice')):

function agency_starter_help_notice() {
    $class = 'notice notice-info is-dismissible';
    $message = __( 'Great customizations, See Appearance -> Customise -> Theme options. ', 'biz-news' );
 	$dismiss = __( 'Hide the Notice', 'biz-news');
	$tutorial = __( 'Tutorials', 'biz-news');
	$pro_notice =  __( 'Jump start with Free Demos & Learn More', 'biz-news');
    printf( '<div class="%1$s"> <p><strong><span>%2$s</span></strong> &nbsp;&nbsp; 
	<strong><a href="%3$s" target="_blank"  class="dismiss-notice">%4$s</a></strong> &nbsp;&nbsp;
	<strong><a href="%5$s" target="_blank"  class="dismiss-notice">%6$s</a></strong> &nbsp;&nbsp;
	<em><a href="?hide_admin_notice" target="_self"  class="dismiss-notice">%7$s</a></em> </p></div>', 
	esc_attr( $class ), 
	esc_html( $message ), 
	esc_url( agency_starter_theme_url ), 
	esc_html( $pro_notice ), 
	esc_url( agency_starter_tutorial ), 
	esc_html( $tutorial ),
	esc_html( $dismiss ) );
}

endif;

