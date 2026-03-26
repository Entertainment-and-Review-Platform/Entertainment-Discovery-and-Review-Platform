<?php get_header(); ?>

<main style="padding: 40px; max-width: 900px; margin: 0 auto;">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <h1><?php the_title(); ?></h1>

        <?php if ( has_post_thumbnail() ) : ?>
            <div style="margin: 20px 0;">
                <?php the_post_thumbnail('medium'); ?>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <?php the_content(); ?>
        </div>

        <hr style="margin: 30px 0;">

        <h2>Review Details</h2>

        <p><strong>Rating:</strong> <?php the_field('rating'); ?>/10</p>
        <p><strong>Review Type:</strong> <?php the_field('review_type'); ?></p>

        <?php
        $related_show = get_field('related_showmovie');
        if ( $related_show ) :
        ?>
        <p>
            <strong>Related Show / Movie:</strong>
            <a href="<?php echo esc_url( get_permalink( $related_show->ID ) ); ?>">
            <?php echo esc_html( get_the_title( $related_show->ID ) ); ?>
        </a>
    </p>
    <?php endif; ?>

        <?php if ( get_field('embedded_trailer') ) : ?>
            <p>
                <strong>Trailer:</strong>
                <a href="<?php the_field('embedded_trailer'); ?>" target="_blank">Watch Trailer</a>
            </p>
        <?php endif; ?>

    <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
