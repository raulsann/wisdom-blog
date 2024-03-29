<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @since 1.0.0
 */
$bavotasan_theme_options = bavotasan_theme_options();
get_header(); ?>

	<?php
	/* Only placed here in pro version
	bavotasan_jumbotron();
	*/
	?>

	<?php bavotasan_home_page_default_widgets(); ?>

	<?php if ( ( $bavotasan_theme_options['home_posts'] && is_front_page() ) || ! is_front_page() ) { ?>
	<div id="primary" <?php bavotasan_primary_attr(); ?>>
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;

			//bavotasan_pagination();
		else :
			?>
			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
				?>
				<h1 class="entry-title"><?php _e( 'No posts to display', 'tonic' ); ?></h1>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'tonic' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

				<?php
			else :
				get_template_part( 'content', 'none' );
			endif; // end current_user_can() check
			?>

			</article><!-- #post-0 -->
		    <?php
		endif;

		if ( ! empty( $bavotasan_theme_options['blog_url'] ) )
			echo '<a href="' . esc_url( $bavotasan_theme_options['blog_url'] ) . '" class="blog-url btn btn-large">' . __( 'View More Posts', 'tonic' ) . '&nbsp;&nbsp;<i class="icon-chevron-sign-right"></i></a>';

		?>
	</div><!-- #primary -->
	<?php } ?>
<?php get_footer(); ?>