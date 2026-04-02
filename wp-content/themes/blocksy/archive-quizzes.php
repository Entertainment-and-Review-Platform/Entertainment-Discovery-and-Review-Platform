<?php get_header(); ?>

<main class="quiz-archive-page">
    <div class="quiz-archive-container">

        <?php custom_breadcrumbs(); ?>

        <?php if ( have_posts() ) : ?>

            <div class="quiz-grid">

                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="quiz-card">
                        <a href="<?php the_permalink(); ?>" class="quiz-card-link">

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="quiz-card-image">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                </div>
                            <?php endif; ?>

                            <div class="quiz-card-content">
                                <h2 class="quiz-card-title"><?php the_title(); ?></h2>

                                <p class="quiz-card-excerpt">
                                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?>
                                </p>

                                <span class="quiz-card-button">Play Quiz</span>
                            </div>

                        </a>
                    </article>
                <?php endwhile; ?>

            </div>

            <div class="quiz-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ));
                ?>
            </div>

        <?php else : ?>
            <p>No quizzes found.</p>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
