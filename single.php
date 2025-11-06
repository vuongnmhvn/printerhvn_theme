<?php
/**
 * The template for displaying all single posts
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="max-width: 800px;margin: 0 auto">
				
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-thumbnail" style="margin-bottom: 2rem; border-radius: 12px; overflow: hidden;">
						<?php the_post_thumbnail( 'full' ); ?>
					</div>
				<?php endif; ?>

				<header class="entry-header" style="margin-bottom: 2rem;">
					<?php
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;

					if ( 'post' === get_post_type() ) :
						?>
						<div class="entry-meta" style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">
							<?php
							pinterhvn_posted_on();
							pinterhvn_posted_by();
							?>
						</div>
						<?php
					endif;
					?>
				</header>

				<div class="entry-content" style="max-width: 800px;">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pinterhvn-theme' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>

				<footer class="entry-footer" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #f1f5f9;">
					<?php pinterhvn_entry_footer(); ?>
				</footer>

			</article>

			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'pinterhvn-theme' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'pinterhvn-theme' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>

	</div>
</main>

<?php
get_footer();
