<?php get_header(); ?>

<main style="padding: 40px; max-width: 1000px; margin: 0 auto;">

    <h1>Quizzes</h1>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #ccc;">

                <h2>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>

                <p><?php the_excerpt(); ?></p>

                <p><strong>Question:</strong> <?php the_field('question_1'); ?></p>
                <p><strong>Quiz Category:</strong> <?php the_field('quiz_category'); ?></p>

                <?php
                $associated_show = get_field('associated_showmovie');
                if ( $associated_show ) :
                ?>
                    <p>
                        <strong>Recommended Show / Movie:</strong>
                        <a href="<?php echo esc_url( get_permalink( $associated_show->ID ) ); ?>">
                            <?php echo esc_html( get_the_title( $associated_show->ID ) ); ?>
                        </a>
                    </p>
                <?php endif; ?>

            </div>
        <?php endwhile; ?>

        <div style="margin-top: 30px;">
            <?php the_posts_pagination(); ?>
        </div>

    <?php else : ?>
        <p>No quizzes found.</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>