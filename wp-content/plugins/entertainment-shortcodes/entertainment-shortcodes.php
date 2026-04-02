<?php
/**
 * Plugin Name: Entertainment Shortcodes
 * Description: Custom shortcodes for latest shows, latest reviews, and a featured quiz.
 * Version: 1.0
 * Author: Team Project
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* =========================================
   SHORTCODE 1: Latest Shows
   Usage: [latest_shows limit="3"]
========================================= */
function ers_latest_shows_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'limit' => 3,
        ),
        $atts,
        'latest_shows'
    );

    $shows_query = new WP_Query( array(
        'post_type'      => 'shows',
        'posts_per_page' => intval( $atts['limit'] ),
    ) );

    ob_start();

    if ( $shows_query->have_posts() ) {
        echo '<div class="ers-grid ers-shows-grid">';

        while ( $shows_query->have_posts() ) {
            $shows_query->the_post();

            echo '<div class="ers-card ers-show-card">';

            if ( has_post_thumbnail() ) {
                echo '<a href="' . esc_url( get_permalink() ) . '">';
                the_post_thumbnail( 'medium' );
                echo '</a>';
            }

            echo '<h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';

            $content_type = get_field( 'content_type' );
            $release_year = get_field( 'release_year' );

            if ( $content_type || $release_year ) {
                echo '<p>';
                if ( $content_type ) {
                    echo esc_html( $content_type );
                }
                if ( $content_type && $release_year ) {
                    echo ' • ';
                }
                if ( $release_year ) {
                    echo esc_html( $release_year );
                }
                echo '</p>';
            }

            echo '</div>';
        }

        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No shows found.</p>';
    }

    return ob_get_clean();
}
add_shortcode( 'latest_shows', 'ers_latest_shows_shortcode' );


/* =========================================
   SHORTCODE 2: Latest Reviews
   Usage: [latest_reviews limit="3"]
========================================= */
function ers_latest_reviews_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'limit' => 3,
        ),
        $atts,
        'latest_reviews'
    );

    $reviews_query = new WP_Query( array(
        'post_type'      => 'reviews',
        'posts_per_page' => intval( $atts['limit'] ),
    ) );

    ob_start();

    if ( $reviews_query->have_posts() ) {
        echo '<div class="ers-grid ers-reviews-grid">';

        while ( $reviews_query->have_posts() ) {
            $reviews_query->the_post();

            echo '<div class="ers-card ers-review-card">';
            echo '<h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
            echo '<p>' . esc_html( wp_trim_words( get_the_excerpt(), 18 ) ) . '</p>';

            $rating = get_field( 'rating' );
            if ( $rating ) {
                echo '<p><strong>Rating:</strong> ' . esc_html( $rating ) . '/10</p>';
            }

            $related_show = get_field( 'related_showmovie' );
            if ( $related_show ) {
                echo '<p><strong>Related Show / Movie:</strong> ' . esc_html( get_the_title( $related_show->ID ) ) . '</p>';
            }

            echo '<a class="ers-button" href="' . esc_url( get_permalink() ) . '">Read Review</a>';
            echo '</div>';
        }

        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No reviews found.</p>';
    }

    return ob_get_clean();
}
add_shortcode( 'latest_reviews', 'ers_latest_reviews_shortcode' );


/* =========================================
   SHORTCODE 3: Featured Quiz
   Usage: [featured_quiz]
========================================= */
function ers_featured_quiz_shortcode() {
    $quiz_query = new WP_Query( array(
        'post_type'      => 'quizzes',
        'posts_per_page' => 1,
    ) );

    ob_start();

    if ( $quiz_query->have_posts() ) {
        while ( $quiz_query->have_posts() ) {
            $quiz_query->the_post();

            echo '<div class="ers-card ers-featured-quiz">';

            if ( has_post_thumbnail() ) {
                echo '<div class="ers-quiz-image">';
                echo '<a href="' . esc_url( get_permalink() ) . '">';
                the_post_thumbnail( 'medium_large' );
                echo '</a>';
                echo '</div>';
            }

            echo '<h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
            echo '<p>' . esc_html( wp_trim_words( get_the_excerpt(), 20 ) ) . '</p>';
            echo '<a class="ers-button" href="' . esc_url( get_permalink() ) . '">Take Quiz</a>';

            echo '</div>';
        }

        wp_reset_postdata();
    } else {
        echo '<p>No quiz found.</p>';
    }

    return ob_get_clean();
}
add_shortcode( 'featured_quiz', 'ers_featured_quiz_shortcode' );


/* =========================================
   BASIC STYLES
========================================= */
function ers_enqueue_styles() {
    $custom_css = "
    .ers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
        height: auto;
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
    ";

    wp_register_style( 'ers-inline-style', false );
    wp_enqueue_style( 'ers-inline-style' );
    wp_add_inline_style( 'ers-inline-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ers_enqueue_styles' );

