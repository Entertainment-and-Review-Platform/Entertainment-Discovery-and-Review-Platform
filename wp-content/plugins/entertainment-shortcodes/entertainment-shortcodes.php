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

/* Latest Shows Shortcode */
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


/* Latest Reviews Shortcode */
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


/* Featured Quiz Shortcode */
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

/* Top Picks Shortcode */
function ers_top_picks_shortcode() {

    $review_query = new WP_Query(array(
        'post_type'      => 'reviews',
        'posts_per_page' => 6,
        'meta_key'       => 'rating',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC'
    ));

    if ( ! $review_query->have_posts() ) {
        return '<p>No top picks found.</p>';
    }

    $shown_ids = array();

    ob_start();
    echo '<div class="ers-grid">';

    while ( $review_query->have_posts() ) {
        $review_query->the_post();

        $related_show = get_field('related_showmovie');

        if ( ! $related_show ) {
            continue;
        }

        $show_id = is_object($related_show) ? $related_show->ID : $related_show;

        if ( in_array($show_id, $shown_ids) ) {
            continue;
        }

        $shown_ids[] = $show_id;

        if ( count($shown_ids) > 3 ) {
            break;
        }

        $content_type = get_field('content_type', $show_id);
        $genre        = get_field('genre', $show_id);
        $release_year = get_field('release_year', $show_id);

        echo '<div class="ers-card">';

        if ( has_post_thumbnail($show_id) ) {
            echo '<a href="' . get_permalink($show_id) . '">';
            echo get_the_post_thumbnail($show_id, 'medium');
            echo '</a>';
        }

        echo '<h3><a href="' . get_permalink($show_id) . '">' . get_the_title($show_id) . '</a></h3>';

        if ( $content_type ) {
            echo '<p><strong>Type:</strong> ' . esc_html($content_type) . '</p>';
        }

        if ( $genre ) {
            echo '<p><strong>Genre:</strong> ' . esc_html($genre) . '</p>';
        }

        if ( $release_year ) {
            echo '<p><strong>Year:</strong> ' . esc_html($release_year) . '</p>';
        }

        echo '<a class="ers-button" href="' . get_permalink($show_id) . '">View Details</a>';

        echo '</div>';
    }

    echo '</div>';

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('ers_top_picks', 'ers_top_picks_shortcode');


/* Plugin Styles */
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

