<?php
/**
 * tech-literacy functions and definitions
 *
 * @package Tech Literacy
 */


if ( ! function_exists( 'tech_literacy_setup' ) ) :  
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tech_literacy_setup() { 

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on tech-literacy, use a find and replace
	 * to change 'tech-literacy' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'tech-literacy', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tech-literacy' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		 'comment-list', 'gallery', 'caption',
	) );


	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
    /**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 */
    $GLOBALS['content_width'] = apply_filters( 'tech_literacy_content_width', 640 );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'tech_literacy_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );


    /* 
    * Custom Logo 
    */
    add_theme_support( 'custom-logo' );

    
	/* Woocommerce support */

	add_theme_support('woocommerce');
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Add Additional image sizes
	 *
	 */  
	add_image_size( 'tech-literacy-small-featured-image-width', 450,300, true );
	add_image_size( 'tech-literacy-blog-large-width', 800,300, true );

	add_image_size( 'tech-literacy-service-img', 100,100, true );
	add_image_size( 'tech-literacy-recent-posts-img', 380,270, true );
	
    // Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
     
	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
		
			'top-left' => array(
				// Widget ID
			    'my_text' => array(
					// Widget $id -> set when creating a Widget Class
		        	'text' , 
		        	// Widget $instance -> settings 
					array(
					  'text'  => __( '<ul><li><i class="fa fa-envelope-o"></i><a href="mailto:information@mail.com">information@mail.com</a></li> <li><i class="fa fa-phone"></i> Call Us:(1)118 234 678</li></ul>','tech-literacy')
					)
				)
			),

			// Put two core-defined widgets in the footer 2 area.
			'top-right' => array(
				// Widget ID
			    'my_text' => array(
					// Widget $id -> set when creating a Widget Class
		        	'text' , 
		        	// Widget $instance -> settings 
					array(
					  'text'  => __('<ul><li><a href="#"><i class="fa fa-facebook"></i></a></li><li><a href="#"><i class="fa fa-twitter"></i></a></li><li><a href="#"><i class="fa fa-pinterest"></i></a></li><li><a href="#"><i class="fa fa-tumblr"></i></a></li></ul>','tech-literacy')
					)
				),
			),
            'header-top-right' => array(
				// Widget ID
			    'my_text' => array(
					// Widget $id -> set when creating a Widget Class
		        	'text' , 
		        	// Widget $instance -> settings 
					array(
					  'text'  => __( '<i class="fa fa-phone twelve columns"></i><p class="four columns align-left">call us now<br><span class="clr-primary">715.248.1574</span></p>','tech-literacy')
					)
				)
			),
			'footer' => array(
				// Widget ID
			    'my_text' => array(
					// Widget $id -> set when creating a Widget Class
		        	'text' , 
		        	// Widget $instance -> settings 
					array(
					  'title' => __( 'About Theme', 'tech-literacy'),
					  'text'  => __( 'Tech Literacy is a free, clean, minimalistic, responsive, mobile-friendly WordPress theme. Tech Literacy suitable for education, literacy websites, online stores, personal portfolio, agencies, start-ups and many others.', 'tech-literacy'),
					)
				)
			),
			'footer-2' => array(
				// Widget ID
			    'archives'
			),
			'footer-3' => array(
				// Widget ID
			    'categories'
			),
			'footer-nav' => array(
               // Widget ID
			    'my_text' => array(
					// Widget $id -> set when creating a Widget Class
		        	'text' , 
		        	// Widget $instance -> settings 
					array(
					  'text'  => '<ul><li><a href="#"><i class="fa fa-facebook"></i></a></li><li><a href="#"><i class="fa fa-twitter"></i></a></li><li><a href="#"><i class="fa fa-pinterest"></i></a></li><li><a href="#"><i class="fa fa-tumblr"></i></a></li></ul>'
					)
				),
			),


		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home' => array(
				'post_type' => 'page',
			),
			'blog' => array(
				'post_type' => 'page',
			),
			'post-one' => array(
	            'post_type' => 'post',
	            'post_title' => __( 'Lorem Ipsum', 'tech-literacy'),
	            'post_content' => __( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean lacinia bibendum nulla sed consectetur', 'tech-literacy'),
	            'thumbnail' => '{{post-featured-image1}}',
	        ),
	        'post-two' => array(
	            'post_type' => 'post',
	            'post_title' => __( 'Lorem Ipsum', 'tech-literacy'),
	            'post_content' => __( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean lacinia bibendum nulla sed consectetur', 'tech-literacy'),
	            'thumbnail' => '{{post-featured-image2}}',
	        ), 
	        'post-three' => array(
	            'post_type' => 'post',
	            'post_title' => __( 'Lorem Ipsum', 'tech-literacy'),
	            'post_content' => __( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean lacinia bibendum nulla sed consectetur', 'tech-literacy'),
	            'thumbnail' => '{{post-featured-image3}}',
	        ),
			'service-one' => array(  
				'post_type' => 'page',
				'post_title' => __( 'Service 1', 'tech-literacy'),
	            'post_content' => __('You haven\'t created any service page yet. Create Page. Go to Customizer and click Theme Options => Home => Service Section #1 and select page from  dropdown page list.<!--more-->','tech-literacy'),
				'thumbnail' => '{{page-images}}',
			),
			'service-two' => array(
				'post_type' => 'page',
				'post_title' => __( 'Service 2', 'tech-literacy'),
	            'post_content' => __('You haven\'t created any service page yet. Create Page. Go to Customizer and click Theme Options => Home => Service Section #1 and select page from  dropdown page list.<!--more-->','tech-literacy'),
				'thumbnail' => '{{page-images}}',
			),
			'service-three' => array(
				'post_type' => 'page',
				'post_title' => __( 'Service 3', 'tech-literacy'),
	            'post_content' => __('You haven\'t created any service page yet. Create Page. Go to Customizer and click Theme Options => Home => Service Section #1 and select page from  dropdown page list.<!--more-->','tech-literacy'),
				'thumbnail' => '{{page-images}}',
			),
			
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'post-featured-image1' => array( 
				'post_title' => __( 'blog one', 'tech-literacy' ),
				'file' => 'images/blog1.png', // URL relative to the template directory.
			),
			'post-featured-image2' => array( 
				'post_title' => __( 'blog one', 'tech-literacy' ),
				'file' => 'images/blog2.png', // URL relative to the template directory.
			),
			'post-featured-image3' => array( 
				'post_title' => __( 'blog one', 'tech-literacy' ),
				'file' => 'images/blog3.png', // URL relative to the template directory.
			),
			'page-images' => array(
				'post_title' => __( 'Page Images', 'tech-literacy' ),
				'file' => 'images/page.png', // URL relative to the template directory.
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),  

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'service_1' => '{{service-one}}', 
			'service_2' => '{{service-two}}',
			'service_3' => '{{service-three}}',
			'service_section_icon_1' => 'fa-user',
			'service_section_icon_2' => 'fa-heart',
			'service_section_icon_3' => 'fa-apple',
		),

	);

	$starter_content = apply_filters( 'tech_literacy_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );     
        
}
endif; // tech_literacy_setup
add_action( 'after_setup_theme', 'tech_literacy_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tech_literacy_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'tech-literacy' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) ); 

	register_sidebar( array(
		'name'          => __( 'Top Left', 'tech-literacy' ),
		'id'            => 'top-left',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Top Right', 'tech-literacy' ),
		'id'            => 'top-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Header Top Right', 'tech-literacy' ),
		'id'            => 'header-top-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebars( 3, array(
		'name'          => __( 'Footer %d', 'tech-literacy' ),
		'id'            => 'footer',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Nav', 'tech-literacy' ),
		'id'            => 'footer-nav',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'tech_literacy_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/includes/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/extras.php';
/**
 * Implement the Custom Header feature.
 */
require  get_template_directory()  . '/includes/custom-header.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/jetpack.php';

/**
 * Load Theme Options Panel
 */
require get_template_directory() . '/includes/theme-options.php';

/* Woocommerce support */

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper');
add_action('woocommerce_before_main_content', 'tech_literacy_output_content_wrapper');

function tech_literacy_output_content_wrapper() {
	echo '<div class="container"><div class="row"><div id="primary" class="content-area eleven columns">';
}

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );
add_action( 'woocommerce_after_main_content', 'tech_literacy_output_content_wrapper_end' );

function tech_literacy_output_content_wrapper_end () {
	echo "</div>";
}

add_action( 'wp_head', 'tech_literacy_remove_wc_breadcrumbs' );
function tech_literacy_remove_wc_breadcrumbs() {
   	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}  
