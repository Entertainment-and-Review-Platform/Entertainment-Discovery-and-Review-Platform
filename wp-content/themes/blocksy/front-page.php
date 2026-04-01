<?php get_header(); ?>

<main class="home-page">

    <?php
    // HERO CAROUSEL (Featured Shows)
    $featured_args = array(
        'post_type'      => 'shows',
        'posts_per_page' => 3
    );
    $featured_query = new WP_Query($featured_args);
    ?>

    <?php if ( $featured_query->have_posts() ) : ?>
        <section class="hero-section">
            <div class="hero-carousel">

                <?php $slide_index = 0; ?>
                <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
                    <div class="hero-slide <?php echo $slide_index === 0 ? 'active' : ''; ?>">

                        <div class="hero-overlay">

                            <div class="hero-content">
                                <h1><?php the_title(); ?></h1>

                                <p class="hero-meta">
                                    <span><strong>Type:</strong> <?php the_field('content_type'); ?></span>
                                    <span><strong>Genre:</strong> <?php the_field('genre'); ?></span>
                                    <span><strong>Year:</strong> <?php the_field('release_year'); ?></span>

                                    <?php if ( get_field('content_type') !== 'Movie' ) : ?>
                                        <span><strong>Seasons:</strong> <?php the_field('number_of_seasons'); ?></span>
                                    <?php endif; ?>
                                </p>

                                <div class="hero-description">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="hero-buttons">
                                    <a href="<?php the_permalink(); ?>" class="btn-primary">View Details</a>

                                    <?php if ( get_field('trailer_link') ) : ?>
                                        <a href="<?php the_field('trailer_link'); ?>" target="_blank" class="btn-secondary">Watch Trailer</a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="hero-poster">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                    <?php $slide_index++; ?>
                <?php endwhile; wp_reset_postdata(); ?>

                <!-- Navigation -->
                <button class="hero-nav hero-prev">&#10094;</button>
                <button class="hero-nav hero-next">&#10095;</button>

                <!-- Dots -->
                <div class="hero-dots">
                    <?php for ( $i = 0; $i < $slide_index; $i++ ) : ?>
                        <span class="hero-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
                    <?php endfor; ?>
                </div>

            </div>
        </section>

        <!-- CAROUSEL SCRIPT -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const slides = document.querySelectorAll('.hero-slide');
                const dots = document.querySelectorAll('.hero-dot');
                const prevBtn = document.querySelector('.hero-prev');
                const nextBtn = document.querySelector('.hero-next');

                let currentSlide = 0;
                let interval;

                function showSlide(index) {
                    slides.forEach((slide, i) => {
                        slide.classList.toggle('active', i === index);
                    });

                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === index);
                    });

                    currentSlide = index;
                }

                function nextSlide() {
                    let next = currentSlide + 1;
                    if (next >= slides.length) next = 0;
                    showSlide(next);
                }

                function prevSlide() {
                    let prev = currentSlide - 1;
                    if (prev < 0) prev = slides.length - 1;
                    showSlide(prev);
                }

                function startAutoSlide() {
                    interval = setInterval(nextSlide, 5000);
                }

                function resetAutoSlide() {
                    clearInterval(interval);
                    startAutoSlide();
                }

                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    resetAutoSlide();
                });

                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    resetAutoSlide();
                });

                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        showSlide(index);
                        resetAutoSlide();
                    });
                });

                startAutoSlide();
            });
        </script>

    <?php endif; ?>

    <?php
    // Latest Shows / Movies
    $shows_args = array(
        'post_type'      => 'shows',
        'posts_per_page' => 6
    );
    $shows_query = new WP_Query($shows_args);
    ?>

    <section class="homepage-section">
        <h2>Latest Shows / Movies</h2>
        <div class="card-grid">
            <?php if ( $shows_query->have_posts() ) : ?>
                <?php while ( $shows_query->have_posts() ) : $shows_query->the_post(); ?>
                    <div class="content-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php endif; ?>
                            <h3><?php the_title(); ?></h3>
                        </a>
                        <p><strong>Type:</strong> <?php the_field('content_type'); ?></p>
                        <p><strong>Genre:</strong> <?php the_field('genre'); ?></p>
                        <p><strong>Year:</strong> <?php the_field('release_year'); ?></p>

                        <?php if ( get_field('content_type') !== 'Movie' ) : ?>
                            <p><strong>Seasons:</strong> <?php the_field('number_of_seasons'); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <p>No shows found.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php
    // Latest Reviews
    $reviews_args = array(
        'post_type'      => 'reviews',
        'posts_per_page' => 3
    );
    $reviews_query = new WP_Query($reviews_args);
    ?>

    <section class="homepage-section">
        <h2>Latest Reviews</h2>
        <div class="card-grid reviews-grid">
            <?php if ( $reviews_query->have_posts() ) : ?>
                <?php while ( $reviews_query->have_posts() ) : $reviews_query->the_post(); ?>
                    <div class="content-card review-card">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php the_excerpt(); ?></p>
                        <p><strong>Rating:</strong> <?php the_field('rating'); ?>/10</p>

                        <?php
                        $related_show = get_field('related_showmovie');
                        if ( $related_show ) :
                        ?>
                            <p>
                                <strong>Show:</strong>
                                <a href="<?php echo esc_url( get_permalink( $related_show->ID ) ); ?>">
                                    <?php echo esc_html( get_the_title( $related_show->ID ) ); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <p>No reviews found.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php
    // Featured Quiz
    $quiz_args = array(
        'post_type'      => 'quizzes',
        'posts_per_page' => 1
    );
    $quiz_query = new WP_Query($quiz_args);
    ?>

    <section class="homepage-section featured-quiz-section">
        <h2>Try a Quiz</h2>
        <?php if ( $quiz_query->have_posts() ) : ?>
            <?php while ( $quiz_query->have_posts() ) : $quiz_query->the_post(); ?>
                <div class="featured-quiz-card">
                    <h3><?php the_title(); ?></h3>
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn-primary">Take Quiz</a>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
            <p>No quizzes found.</p>
        <?php endif; ?>
    </section>

</main>

<?php get_footer(); ?>
