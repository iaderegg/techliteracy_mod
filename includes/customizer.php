<?php
/**
 * tech-literacy Theme Customizer
 *
 * @package Tech Literacy     
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function tech_literacy_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'tech_literacy_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function tech_literacy_customize_preview_js() {
	wp_enqueue_script( 'tech_literacy_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'tech_literacy_customize_preview_js' );


add_action( 'wp_head','tech_literacy_customizer_service_color' );

function tech_literacy_customizer_service_color() {
	for ($i=1; $i < 4; $i++) { 
		switch ($i) {
			case '1':
				$bg_color = '#5daae0';
				break;
			case '3':
				$bg_color = '#00ba71';
				break;
			default:
				$bg_color = '#ea4640';
				break;
		}
		if( get_theme_mod('service_color_'.$i,$bg_color) ) {
				
			$service_color = esc_html(get_theme_mod( 'service_color_'.$i,$bg_color));  ?>
			
			<style type="text/css">
				.services-wrapper .service-count:nth-of-type(<?php echo $i; ?>) .title-divider a:hover	
			    {
					color: <?php echo $service_color; ?>;
				}

				.services-wrapper .service-count:nth-of-type(<?php echo $i; ?>) .service-image .fa,.services-wrapper .service-count:nth-of-type(<?php echo $i; ?>) .more-link
				{
					background-color: <?php echo $service_color; ?>;
				}

			</style><?php
		}

	}
}