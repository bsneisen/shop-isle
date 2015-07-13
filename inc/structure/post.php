<?php
/**
 * Template functions used for posts.
 *
 * @package storefront
 */

if ( ! function_exists( 'storefront_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 * @since 1.0.0
	 */
	function storefront_post_header() { ?>
		<header class="entry-header">
		<?php
		if ( is_single() ) {
			shop_isle_posted_on();
			the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' );
		} else {
			if ( 'post' == get_post_type() ) {
				shop_isle_posted_on();
			}

			the_title( sprintf( '<h1 class="entry-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
		}
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'storefront_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0.0
	 */
	function storefront_post_content() {
		?>
		<div class="entry-content" itemprop="articleBody">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
		}

		the_content(
			sprintf(
				__( 'Continue reading %s', 'storefront' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
			'after'  => '</div>',
		) );
		?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'storefront_post_meta' ) ) {
	/**
	 * Display the post meta
	 * @since 1.0.0
	 */
	function storefront_post_meta() {
		
		$shop_isle_num_comments = get_comments_number();

		if ( $shop_isle_num_comments == 0 ) {
			$shop_isle_comments = __('No Comments', 'shop-isle');
		} elseif ( $shop_isle_num_comments > 1 ) {
			$shop_isle_comments = $shop_isle_num_comments . __(' Comments','shop-isle');
		} else {
			$shop_isle_comments = __('1 Comment','shop-isle');
		}
		if( !empty($shop_isle_comments) ):
			echo '<a href="' . get_comments_link() .'">'. $shop_isle_comments.'</a> | ';
		endif;	
										
		$shop_isle_categories = get_the_category();
		$separator = ', ';
		$shop_isleoutput = '';
		if($shop_isle_categories){
			foreach($shop_isle_categories as $shop_isle_category) {
				$shop_isleoutput .= '<a href="'.get_category_link( $shop_isle_category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $shop_isle_category->name ) ) . '">'.$shop_isle_category->cat_name.'</a>'.$separator;
			}
			echo trim($shop_isleoutput, $separator);
		}
		
	}
}

if ( ! function_exists( 'storefront_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function storefront_paging_nav() {
		global $wp_query;

		$args = array(
			'type' 		=> 'list',
			'next_text' => __( 'Next', 'shop-isle' ) . '&nbsp;<span class="meta-nav">&rarr;</span>',
			'prev_text'	=> '<span class="meta-nav">&larr;</span>&nbsp' . __( 'Previous', 'shop-isle' ),
			);

		the_posts_pagination( $args );
	}
}

if ( ! function_exists( 'storefront_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function storefront_post_nav() {
		$args = array(
			'next_text' => '%title &nbsp;<span class="meta-nav">&rarr;</span>',
			'prev_text'	=> '<span class="meta-nav">&larr;</span>&nbsp;%title',
			);
		the_post_navigation( $args );
	}
}

if ( ! function_exists( 'shop_isle_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function shop_isle_posted_on() {
		$shop_isle_post_author = get_the_author();
										
		if( !empty($shop_isle_post_author) ):
			echo __('By ','shop-isle').'<a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ).'</a> | ';
		endif;	
										
		$time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s" itemprop="datePublished">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		if( !empty($time_string) ):
			echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a> | ';
		endif;

	}
}
