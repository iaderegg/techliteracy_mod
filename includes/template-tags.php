<?php
/**
 * Custom template tags for this theme.
 *   
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Tech Literacy  
 */ 
  
  
if ( ! function_exists( 'tech_literacy_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function tech_literacy_post_nav() { 
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation clearfix" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'tech-literacy' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'tech-literacy' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'tech-literacy' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'tech_literacy_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function tech_literacy_entry_footer() {
	// Hide category and tag text for pages.
	
	if ( 'post' == get_post_type() ) {    
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ' ', 'tech-literacy' ) ); 
		if ( $categories_list ) {
			printf( '<span class="cat-links"><i class="fa fa-folder-open"></i> ' . __( '%1$s ', 'tech-literacy' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ' ', 'tech-literacy' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-tags"></i> ' . __( '%1$s ', 'tech-literacy' ) . '</span>', $tags_list );
		}
	}
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
if ( ! function_exists( 'tech_literacy_categorized_blog' ) ) :
	function tech_literacy_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'tech_literacy_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'tech_literacy_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so tech_literacy_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so tech_literacy_categorized_blog should return false.
			return false;
		}
	}
endif;

/**
 * Flush out the transients used in tech_literacy_categorized_blog.
 */
if ( ! function_exists( 'tech_literacy_category_transient_flusher' ) ) :
	function tech_literacy_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'tech_literacy_categories' );
	}
endif;
add_action( 'edit_category', 'tech_literacy_category_transient_flusher' );
add_action( 'save_post',     'tech_literacy_category_transient_flusher' );

if( ! function_exists('tech_literacy_top_meta') ) {
	function tech_literacy_top_meta() {
		global $post;
		if ( 'post' == get_post_type() ) {  ?>
			<div class="entry-meta">
				<span class="date-structure">				
					<span class="dd"><i class="fa fa-calendar"></i><?php the_time(get_option('date_format')); ?></span>			
				</span>
				<?php tech_literacy_author(); ?>
				<?php tech_literacy_comments_meta(); ?> 
				<?php tech_literacy_edit();
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'tech-literacy' ) ); 
				if ( $categories_list ) {
					printf( '<span class="cat-links"><i class="fa fa-folder-open"></i> ' . __( '%1$s ', 'tech-literacy' ) . '</span>', $categories_list );
				} ?>

			</div><!-- .entry-meta --><?php
		}
	}
}


// Recent Posts with featured Images to be displayed on home page
if( ! function_exists('tech_literacy_recent_posts') ) {
	function tech_literacy_recent_posts() {      
		$output = '';
		$posts_per_page  = get_theme_mod('recent_posts_count', 3 );
		$post_ID  = explode (',',get_theme_mod('recent_posts_exclude'));
		// WP_Query arguments
		$args = array (
			'post_type'              => 'post',
			'post_status'            => 'publish',   
			'posts_per_page'         => intval($posts_per_page), 
			'ignore_sticky_posts'    => true,
			'order'                  => 'DESC',
			'post__not_in'           => $post_ID,
		);

		// The Query
		$query = new WP_Query( $args );

		// The Loop
		if ( $query->have_posts() ) {
			$output .= '<div class="post-wrapper">'; 
			$output .=  '<div class="container"><main id="main" class="site-main" role="main">'; 
			$output .=  do_action('tech_literacy_post_title');
			$output .= '<div class="latest-posts clearfix">';
			while ( $query->have_posts() ) {
				$query->the_post();
				$output .= '<div class="one-third column latest-post-wrapper">';
				$output .= '<div class="latest-post clearfix">';
						$output .= '<div class="latest-post-thumb"><a href="'. esc_url(get_permalink()) . '">'; 
								if ( has_post_thumbnail() ) {
									$output .= get_the_post_thumbnail($query->post->ID ,'tech-literacy-recent-posts-img');
								}
								else {
									$output .= '<img src="' . esc_url(get_stylesheet_directory_uri()) . '/images/no-image.png" alt="" >';
								}
						$output .= '</a></div><!-- .latest-post-thumb -->';
						$output .= '<div class="latest-post-content-wrapper">';
						  $output .= '<h6><a href="'. esc_url(get_permalink()) . '">' . get_the_title() . '</a></h6>';
						$output .= '</div><!-- .latest-post-content-wrapper -->';
			    $output .= '</div>';	
				$output .= '</div><!-- .latest-post -->';
			}
			$output .= '</div><!-- latest post end -->';
			$output .= '</main></div>';
			$output .= '</div><!-- .post-wrapper -->';
		} 
		$query = null;
		// Restore original Post Data
		wp_reset_postdata();
		echo $output;
	}
}

