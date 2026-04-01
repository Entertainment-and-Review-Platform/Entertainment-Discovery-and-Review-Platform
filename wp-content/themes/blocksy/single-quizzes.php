<?php get_header(); ?>

<main style="padding: 40px; max-width: 900px; margin: 0 auto;">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <h1><?php the_title(); ?></h1>

        <div style="margin-bottom: 20px;">
            <?php the_content(); ?>
        </div>

        <hr style="margin: 30px 0;">

        <h2>Quiz Question</h2>

        <p><strong><?php the_field('question_1'); ?></strong></p>

        <div class="quiz-answers">

            <?php if ( get_field('option_a') ) : ?>
                <div class="quiz-option" data-option="a">
                    <?php the_field('option_a'); ?>
                </div>
            <?php endif; ?>

            <?php if ( get_field('option_b') ) : ?>
                <div class="quiz-option" data-option="b">
                    <?php the_field('option_b'); ?>
                </div>
            <?php endif; ?>

            <?php if ( get_field('option_c') ) : ?>
                <div class="quiz-option" data-option="c">
                    <?php the_field('option_c'); ?>
                </div>
            <?php endif; ?>

            <?php if ( get_field('option_d') ) : ?>
                <div class="quiz-option" data-option="d">
                    <?php the_field('option_d'); ?>
                </div>
            <?php endif; ?>

        </div>

        <button id="show-result-btn" class="quiz-result-button" type="button">
            See My Result
        </button>

        <div id="quiz-result" style="display: none; margin-top: 40px;">
            <hr style="margin: 30px 0;">

            <h2>Quiz Result</h2>
            <p><?php the_field('result_text'); ?></p>

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

            <p><strong>Quiz Category:</strong> <?php the_field('quiz_category'); ?></p>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let selectedAnswer = null;

                const options = document.querySelectorAll('.quiz-option');
                const button = document.getElementById('show-result-btn');
                const resultBox = document.getElementById('quiz-result');

                options.forEach(option => {
                    option.addEventListener('click', function () {
                        options.forEach(o => o.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedAnswer = this.getAttribute('data-option');
                    });
                });

                if (button) {
                    button.addEventListener('click', function () {
                        if (!selectedAnswer) {
                            alert('Please select an answer first.');
                            return;
                        }

                        resultBox.style.display = 'block';
                        resultBox.scrollIntoView({ behavior: 'smooth' });
                    });
                }
            });
        </script>

    <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>