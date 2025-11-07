<?php
/**
 * The template for displaying archive pages
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">

		<?php if ( have_posts() ) : ?>

			<header class="page-header" style="margin-bottom: 2rem;">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header>

			<div class="archive-posts">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-item' ); ?> style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 2rem;">
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="post-thumbnail" style="margin-bottom: 1rem; border-radius: 8px; overflow: hidden;">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium' ); ?>
								</a>
							</div>
						<?php endif; ?>

						<header class="entry-header">
							<?php the_title( '<h2 class="entry-title" style="margin-bottom: 0.5rem;"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
							
							<?php if ( 'post' === get_post_type() ) : ?>
								<div class="entry-meta" style="color: #64748b; font-size: 0.875rem; margin-bottom: 1rem;">
									<?php
									pinterhvn_posted_on();
									pinterhvn_posted_by();
									?>
								</div>
							<?php endif; ?>
						</header>

						<div class="entry-summary">
							<?php the_content( esc_html__( 'Read More →', 'pinterhvn-theme' ) ); ?>
						</div>

					</article>
					<?php
				endwhile;
				?>
			</div>

			<?php
			// Hidden pagination for infinite scroll
			echo '<div style="display: none;">';
			pinterhvn_pagination();
			echo '</div>';
			?>

		<?php else : ?>

			<div class="no-results" style="text-align: center; padding: 4rem 2rem;">
				<h2><?php esc_html_e( 'Nothing Found', 'pinterhvn-theme' ); ?></h2>
				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'pinterhvn-theme' ); ?></p>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
