<?php
/**
 * The template used for displaying page breadcrumb
 *
 * @package Tech Literacy
 */


/* search box */
$search_field_status_pages = get_theme_mod('search_field_status_pages',true);
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
if( !is_front_page() && $search_field_status_pages ) : ?>
	<div id="search-style" class="search-box-wrapper" style="background-color:<?php echo $search_box_background_color;?>;background-image:url('<?php echo $search_box_background_image;?>');background-size: <?php echo $search_section_bg_size?>; background-repeat: <?php echo $search_section_bg_repeat?>; background-position: <?php echo $search_section_bg_position?>; background-attachment: <?php echo $search_section_bg_attachment?>;">
	    <?php get_search_form(); ?>
	</div><?php 
endif; 

 $breadcrumb = get_theme_mod( 'breadcrumb',true ); 
if( !is_front_page() ): ?>
	<div class="breadcrumb">  
		<div class="container"><?php
		    if( !is_search() && !is_archive() && !is_404() ) : ?>
				<div class="breadcrumb-left eight columns">
					<?php the_title('<h4>','</h4>');?>			
				</div><?php
			endif; ?>
			<?php if( $breadcrumb ) : ?>
				<div class="breadcrumb-right eight columns">
					<?php tech_literacy_breadcrumbs(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div><?php  
endif;