/**
  * Generates Breadcrumb Navigation 
  */
 
 if( ! function_exists( 'tech_literacy_breadcrumbs' )) {
 
	function tech_literacy_breadcrumbs() {
		/* === OPTIONS === */
		$text['home']     = __( '<i class="fa fa-home"></i>','tech-literacy' ); // text for the 'Home' link
		$text['category'] = __( 'Archive by Category "%s"','tech-literacy' ); // text for a category page
		$text['search']   = __( 'Search Results for "%s" Query','tech-literacy' ); // text for a search results page
		$text['tag']      = __( 'Posts Tagged "%s"','tech-literacy' ); // text for a tag page
		$text['author']   = __( 'Articles Posted by %s','tech-literacy' ); // text for an author page
		$text['404']      = __( 'Error 404','tech-literacy' ); // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$breadcrumb_char = get_theme_mod( 'breadcrumb_char', '1' );
		if ( $breadcrumb_char ) {
		 switch ( $breadcrumb_char ) {
		 	case '2' :
		 		$delimiter = ' &#47; ';
		 		break;
		 	case '3':
		 		$delimiter = ' &gt; ';
		 		break;
		 	case '1':
		 	default:
		 		$delimiter = ' &raquo; ';
		 		break;
		 }
		}

		$before      = '<span class="current">'; // tag before the current crumb
		$after       = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;
		$homeLink = esc_url(home_url()) . '/';
		$linkBefore = '<span typeof="v:Breadcrumb">';
		$linkAfter = '</span>';
		$linkAttr = ' rel="v:url" property="v:title"';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

		if (is_home() || is_front_page()) {

			if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . esc_url($homeLink) . '">' . $text['home'] . '</a></div>';

		} else {

			echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, esc_url($homeLink), $text['home']) . $delimiter;

			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

			} elseif ( is_search() ) {
				echo $before . sprintf($text['search'], get_search_query()) . $after;

			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time(__( 'Y', 'tech-literacy') )), get_the_time(__( 'Y', 'tech-literacy'))) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time(__( 'Y', 'tech-literacy')),get_the_time(__( 'm', 'tech-literacy'))), get_the_time(__( 'F', 'tech-literacy'))) . $delimiter;
				echo $before . get_the_time(__( 'd', 'tech-literacy')) . $after;

			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time(__( 'Y', 'tech-literacy'))), get_the_time(__( 'Y', 'tech-literacy'))) . $delimiter;
				echo $before . get_the_time(__( 'F', 'tech-literacy')) . $after;

			} elseif ( is_year() ) {
				echo $before . get_the_time(__( 'Y', 'tech-literacy')) . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {  
					$post_type = get_post_type_object(get_post_type()); 
					printf($link, get_post_type_archive_link(get_post_type()), $post_type->labels->singular_name);
					if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
				} else {   
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				echo $before . $post_type->labels->singular_name . $after;

			} elseif ( is_attachment() ) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				printf($link, get_permalink($parent), $parent->post_title);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo $before . get_the_title() . $after;

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_tag() ) {
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

			} elseif ( is_author() ) {
		 		global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;

			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}

			if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				 _e('Page', 'tech-literacy' ) . ' ' . get_query_var('paged');
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

			echo '</div>';

		}
	
	} // end tech_literacy_breadcrumbs()

}

if ( ! function_exists( 'tech_literacy_author' ) ) :
	function tech_literacy_author() {
		echo tech_literacy_get_author();
	}
endif;
 
