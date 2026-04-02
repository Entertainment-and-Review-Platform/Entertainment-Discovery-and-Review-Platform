<?php get_header(); ?>

<main class="reviews-archive-page">
    <div class="reviews-archive-container">

        <?php custom_breadcrumbs(); ?>

        <?php if ( have_posts() ) : ?>
            <div class="reviews-grid">

                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                    $rating = get_field('rating');
                    $stars = round($rating / 2);
                    $related_show = get_field('related_showmovie');
                    ?>

                    <article class="review-card">
                        <a href="<?php the_permalink(); ?>" class="review-card-link">
                            <div class="review-card-content">

                                <h2 class="review-card-title"><?php the_title(); ?></h2>

                                <p class="review-card-excerpt">
                                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?>
                                </p>

                                <div class="review-stars">
                                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                        <span class="star <?php echo ( $i <= $stars ) ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                </div>

                                <div class="review-card-meta">
                                    <?php if ( get_field('review_type') ) : ?>
                                        <span class="review-type-badge"><?php the_field('review_type'); ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php if ( $related_show ) : ?>
                                    <p class="review-card-show">
                                        <strong>Related Show / Movie:</strong>
                                        <?php echo esc_html( get_the_title( $related_show->ID ) ); ?>
                                    </p>
                                <?php endif; ?>

                                <span class="review-card-button">Read Review</span>

                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>

            </div>

            <div class="archive-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ));
                ?>
            </div>

        <?php else : ?>
            <p>No reviews found.</p>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
