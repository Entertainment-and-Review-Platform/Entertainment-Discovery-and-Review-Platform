<?php get_header(); ?>

<div class="container">
    <?php custom_breadcrumbs(); ?>

    <?php if ( have_posts() ) : ?>
        <div class="content-grid">

            <?php while ( have_posts() ) : the_post(); ?>
                <div class="content-card">
                    <a href="<?php the_permalink(); ?>">

                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="card-image">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>

                        <h3><?php the_title(); ?></h3>

                        <p>
                            <?php the_field('content_type'); ?> •
                            <?php the_field('release_year'); ?>
                        </p>

                    </a>
                </div>
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
        <p>No shows or movies found.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
