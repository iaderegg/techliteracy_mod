<?php
/**
 * The front page template file.
 *
 *
 * @package Tech Literacy
 */

$search_section_bg_size = get_theme_mod('search_section_bg_size','cover');
$search_section_bg_repeat = get_theme_mod('search_section_bg_repeat','repeat');
$search_section_bg_position = get_theme_mod('search_section_bg_position','center center');
$search_section_bg_attachment = get_theme_mod('search_section_bg_attachment','fixed'); 
$search_box_background_color = get_theme_mod('search_box_background_color','#27323d');
if(get_theme_mod('search_field_background_image',true)) {
	$search_box_background_image = get_theme_mod('search_box_background_image');
}
else { 
	$search_box_background_image ='';
}
if ( 'posts' == get_option( 'show_on_front' ) ) { 
	get_template_part('index');
} else {

	 
    get_header(); 

    if( get_theme_mod('search_field_status',true) ) {
    	$search_title = esc_html(get_theme_mod('search_heading','How We Can Help You Today?')); 
    	echo '<div id="search-style" class="home-search-box-wrapper" style="background-color:'.$search_box_background_color.';background-image:url('. $search_box_background_image. ');background-size:'. $search_section_bg_size .'; background-repeat: '. $search_section_bg_repeat.'; background-position: '.$search_section_bg_position .'; background-attachment: '. $search_section_bg_attachment . ';"> 
    	    <h1 class="search-title">'. $search_title .'</h1>'; 
    	    get_search_form();
    	echo '</div>';
    }

    if( get_theme_mod('service_field',true) ) {
       do_action('service_content_before');
      
		$service_page1 = intval(get_theme_mod('service_1'));
		$service_page2 = intval(get_theme_mod('service_2')); 
		$service_page3 = intval(get_theme_mod('service_3'));
		$service_section_icon_1 = esc_attr(get_theme_mod('service_section_icon_1'));
		$service_section_icon_2 = esc_attr(get_theme_mod('service_section_icon_2'));
		$service_section_icon_3 = esc_attr(get_theme_mod('service_section_icon_3'));

		
		/*COMENTADO PARA FUNCIONAMIENTO DE PLUGIN*/
		if( $service_page1 || $service_page2 || $service_page3 ) { /*?>
			<div class="services-wrapper row">
			    <div class="container"><?php  
					$service_pages = array($service_page1,$service_page2,$service_page3);
					$args = array(
						'post_type' => 'page',
						'post__in' => $service_pages,
						'posts_per_page' => 3,
						'orderby' => 'post__in'
					);
					$query = new WP_Query($args);
					if( $query->have_posts()) : 
					 do_action('tech_literacy_service_title');
							 $i = 1; ?>
							<?php while($query->have_posts()) :
								$query->the_post(); 

								      if($i == 1):
						    	      $icon_url =  $service_section_icon_1;
						    	      elseif($i == 2):
						    	       $icon_url =  $service_section_icon_2;
						    	      elseif($i == 3):
						    	       	$icon_url =  $service_section_icon_3;
						    	      endif; ?>
		                            <div class="one-third column service-count">
									    <div class="service-section">
									    	<?php if($icon_url): ?>
							    	           <div class="service-image"><i class="fa <?php echo $icon_url; ?>"></i></div><?php 
							    	        elseif( has_post_thumbnail() ) : ?>
									    		 <div class="service-image"><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_post_thumbnail('tech-literacy-service-img'); ?></a></div>
									    	<?php endif; ?>
									    	<div class="service-content">
									    	    <?php the_title( sprintf( '<h4 class="title-divider"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
										    	<?php the_content(); 
													wp_link_pages( array(
														'before' => '<div class="page-links">' . esc_html__( 'Pages: ', 'tech-literacy' ),
														'after'  => '</div>',
													) );
												?>
									    	</div>
									    </div>
								    </div>
							<?php $i++;
							endwhile; ?>
						<?php 
					endif; 
					$query = null;
					$args = null;
					wp_reset_postdata(); ?>

				</div>
			</div><?php
		*/} 	

		
		do_action('service_content_after'); 

	}	
        if( get_theme_mod('enable_recent_post_service',true) ) :
		   	do_action('tech_literacy_recent_post_before');
			tech_literacy_recent_posts(); 
		    do_action('tech_literacy_recent_post_after');
	    endif;

	    if( get_theme_mod('enable_home_default_content',false ) ) {   ?>
			<div id="content" class="site-content">
				<div class="container">
					<main id="main" class="site-main" role="main"><?php
						while ( have_posts() ) : the_post();       
							the_content();
								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages: ', 'tech-literacy' ),
									'after'  => '</div>',
								) );
						endwhile; ?>
				    </main><!-- #main -->
			    </div><!-- #primary -->
			</div>
    <?php }
    get_footer();

}
