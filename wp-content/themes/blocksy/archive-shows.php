<?php get_header(); ?>

<div class="container">
    <h1 class="page-title">Browse Entertainment</h1>

    <div class="content-grid">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div class="content-card">
                <a href="<?php the_permalink(); ?>">

                    <?php if (has_post_thumbnail()) : ?>
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

        <?php endwhile; endif; ?>

    </div>
</div>

<?php get_footer(); ?>