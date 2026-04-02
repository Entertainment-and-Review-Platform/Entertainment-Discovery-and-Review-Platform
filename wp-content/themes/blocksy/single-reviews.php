<?php get_header(); ?>

<main class="single-review-page">
    <?php custom_breadcrumbs(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php
$rating = get_field('rating');
$stars  = round($rating / 2);
$related_show = get_field('related_showmovie');
?>

<div class="single-review-container">

    <div class="single-review-layout">

        <!-- LEFT SIDE -->
        <div class="single-review-left">

            <h1 class="single-review-title"><?php the_title(); ?></h1>

            <div class="single-review-text">
                <?php the_content(); ?>
            </div>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="single-review-poster">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- RIGHT SIDE -->
        <div class="single-review-right">

            <div class="single-review-panel">

                <div class="review-stars">
                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <span class="star <?php echo ($i <= $stars) ? 'filled' : ''; ?>">★</span>
                    <?php endfor; ?>
                </div>

                <div class="single-review-highlight">
                    <?php echo wp_trim_words( get_the_content(), 20 ); ?>
                </div>

                <?php if ( $related_show ) : ?>
                    <p class="single-review-related">
                        <strong>Related Show / Movie:</strong><br>
                        <a href="<?php echo esc_url( get_permalink( $related_show->ID ) ); ?>">
                            <?php echo esc_html( get_the_title( $related_show->ID ) ); ?>
                        </a>
                    </p>
                <?php endif; ?>

                <div class="single-review-actions">

                    <a href="<?php echo esc_url( get_post_type_archive_link('reviews') ); ?>" class="single-review-btn back-btn">
                        Back to Reviews
                    </a>

                    <?php if ( get_field('embedded_trailer') ) : ?>
                        <a href="<?php the_field('embedded_trailer'); ?>" target="_blank" class="single-review-btn trailer-btn">
                            Watch Trailer
                        </a>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>
<?php if ( comments_open() || get_comments_number() ) : ?>
    <?php comments_template(); ?>
<?php endif; ?>

<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>



