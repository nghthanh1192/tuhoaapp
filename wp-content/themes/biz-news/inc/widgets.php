<?php
class biz_news_Search_Widget extends WP_Widget {

	/**
	 * Setup the widget options
	 * @since 1.0
	 */
	public function __construct() {
	
		// set widget options
		$options = array(
			'classname'   => 'biz_news_Search_Widget', // CSS class name
			'description' => esc_html__( 'WooCommerce Search [With Categories]', 'biz-news' ),
		);
		
		// instantiate the widget
		parent::__construct( 'biz_news_Search_Widget', esc_html__( 'Pro- WooCommerce Search Widget', 'biz-news' ), $options );
	}
	
	

	public function widget( $args, $instance ) {
		
		// get the widget configuration
		$title = "";
		if(isset($instance['title'])) $title = $instance['title'];
				
		if ( $title ) {
			echo wp_kses_post($args['before_title']) . wp_kses_post($title) . wp_kses_post($args['after_title']);
		}

		?>
		<div class="row">
		<div class="col-sm-12">
			<div class="woo-search">
			  <?php if ( class_exists( 'WooCommerce' ) ) { ?>
			  <div class="header-search-form">
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				  <select class="header-search-select" name="product_cat">
					<option value="">
					<?php esc_html_e( 'Categories', 'biz-news' ); ?>
					</option>
					<?php
									/*
									 * @package envo-ecommerce
									 * @subpackage biz-news
									 */
									$args = array(
										'taxonomy'     => 'product_cat',
										'orderby'      => 'date',
										'order'      	=> 'ASC',
										'show_count'   => 1,
										'pad_counts'   => 0,
										'hierarchical' => 1,
										'title_li'     => '',
										'hide_empty'   => 1,
									);
									$categories = get_categories( $args);
									foreach ( $categories as $category ) {
										$option = '<option value="' . esc_attr( $category->category_nicename ) . '">';
										$option .= esc_html( $category->cat_name );
										$option .= ' (' . absint( $category->category_count ) . ')';
										$option .= '</option>';
										echo wp_kses_post($option); 
									}
									?>
				  </select>
				  <input type="hidden" name="post_type" value="product" />
				  <input class="header-search-input" name="s" type="text" placeholder="<?php esc_attr_e( 'Search products...', 'biz-news' ); ?>"/>
				  <button class="header-search-button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</form>
			  </div>
			  <?php } ?>
			</div>
			</div>
		</div>
		<?php
		
	}
	


	public function update( $new_instance, $old_instance ) {
	
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}
	

	public function form( $instance ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'biz-news' ) ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( isset( $instance['title'] ) ? $instance['title'] : '' ); ?>" />
		</p>
		
		<?php
	}
	
} 


/**
 * Registers the new widget to add it to the available widgets
 * @since 1.0.0
 */
function biz_news_Search_register_widget() {
	register_widget( 'biz_news_Search_Widget' );
}
add_action( 'widgets_init', 'biz_news_Search_register_widget' );


/*
 * Post Widget
 */
class biz_news_Post_Widget extends WP_Widget {

	/**
	 * Setup the widget options
	 * @since 1.0
	 */
	public function __construct() {
	
		// set widget options
		$options = array(
			'classname'   => 'biz_news_Post_Widget', // CSS class name
			'description' => esc_html__( 'Pro- Post Widget.', 'biz-news' ),
		);
		
		// instantiate the widget
		parent::__construct( 'biz_news_Post_Widget', esc_html__( 'Pro- Post Widget', 'biz-news' ), $options );
	}
	
	

