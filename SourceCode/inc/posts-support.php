<?php
/**
 * DigitalZen Theme Posts Customizer
 *
 * @package DigitalZen
 */

/**
 * Get custom status for the Theme Customizer.
 *
 * @param string $authordata author data.
 * @param bool   $is_excerpt Indicates whether the post is an excerpt.
 * @param bool   $show_rss Indicated whether to show rss or not.
 */
function digitalzen_get_status_line( $authordata, $is_excerpt = true, $show_rss = true ) {
	$author_id  = get_the_author_meta( 'ID' );
	$author     = get_author_posts_url( $author_id );
	$author_tip = sprintf(
		/* translators: 1: view all post by author. */
		__( 'View all posts by %s', 'digital-zen' ),
		$authordata->display_name
	);
	$categories = get_the_category_list( ', ' );
	$tags       = get_the_tag_list( '', ', ' );

	if ( true === $show_rss ) {
		$url  = esc_url( get_post_comments_feed_link() );
		$ping = get_trackback_url();
		$rss  = '<li><span class="fa fa-rss"></span><a href="' . $url .
			'">RSS</a></li>' .
			'<li><span class="fa fa-thumbs-o-up"></span><a href="' . $ping .
			'">PING</a></li>';
	} else {
		$rss = '';
	}

	if ( true === $is_excerpt ) {
		$link = 'Read more';
	} else {
		$link = 'Bookmark';
	}
	?>
					<ul class="meta-info-cells v2" style="float: left">
						<li>
							<span class="fa fa-user"></span>
							<span class="author vcard">
								<a class="url fn n" href="<?php echo esc_attr( $author ); ?>"
								title="<?php echo esc_attr( $author_tip ); ?>">
								<?php the_author(); ?></a>
							</span>
						</li>
						<li><span class="fa fa-calendar"></span> <?php the_time( 'Y-m-d' ); ?></li>
						<li><span class="fa fa-file"></span><?php echo esc_attr( $categories ); ?></li>
						<li><span class="fa fa-tags"></span><?php echo esc_attr( $tags ); ?></li>
						<?php echo wp_kses_post( $rss ); ?>
						<li class="pull-right"><a href="<?php the_permalink(); ?>" class="btn-link"><?php echo esc_attr( $link ); ?></a></li>
					</ul>
	<?php
}

/**
 * Get custom status for the Theme Customizer.
 *
 * @param string $authordata author data.
 * @param bool   $show_other_categories Indicates whether to show other categories.
 */
function digitalzen_get_the_loop( $authordata, $show_other_categories ) {
	while ( have_posts() ) {
		the_post();
		?>
				<div class="row">
					<div class="col-md-12 begin end">
						<h2>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="block-content">
							<?php the_excerpt(); ?>
						</div>
						<br />

		<?php digitalzen_get_status_line( $authordata ); ?>
					</div>
				</div>
		<?php
	}
	?>
	<br />
	<br />
	<?php
}
