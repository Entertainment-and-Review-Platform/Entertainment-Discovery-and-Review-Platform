<?php
/**
 * Blocksy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blocksy
 */

if (version_compare(PHP_VERSION, '5.7.0', '<')) {
	require get_template_directory() . '/inc/php-fallback.php';
	return;
}

require get_template_directory() . '/inc/init.php';

function create_shows_post_type() {
    register_post_type('shows', array(
        'labels' => array(
            'name' => __('Shows / Movies'),
            'singular_name' => __('Show / Movie'),
            'add_new' => __('Add New Show / Movie'),
            'add_new_item' => __('Add New Show / Movie'),
            'edit_item' => __('Edit Show / Movie'),
            'new_item' => __('New Show / Movie'),
            'view_item' => __('View Show / Movie'),
            'search_items' => __('Search Shows / Movies'),
            'not_found' => __('No Shows / Movies found'),
            'not_found_in_trash' => __('No Shows / Movies found in Trash')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-video-alt2',
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'shows'),
        'show_in_rest' => true
    ));
}
add_action('init', 'create_shows_post_type');

function create_reviews_post_type() {
    register_post_type('reviews', array(
        'labels' => array(
            'name' => __('Reviews'),
            'singular_name' => __('Review'),
            'add_new' => __('Add New Review'),
            'add_new_item' => __('Add New Review'),
            'edit_item' => __('Edit Review'),
            'new_item' => __('New Review'),
            'view_item' => __('View Review'),
            'search_items' => __('Search Reviews'),
            'not_found' => __('No Reviews found'),
            'not_found_in_trash' => __('No Reviews found in Trash')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor', 'thumbnail', 'comments'),
        'rewrite' => array('slug' => 'reviews'),
        'show_in_rest' => true
    ));
}
add_action('init', 'create_reviews_post_type');

function create_quizzes_post_type() {
    register_post_type('quizzes', array(
        'labels' => array(
            'name' => __('Quizzes'),
            'singular_name' => __('Quiz'),
            'add_new' => __('Add New Quiz'),
            'add_new_item' => __('Add New Quiz'),
            'edit_item' => __('Edit Quiz'),
            'new_item' => __('New Quiz'),
            'view_item' => __('View Quiz'),
            'search_items' => __('Search Quizzes'),
            'not_found' => __('No Quizzes found'),
            'not_found_in_trash' => __('No Quizzes found in Trash')
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'quizzes'),
        'show_in_rest' => true
    ));
}
add_action('init', 'create_quizzes_post_type');

function custom_breadcrumbs() {

    echo '<div class="breadcrumbs">';

    echo '<a href="' . home_url() . '">Home</a> > ';

    if ( is_post_type_archive('shows') ) {
        echo 'Shows';
    }

    elseif ( is_singular('shows') ) {
        echo '<a href="' . get_post_type_archive_link('shows') . '">Shows</a> > ';
        the_title();
    }

    elseif ( is_post_type_archive('reviews') ) {
        echo 'Reviews';
    }

    elseif ( is_singular('reviews') ) {
        echo '<a href="' . get_post_type_archive_link('reviews') . '">Reviews</a> > ';
        the_title();
    }

    elseif ( is_post_type_archive('quizzes') ) {
        echo 'Quizzes';
    }

    elseif ( is_singular('quizzes') ) {
        echo '<a href="' . get_post_type_archive_link('quizzes') . '">Quizzes</a> > ';
        the_title();
    }

    elseif ( is_page() ) {
        the_title();
    }

    echo '</div>';
}