if ( ! function_exists( 'tech_literacy_get_author' ) ) :
	function tech_literacy_get_author() {  
		$byline = sprintf(
			esc_html_x( ' %s', 'post author', 'tech-literacy' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user"></i> ' . esc_html( get_the_author() ) . '</a></span>'
		);		

		return $byline;  
	}
endif;  

if ( ! function_exists( 'tech_literacy_comments_meta' ) ) :
	function tech_literacy_comments_meta() {
		echo tech_literacy_get_comments_meta();	
	}  
endif;  

if ( ! function_exists( 'tech_literacy_get_comments_meta' ) ) :
	function tech_literacy_get_comments_meta() {			
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
 
		if ( comments_open() ) {
		  if ( $num_comments == 0 ) {
		    $comments = __('No Comments','tech-literacy');
		  } elseif ( $num_comments > 1 ) {
		    $comments = $num_comments . __(' Comments','tech-literacy');
		  } else {
		    $comments = __('1 Comment','tech-literacy');  
		  }
		  $write_comments = '<span class="comments-link"><i class="fa fa-comments"></i><a href="' . esc_url(get_comments_link()) .'">'. esc_html($comments).'</a></span>';
		} else{
			$write_comments = '<span class="comments-link"><i class="fa fa-comments"></i><a href="' . esc_url(get_comments_link()) .'">'. esc_html(__('Leave a comment', 'tech-literacy') ).'</a></span>';
		}
		return $write_comments;	
	}

endif;

if ( ! function_exists( 'tech_literacy_edit' ) ) :
	function tech_literacy_edit() {
		edit_post_link( __( 'Edit', 'tech-literacy' ), '<span class="edit-link"><i class="fa fa-pencil"></i> ', '</span>' );
	}
endif;


// Related Posts Function by Tags (call using tech_literacy_related_posts(); ) /NecessarY/ May be write a shortcode?
if ( ! function_exists( 'tech_literacy_related_posts' ) ) :
	function tech_literacy_related_posts() {
		echo '<ul id="tech-literacy-related-posts">';
		global $post;
		$post_hierarchy = get_theme_mod('related_posts_hierarchy','1');
		$relatedposts_per_page  =  get_option('post_per_page') ;
		if($post_hierarchy == '1') {
			$related_post_type = wp_get_post_tags($post->ID);
			$tag_arr = '';
			if($related_post_type) {
				foreach($related_post_type as $tag) { $tag_arr .= $tag->slug . ','; }
		        $args = array(
		        	'tag' => esc_html($tag_arr),
		        	'numberposts' => intval( $relatedposts_per_page ), /* you can change this to show more */
		        	'post__not_in' => array($post->ID)
		     	);
		   }
		}else {
			$related_post_type = get_the_category($post->ID); 
			if ($related_post_type) {
				$category_ids = array();
				foreach($related_post_type as $category) {
				     $category_ids = $category->term_id; 
				}  
				$args = array(
					'category__in' => absint($category_ids),
					'post__not_in' => array($post->ID),
					'numberposts' => intval($relatedposts_per_page),
		        );
		    }
		}
		if( $related_post_type ) {
	        $related_posts = get_posts($args);
	        if($related_posts) {
	        	foreach ($related_posts as $post) : setup_postdata($post); ?>
		           	<li class="related_post">
		           		<a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('recent-work'); ?></a>
		           		<a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		           	</li>
		        <?php endforeach; }
		    else {
	            echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'tech-literacy' ) . '</li>'; 
			 }
		}else{
			echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'tech-literacy' ) . '</li>';
		}
		wp_reset_postdata();
		
		echo '</ul>';
	}
endif;


/*  Site Layout Option  */
if ( ! function_exists( 'tech_literacy_layout_class' ) ) :
	function tech_literacy_layout_class() {
	     $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); 
		     if( 'fullwidth' == $sidebar_position ) {
		     	echo 'sixteen';
		     }else{
		     	echo 'eleven';
		     }
		     if ( 'no-sidebar' == $sidebar_position ) {
		     	echo ' no-sidebar';
		     }
	}
endif;

