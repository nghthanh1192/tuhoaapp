<?php 
$biz_news_banner = get_theme_mod('banner_image', '');
if($biz_news_banner !='') { 

?>
<section id="top-banner">
	<div class="center-text">
		<?php 
			echo '<a href="'.esc_url(get_theme_mod('banner_link', '#')).'" ><img src="'.esc_url($biz_news_banner).'" /></a>';	
		?>
	</div>
</section>

<?php
} 

