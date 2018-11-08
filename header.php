<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Tech Literacy
 */




?><!DOCTYPE html> 
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?php echo get_template_directory_uri().'/images/favicon.png' ?>">
<link rel="profile" href="http://gmpg.org/xfn/11"><?php
if ( is_singular() && pings_open() ) { ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php
} ?>
<?php wp_head(); ?>  
<script src="<?php echo get_template_directory_uri().'/js/jquery.min.js' ?>"></script>
</head>
  
<body <?php body_class(); ?>>  
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tech-literacy' ); ?></a>
	<?php do_action('tech_literacy_before_header'); ?>
	<header id="masthead" class="site-header" role="banner">

		<?php if( is_active_sidebar( 'top-left' )  || is_active_sidebar( 'top-right' ) ): ?>
			<!--
			<div class="top-nav">
				<div class="container">		
					<div class="eight columns">
						<div class="cart-left">
							<?php dynamic_sidebar('top-left' ); ?>
						</div>
					</div>

					<div class="eight columns">
						<div class="cart-right">
							<?php dynamic_sidebar('top-right' ); ?>  
						</div>
					</div>
				</div>
			</div>--> <!-- .top-nav -->
		<?php endif;?>
		<div class="branding header-image">
	       <div class="container">
				<div class="eight columns">
					<div class="site-branding">
						<?php     
							$logo_title = get_theme_mod( 'logo_title' );   
							$tagline = get_theme_mod( 'tagline',false);
							if( $logo_title && function_exists( 'the_custom_logo' ) ) :
                                the_custom_logo();     
                            else : ?>
								<h2 class="site-title"><a style="color: #<?php header_textcolor(); ?>" href="http://www.univalle.edu.co" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
						<?php endif; ?>
						<?php if( $tagline ) : ?>
								<p class="site-description"><?php bloginfo( 'description' ); ?></p>
						<?php endif; ?>
					</div><!-- .site-branding -->					
				</div>
				<div class="eight columns"><?php
				   if( is_active_sidebar( 'header-top-right' ) ) : ?> 
						<div class="header-top-right">
						    <?php dynamic_sidebar('header-top-right' ); ?>  
					    </div>
					<?php endif; ?>
				</div>
		   </div>
	    </div>
	    
		<div class="nav-wrap">
			<div class=menu-dintev>
				<?php
				$home = home_url();
				global $wp;
				$current_link = home_url($wp->request);

				if($home != $current_link){
					?><a href="<?php the_permalink(); ?>" class="text-menu-dintev first">Página Principal</a><?php
				}
				?>
				<a href="http://dintev.univalle.edu.co/" target="blank" class="text-menu-dintev">DINTEV</a>
			</div>
		</div>
	</header><!-- #masthead --> 

	<?php if ( function_exists( 'is_woocommerce' ) || function_exists( 'is_cart' ) || function_exists( 'is_chechout' ) ) :
	 if ( is_woocommerce() || is_cart() || is_checkout() ) { ?>
	   <?php $breadcrumb = get_theme_mod( 'breadcrumb',true ); ?>    
		   <div class="breadcrumb">
				<div class="container"><?php
				   if( !is_search() && !is_archive() && !is_404() ) : ?>
						<div class="breadcrumb-left eight columns">
							<h4><?php woocommerce_page_title(); ?></h4>   			
						</div><?php
					endif; ?>
					<?php if( $breadcrumb ) : ?>  
						<div class="breadcrumb-right eight columns">
							<?php woocommerce_breadcrumb(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
	<?php } 
	endif; ?>

	