	public function widget( $args, $instance ) {
	
		$category = ( ! empty( $instance['category'] ) ) ? strip_tags( $instance['category'] ) : 0;
		$colums = (!empty($instance['colums'])) ? strip_tags($instance['colums']) : "col-md-3 col-sm-3 col-lg-3 col-xs-12";
		
		// get the widget configuration
		$title = "";
		if(isset($instance['title'])) $title = $instance['title'];
		
				
		if ( $title ) {
			echo  "<h2 class='page-title center-text'>".wp_kses_post($title)."</h2>";
		}

		?>
	  <section id="" class="post-widget-content text-center">
		  <div class="row">
			<?php
			$max_items = 20;
			$args =  array(  'post_type' => 'post', 'ignore_sticky_posts' => 1 , 'cat' =>  $category , 'posts_per_page' =>  absint($max_items), 'numberposts' => absint($max_items) , 'orderby' => 'date', 'order' => 'DESC' );

			$page_query = new WP_Query($args);?>
			  <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
				<div class="<?php echo esc_attr($colums) ;?>">
				  <div class="center-text post">
					<?php the_post_thumbnail(); ?>				  
					<h2 class="widget-title"><a href="<?php the_permalink();?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
					<p class="mt-3"><?php $excerpt = wp_trim_words( get_the_excerpt(), 20 ) ; echo wp_kses_post($excerpt); ?></p>
				  	<span><a class="call-to-action" href="<?php the_permalink();?>"><?php esc_html_e('Read More', 'biz-news'); ?></a></span>
				  </div>
				</div>
			  <?php endwhile;
			  wp_reset_postdata();
			  ?>
		  </div>
	  </section>
		<?php
		
	}
	

	public function update( $new_instance, $old_instance ) {
	
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title']) : "" ;
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category']) : 0 ;
		$instance['colums'] = ( ! empty( $new_instance['colums'] ) ) ? strip_tags( $new_instance['colums'] ): "" ;
		
		return $instance;
	}
	

	public function form( $instance ) {
	
		$category = ( ! empty( $instance['category'] ) ) ? strip_tags( $instance['category'] ) : 0;
		$title = ( ! empty( $instance['title'] ) ) ? strip_tags( $instance['title'] ) : '';
		$colums = (!empty($instance['colums'])) ? strip_tags($instance['colums']) : "col-md-3 col-sm-3 col-lg-3 col-xs-12";
		

		$args = array( 'orderby' => 'name', 'exclude' => '', 'include' => '', 'parent' => 0 );
		$categories = get_categories( $args );
		$category_code = '';
			if(0==$category){
				$category_code = $category_code.'<option value="0" Selected=selected>'.__( '-Select Category-','biz-news').'</option>';
			} else{
				$category_code = $category_code.'<option value="0">'.__( '-Select Category-','biz-news').'</option>';
			}
			foreach ( $categories as $cat ) {
				$selected ='';
				if(($cat->term_id)==$category){
					$selected ='Selected=selected';
				}
			$category_code = $category_code.'<option value="'.$cat->term_id.'" '.$selected.' >'.$cat->name.'</option>';
		}
		
		//
		$bootstrap_colums = array(
			"col-md-12 col-sm-12 col-lg-12 col-xs-12" => 1,
			"col-md-6 col-sm-6 col-lg-6 col-xs-12" => 2,
			"col-md-4 col-sm-4 col-lg-4 col-xs-12" => 3,
			"col-md-3 col-sm-3 col-lg-3 col-xs-12" => 4,
			"col-md-2 col-sm-2 col-lg-2 col-xs-12" => 6,
		);	
		

		?>
				
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'biz-news' ) ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( isset( $instance['title'] ) ? $instance['title'] : '' ); ?>" />
		</p>
		
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Select the News category:','biz-news'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category' )); ?>" type="text">
		<?php echo wp_kses_post($category_code); ?>
		</select>
		</p>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('colums')); ?>"><?php esc_html_e('Number of colums:', 'biz-news'); ?></label> 
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('colums')); ?>" name="<?php echo esc_attr( $this->get_field_name('colums')); ?>" type="text">
		<?php
		foreach ($bootstrap_colums as $key => $value) {
				if ($key == $colums) {
						echo '<option value="' . esc_attr($key) . '" Selected = selected >' . esc_html( $value) . '</option>';
				}
				else {
						echo '<option value="' . esc_attr($key) . '" >' . esc_html($value) . '</option>';
				}
		}
		?>
		</select>
		</p>

		
		<?php
	}
	
} 


/**
 * Registers the new widget to add it to the available widgets
 * @since 1.0.0
 */
function biz_news_Post_register_widget() {
	register_widget( 'biz_news_Post_Widget' );
}
add_action( 'widgets_init', 'biz_news_Post_register_widget' );