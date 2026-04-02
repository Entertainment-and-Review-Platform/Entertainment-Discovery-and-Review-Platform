<?php
/*
Plugin Name: Entertainment Shortcodes
Description: Custom shortcodes for latest shows, latest reviews, and featured quiz.
Version: 1.0
Author: Analisa
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* =========================
   LATEST SHOWS SHORTCODE
   Usage: [latest_shows]
========================= */
function ers_latest_shows_shortcode() {
    $query = new WP_Query(array(
        'post_type'      => 'shows',
        'posts_per_page' => 3
    ));

    if ( ! $query->have_posts() ) {
        return '<p>No shows found.</p>';
    }

    ob_start();
    ?>
    <div class="ers-grid">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="ers-card">
                <?php if ( has_post_thumbnail() ) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php endif; ?>

                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                <p>
                    <?php the_field('content_type'); ?>
                    <?php if ( get_field('release_year') ) : ?>
                        • <?php the_field('release_year'); ?>
                    <?php endif; ?>
                </p>

                <a class="ers-button" href="<?php the_permalink(); ?>">View Details</a>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'latest_shows', 'ers_latest_shows_shortcode' );


/* =========================
   LATEST REVIEWS SHORTCODE
   Usage: [latest_reviews]
========================= */
function ers_latest_reviews_shortcode() {
    $query = new WP_Query(array(
        'post_type'      => 'reviews',
        'posts_per_page' => 3
    ));

    if ( ! $query->have_posts() ) {
        return '<p>No reviews found.</p>';
    }

    ob_start();
    ?>
    <div class="ers-grid">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="ers-card">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>

                <?php if ( get_field('rating') ) : ?>
                    <p><strong>Rating:</strong> <?php the_field('rating'); ?>/10</p>
                <?php endif; ?>

                <a class="ers-button" href="<?php the_permalink(); ?>">Read Review</a>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'latest_reviews', 'ers_latest_reviews_shortcode' );


/* =========================
   FEATURED QUIZ SHORTCODE
   Usage: [featured_quiz]
========================= */
function ers_featured_quiz_shortcode() {
    $query = new WP_Query(array(
        'post_type'      => 'quizzes',
        'posts_per_page' => 1
    ));

    if ( ! $query->have_posts() ) {
        return '<p>No quiz found.</p>';
    }

    ob_start();
    ?>
    <div class="ers-grid">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="ers-card">
                <?php if ( has_post_thumbnail() ) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php endif; ?>

                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>

                <a class="ers-button" href="<?php the_permalink(); ?>">Take Quiz</a>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'featured_quiz', 'ers_featured_quiz_shortcode' );


/* =========================
   PLUGIN STYLES
========================= */
function ers_enqueue_styles() {
    $css = '
    .ers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin: 20px 0;
    }

    .ers-card {
        background: #102a43;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.25);
    }

    .ers-card img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
        display: block;
    }

    .ers-card h3 {
        margin: 10px 0;
    }

    .ers-card h3 a {
        color: #ffffff;
        text-decoration: none;
    }

    .ers-card h3 a:hover {
        color: #ff7a00;
    }

    .ers-card p {
        color: #d9e2ec;
        margin-bottom: 12px;
    }

    .ers-button {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 8px;
        background: #ff7a00;
        color: #ffffff !important;
        text-decoration: none;
        font-weight: 600;
    }

    .ers-button:hover {
        background: #e56d00;
        color: #ffffff !important;
    }
    ';

    wp_register_style( 'ers-inline-style', false );
    wp_enqueue_style( 'ers-inline-style' );
    wp_add_inline_style( 'ers-inline-style', $css );
}
add_action( 'wp_enqueue_scripts', 'ers_enqueue_styles' );
