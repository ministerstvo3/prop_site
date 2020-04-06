<?php
/**
 * Single post partial template
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->
<div class="row">
    <div class="col-xs-12 col-sm-6">
	<?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
    </div>
            <div class="col-xs-12 col-sm-6">
                <?php

                $posts = get_posts( array(
                    'post_type' => 'acf-field',
                    'numberposts' => -1,
                    'post_status'     => 'publish',
                    'post_parent'   => '19' //группа мета характеристик недвижимости
                ) );
                foreach( $posts as $p ){
                    if(get_post_meta( get_the_ID($p), strstr(get_the_excerpt($p), ' ', true), true )!=""){
                    echo get_the_title($p).": ".get_post_meta( get_the_ID($p), strstr(get_the_excerpt($p), ' ', true), true )."<br>";
                }}
                ?>
            </div>
</div>
	<div class="entry-content">

		<?php the_content(); ?>
        <?php
        $arr= get_posts( array (
            'post_type' => 'attachment',
            'post_parent' => $post->ID
        ));
        foreach ($arr as $item){ echo wp_get_attachment_image( $item->ID, 'thumbnail'); }


        ?>
		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
