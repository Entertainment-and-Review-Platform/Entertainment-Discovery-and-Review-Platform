<?php get_header(); ?>

<main style="padding: 40px; max-width: 1000px; margin: 0 auto;">

    <h1>Shows / Movies</h1>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #ccc;">

                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div style="margin: 15px 0;">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                <?php endif; ?>

                <p><?php the_excerpt(); ?></p>

                <p><strong>Genre:</strong> <?php the_field('genre'); ?></p>
                <p><strong>Release Year:</strong> <?php the_field('release_year'); ?></p>
                <p><strong>Number of Seasons:</strong> <?php the_field('number_of_seasons'); ?></p>

                <?php if ( get_field('trailer_link') ) : ?>
                    <p>
                        <a href="<?php the_field('trailer_link'); ?>" target="_blank">Watch Trailer</a>
                    </p>
                <?php endif; ?>

            </div>
        <?php endwhile; ?>

        <div style="margin-top: 30px;">
            <?php the_posts_pagination(); ?>
        </div>

    <?php else : ?>
        <p>No shows or movies found.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>