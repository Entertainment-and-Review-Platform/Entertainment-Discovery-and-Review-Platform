<?php get_header(); ?>

<main class="single-show-page">
    <?php custom_breadcrumbs(); ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <div class="single-show-container">

            <div class="single-show-layout">

                <div class="single-show-left">

                    <h1 class="single-show-title"><?php the_title(); ?></h1>

                    <div class="single-show-text">
                        <?php the_content(); ?>
                    </div>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="single-show-poster">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="single-show-right">

                    <div class="single-show-panel">

                        <h2>Show / Movie Details</h2>

                        <p><strong>Content Type:</strong> <?php the_field('content_type'); ?></p>
                        <p><strong>Genre:</strong> <?php the_field('genre'); ?></p>
                        <p><strong>Release Year:</strong> <?php the_field('release_year'); ?></p>

                        <?php if ( get_field('content_type') !== 'Movie' ) : ?>
                            <p><strong>Number of Seasons:</strong> <?php the_field('number_of_seasons'); ?></p>
                        <?php endif; ?>

                        <?php $watch_link = get_field('watch_now'); ?>
                        
                        <?php if ( ! empty( $watch_link ) ) : ?>
                            <a href="<?php echo esc_url( $watch_link ); ?>" target="_blank" class="btn-primary watch-btn">
                                  ▶ Watch Now
                                </a>
                                <?php endif; ?>

                            <?php if ( get_field('trailer_link') ) : ?>
                                <a href="<?php the_field('trailer_link'); ?>" target="_blank" class="btn-secondary trailer-btn">
                                    🎬 Watch Trailer
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="single-show-actions">
                            <a href="<?php echo esc_url( get_post_type_archive_link('shows') ); ?>" class="single-show-btn back-btn">
                                Back to Shows
                            </a>
                        </div>

                    </div>

                </div>

            </div>

            <hr>

            <div class="single-show-reviews">
                <h2>Reviews for this Show</h2>

                <?php
                $current_show_id = get_the_ID();

                $args = array(
                    'post_type'      => 'reviews',
                    'posts_per_page' => -1,
                    'meta_query'     => array(
                        array(
                            'key'     => 'related_showmovie',
                            'value'   => $current_show_id,
                            'compare' => '='
                        )
                    )
                );

                $reviews_query = new WP_Query($args);

                if ( $reviews_query->have_posts() ) :
                    echo '<div class="show-reviews-grid">';

                    while ( $reviews_query->have_posts() ) : $reviews_query->the_post();
                ?>
                        <div class="show-review-card">
                            <h3>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <p><strong>Rating:</strong> <?php the_field('rating'); ?>/10</p>
                            <a href="<?php the_permalink(); ?>" class="show-review-btn">Read Review</a>
                        </div>
                <?php
                    endwhile;

                    echo '</div>';
                    wp_reset_postdata();
                else :
                ?>
                    <p>No reviews yet for this show.</p>
                <?php endif; ?>
            </div>

        </div>

    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
