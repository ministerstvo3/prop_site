<?php
/**
 * Template Name: Главная Страница
 * The main template file.
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

    <div class="wrapper" id="page-wrapper">

        <div class="<?php echo esc_attr( $container ); ?>" id="content">

            <div class="row">

                <div
                        class="<?php if ( is_active_sidebar( 'right-sidebar' ) ) : ?>col-md-8<?php else : ?>col-md-12<?php endif; ?> content-area"
                        id="primary">

                    <main class="site-main" id="main" role="main">
                        <h2>Последние 5 добавленных. </h2>

                        <?php
                        $posts = get_posts( array(
                            'numberposts' => 5,
                            'orderby'     => 'date',
                            'order'       => 'asc',
                            'post_status'     => 'publish',
                            'post_type'   => 'the_property'
                        ) );

                        foreach( $posts as $post ){
                            if(function_exists('get_item_block')){get_item_block($post);}//customize plugin}
                        }

                        ?> <h2>Города. </h2> <?php

                        $posts = get_posts( array(
                            'numberposts' => 5,
                            'orderby'     => 'title',
                            'order'       => 'asc',
                            'post_status'     => 'publish',
                            'post_type'   => 'cities'
                        ) );
                        foreach( $posts as $post ){
                            if(function_exists('get_item_block')){get_item_block($post);}//customize plugin}
                        }
                        ?>
                        <?php if(function_exists('get_form_for_add_property')){get_form_for_add_property(); } //customize plugin}?>
                    </main><!-- #main -->

                </div><!-- #primary -->

                <?php get_template_part( 'sidebar-templates/sidebar', 'right' ); ?>

            </div><!-- .row -->

        </div><!-- #content -->

    </div><!-- #page-wrapper -->

<?php get_footer();
