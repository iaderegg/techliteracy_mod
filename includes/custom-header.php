<?php 
/**
 * Setup the WordPress core custom header feature.
 *
 * @uses tech_literacy_header_style()  
 * @uses tech_literacy_admin_header_style() 
 * @uses tech_literacy_admin_header_image()   
 *
 * @package Tech Literacy
 */
function tech_literacy_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'tech_literacy_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '27323d', 
		'header_text'            => true,
		'width'                  => 1920,
		'height'                 => 400,
		'video'                  => true,
		'flex-height'            => true, 
		'wp-head-callback'       => 'tech_literacy_header_style'
	) ) );
}

add_action( 'after_setup_theme', 'tech_literacy_custom_header_setup' );



if ( ! function_exists( 'tech_literacy_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see tech_literacy_custom_header_setup().  
 */
function tech_literacy_header_style() {
	if ( get_header_image() ) {
	?>
	<style type="text/css">    
		.header-image {
			background-image: url(<?php echo esc_url(get_header_image()); ?>);
			display: block;
		} 
		.custom-header-media img {
				display: none;
		}      
	</style>
	<?php
	}
	 /* Header Video Settings */
    if(function_exists('is_header_video_active') ) {
		if ( is_header_video_active() ) { ?>
			<style type="text/css">    
				#wp-custom-header-video-button {
				    position: absolute;
				    z-index:1;
				    top:20px;
				    right: 20px;
				    background:rgba(34, 34, 34, 0.5);
				    border: 1px solid rgba(255,255,255,0.5);
				}
				.wp-custom-header iframe,
				.wp-custom-header video {
				      display: block;
				      height: auto;
					  max-width: 100%;
					  object-fit: cover;
				      width: 100vw;
				      overflow: hidden;
				}

		    </style><?php
		}
    }

}
endif; // tech_literacy_header_style


/**
 * Customize video play/pause button in the custom header.
 */
if(!function_exists('tech_literacy_video_controls') ) {
	function tech_literacy_video_controls( $settings ) {
		$settings['l10n']['play'] = '<span class="screen-reader-text">' . __( 'Play background video', 'tech-literacy' ) . '</span><i class="fa fa-play"></i>';
		$settings['l10n']['pause'] = '<span class="screen-reader-text">' . __( 'Pause background video', 'tech-literacy' ) . '</span><i class="fa fa-pause"></i>';
		return $settings;
	}
}
add_filter( 'header_video_settings', 'tech_literacy_video_controls' );