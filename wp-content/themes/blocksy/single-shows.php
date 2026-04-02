<?php get_header(); ?>

<main style="padding: 40px; max-width: 900px; margin: 0 auto;">
    <?php custom_breadcrumbs(); ?>

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

        <h2>Show / Movie Details</h2>
        <p><strong>Content Type:</strong> <?php the_field('content_type'); ?></p>
        <p><strong>Genre:</strong> <?php the_field('genre'); ?></p>
        <p><strong>Release Year:</strong> <?php the_field('release_year'); ?></p>
        
        <?php if ( get_field('content_type') !== 'Movie' ) : ?>
            <p><strong>Number of Seasons:</strong> <?php the_field('number_of_seasons'); ?></p>
            <?php endif; ?>
            
        <?php if ( get_field('trailer_link') ) : ?>
            <p>
                <strong>Trailer Link:</strong>
                <a href="<?php the_field('trailer_link'); ?>" target="_blank">Watch Trailer</a>
            </p>
            <?php endif; ?>
    
    <hr style="margin: 40px 0;">
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
    while ( $reviews_query->have_posts() ) : $reviews_query->the_post();
?>
    <div style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 15px;">
        <h3>
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>
        <p><strong>Rating:</strong> <?php the_field('rating'); ?>/10</p>
    </div>
<?php
    endwhile;
    wp_reset_postdata();
else :
?>
    <p>No reviews yet for this show.</p>
<?php endif; ?>

    <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>