/* More tag wrapper */
add_action( 'the_content_more_link', 'tech_literacy_add_more_link_class', 10, 2 );
if ( ! function_exists( 'tech_literacy_add_more_link_class' ) ) :
	function tech_literacy_add_more_link_class($link, $text ) {
		return '<p class="portfolio-readmore"><a class="btn btn-mini more-link" href="'. esc_url(get_permalink()) .'">'.__('Read More','tech-literacy').'</a></p>';
	}
endif;

/* Header video */
add_action('tech_literacy_before_header','tech_literacy_before_header_video');
if(!function_exists('tech_literacy_before_header_video')){
	function tech_literacy_before_header_video() {
		if(function_exists('the_custom_header_markup') ) { ?>
		    <div class="custom-header-media">
				<?php the_custom_header_markup(); ?>
			</div>
	    <?php } 
	}
}

/* Admin notice */
/* Activation notice */
add_action( 'load-themes.php',  'tech_literacy_one_activation_admin_notice'  );

if( !function_exists('tech_literacy_one_activation_admin_notice') ) {
	function tech_literacy_one_activation_admin_notice() {
        global $pagenow;
	    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
	        add_action( 'admin_notices', 'tech_literacy_admin_notice' );
	    } 
	} 
}  

/**
 * Add admin notice when active theme
 *
 * @return bool|null  
 */
function tech_literacy_admin_notice() { ?>
    <div class="updated notice notice-alt notice-success is-dismissible">  
        <p><?php printf( __( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'tech-literacy' ), 'Tech Literacy', esc_url( admin_url( 'themes.php?page=tech_literacy_upgrade' ) ) ); ?></p>
    	<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=tech_literacy_upgrade' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with Tech Literacy', 'tech-literacy' ); ?></a></p>
    </div><?php
}
   
/* search form filter */
add_filter( 'get_search_form', 'tech_literacy_get_search_form' );
if( !function_exists('tech_literacy_get_search_form') ) {
	function tech_literacy_get_search_form($form) {  
        $form = '<div id="theme-live-search"> 
                    <form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
	                    <span class="screen-reader-text">' . _x( 'Search for:', 'label' , 'tech-literacy' ) . '</span>
	                    <input id="search" type="text" class="search-field" placeholder="' . esc_attr_x( 'Have a question? Search here', 'placeholder', 'tech-literacy' ) . '" value="' . get_search_query() . '" name="s" />
	                    <label class="search-submit-wrapper"><input type="submit" class="search-submit" value="'. esc_attr_x( 'Search', 'submit button' ,'tech-literacy' ) .'" /></label>
                        <div id="search_dropdown_list"></div>
                    </form>
                </div>';
        return $form;  
	}  
}       

add_action( 'wp_ajax_nopriv_tech_literacy_search', 'tech_literacy_search' );
add_action( 'wp_ajax_tech_literacy_search', 'tech_literacy_search' );

function tech_literacy_search() {
	$value  = $_POST['text'];
	$output = "<div class='search-wrapper'>";

		$argsAjax = array( 
	         's'  => $value, 
	         'posts_per_page'=> -1 
	    );
  
	    $queryAjax = new WP_Query($argsAjax);
	    if($queryAjax->have_posts()) {
	    	$output = "<div class='search-dd-wrapper'><ul class='search-all-list'>";
		    while ($queryAjax->have_posts()) : $queryAjax->the_post();   
		        $output .= '<li><h5 class="search-title"><i class="fa fa-file-text" aria-hidden="true"></i><a href="' .get_permalink().'">'.get_the_title().'</a></h5>';
		        $output .=  get_the_excerpt() .'</li>';
		    endwhile;
		    $output .= "</ul></div>";
	    }
	    else {
	    	$output .= '<div class="no-page"><h5 class="no-title"><i class="fa fa-file-text" aria-hidden="true"></i>';
	    	$output .= apply_filters('search_section_pagent_found',__('The Searching Page couldn&apos;t found!!','tech-literacy'));
	    	$output .= '</h5></div>';
	    }
	    
	   wp_reset_query();
	$output .= "</div>";
	echo $output;
	die(0);
}