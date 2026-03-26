<?php get_header(); ?>

<main style="padding: 40px; max-width: 1000px; margin: 0 auto;">

    <h1>Reviews</h1>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #ccc;">

                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>

                <p><?php the_excerpt(); ?></p>

                <p><strong>Rating:</strong> <?php the_field('rating'); ?>/10</p>
                <p><strong>Review Type:</strong> <?php the_field('review_type'); ?></p>

                <?php
                $related_show = get_field('related_showmovie');
                if ( $related_show ) :?><p>
                    <strong>Related Show / Movie:</strong>
                    <a href="<?php echo get_permalink( $related_show->ID ); ?>">
                        <?php echo esc_html( $related_show->post_title ); ?>
                    </a>
                </p>
                <?php endif; ?>

            </div>
        <?php endwhile; ?>

        <div style="margin-top: 30px;">
            <?php the_posts_pagination(); ?>
        </div>

    <?php else : ?>
        <p>No reviews found.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>