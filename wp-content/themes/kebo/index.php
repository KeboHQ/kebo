<?php
/**
 * Index Template
 *
 * @package kebo
 */

get_header();
?>

<main id="content">
	<?php
	if ( have_posts() ) :

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();
				get_template_part( 'template-parts/content', get_post_type() );
		endwhile;
		?>
		<div class="post-nav">
			<?php
			the_posts_navigation(
				array(
					'prev_text' => 'Older Posts',
					'next_text' => 'Newer Posts',
				)
			);
			?>
		</div>
		<?php
	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>
</main><!-- #content -->
